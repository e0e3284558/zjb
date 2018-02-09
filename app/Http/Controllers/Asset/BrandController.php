<?php

namespace App\Http\Controllers\Asset;

use App\Http\Requests\BrandRequest;
use App\Models\Asset\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('brand.index')){
            return $res;
        }
        //获取所有部门信息
        if (request('tree') == 1) {
            $select = $request->select;
            $name = $request->name;
            $where = [];
            if ($name) {
                $where[] = ['name', 'like', "%{$name}%"];
            }
            $list = Brand::orgs()->where($where)->get()->toArray();
            $org = get_current_login_user_org_info('name')->name;
            $tempData = [
                [
                    'id' => 0,
                    'pid' => -1,
                    'text' => $org,
                    'name' => $org,
                    'href' => '',//编辑地址
                    'icon' => asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/global.gif')
                ]
            ];
            if ($list) {
                foreach ($list as $key => $val) {
                    $val['href'] = url('brand/' . $val['id'] . '/edit');
                    $val['icon'] = asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/sub.gif');
                    $tempData[] = $val;
                }
            }
            return response()->json($tempData);
        }
        return view('asset.brand.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('brand.add')){
            return $res;
        }
        return response()->view("asset.brand.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BrandRequest $request)
    {
        if ($res = is_permission('brand.add')){
            return $res;
        }
        $org_id = get_current_login_user_org_id();
        //单位场地code进行唯一性验证
        Validator::make($request->all(), [
            'code' => [
                'required',
                Rule::unique('brands')->where(function ($query) use ($org_id) {
                    $query->where('org_id', $org_id);
                })
            ]
        ], ['code.unique' => '场地编码已存在'])->validate();
        $brand = new Brand();
        $brand->name = $request->name;
        $brand->status = $request->status;
        $brand->pid = $request->pid;
        $brand->remarks = $request->remarks;
        $brand->code = $request->code;
        $brand->org_id = $org_id;
        $brand->uuid = Uuid::generate()->string;
        //场地父级path设置
        $brand->path = '';
        if ($brand->save()) {
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => $brand->toArray(), 'url' => url('users/departments?tree=1&select=' . $brand->id)
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '保存失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('brand.edit')){
            return $res;
        }
        $dep = Brand::orgs()->findOrFail($id);
        return view('asset.brand.edit', ['brand' => $dep]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BrandRequest $request, $id)
    {
        if ($res = is_permission('brand.edit')){
            return $res;
        }
        $brand = Brand::orgs()->findOrFail($id);
        $brand->name = $request->name;
        $brand->pid = $request->pid;
//        $brand->sort = $request->sort;
        $brand->status = $request->status;
        $brand->remarks = $request->remarks;
//        $brand->code = $request->code;
        $brand->path = '';
        if ($brand->save()) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => $brand->toArray(), 'url' => url('area?tree=1&select=' . $id)
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '编辑失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($res = is_permission('brand.del')){
            return $res;
        }
        $result = [
            'status' => 1,
            'message' => '操作成功',
            'data' => '',
            'url' => '',
        ];
        $dp = Brand::orgs()->findOrFail($id);
        if ($dp) {
            $flag = 1;
            //判断是否有子品牌
            if (Brand::where(['pid' => $id])->first()) {
                $result['status'] = 0;
                $result['message'] = '存在子品牌信息不能删除';
                $flag = 0;
            }
            //删除
            if ($flag && !$dp->delete()) {
                $result['status'] = 0;
                $result['message'] = '删除失败';
            }
        } else {
            $result['status'] = 0;
            $result['message'] = '操作的信息不存在';
        }
        return response()->json($result);
    }


    /**
     * 品牌管理  数据导出
     */
    public function export()
    {

        $list = Brand::orgs()->get();
        $cellData = [
            ['编码', '名称', '上级品牌', '备注', '状态']
        ];
        $arr = [];
        foreach ($list as $key => $value) {
            $arr['code'] = $value->code;
            $arr['name'] = $value->name;

            $arr['remarks'] = $value->remarks;
            $arr['status'] = $value->status ? '可用':'不可用';
            array_push($cellData, $arr);
        }
        Excel::create('品牌列表_' . date("YmdHis"), function ($excel) use ($cellData) {
            $excel->sheet('品牌数据', function ($sheet) use ($cellData) {
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40
                ));
                $sheet->cells('A1:C1', function ($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($cellData);
            });
        })->export('xlsx');
        return;
    }


    /**
     * @return Response
     */
    public function add_import()
    {
        return response()->view('asset.brand.add_import');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $message = [
            'status'=>'1',
            'message'=> '数据导入成功'
        ];

        $filePath = $request->file_path;
        $error_data = [];
        $success_data = [];
        //判断文件是否是excel文件
        if (stripos($filePath, '.xls') === false && stripos($filePath, '.xlsx') === false) {
            $message['code'] = 0;
            $message['message'] = '请上传xls或xlsx后缀的文件';
        } else {
            Excel::selectSheetsByIndex(0)->load($filePath, function ($reader) use (&$error_data, &$success_data) {
                $data = $reader->limitRows(1000, 0); //一次导入1000行
                $arr = $data->toArray();
                $org_id = get_current_login_user_org_id();
                if ($arr) {
                    foreach ($arr as $k => $v) {
                        $brand = new Brand();
                        $brand->code = $v['编码'];
                        //检测编码是否已存在
                        if ($brand->where('code', $v['编码'])->where('org_id', $org_id)->first()) {
                            $v['message'] = '编码已存在';
                            $error_data[] = $v;
                            continue;
                        }

                        $brand->name = $v['名称'];
                        //获取父级品牌信息，获取父级品牌id
                        $p_brand = explode('/', $v['上级品牌']);
                        if ($p_brand) {
                            $pid = 0;
                            $is_have_pid = 0;
                            foreach ($p_brand as $ks => $vs) {
                                $p_brand_info = $brand->where('pid', $pid)->where('name', $vs)->where('org_id', $org_id)->first();
                                if ($p_brand_info) {
                                    $is_have_pid = 1;
                                    $pid = $p_brand_info->id; //子级的pid
                                } else {
                                    $is_have_pid = 0;
                                    break;
                                }
                            }
                            if (!$is_have_pid) {
                                $v['message'] = '上级场地不存在';
                                $error_data[] = $v;
                                continue;
                            }
                        } else {
                            $pid = 0;
                        }
                        $brand->pid = $pid;
                        $brand->org_id = $org_id;
                        $brand->remarks = $v['备注'];
                        $brand->status = $v['状态'] == '不可用' ? 0 : 1;
                        $brand->uuid = Uuid::generate()->string;
                        //获取所有父级id路径

                        $brand->path = '';
                        if ($brand->save()) {
                            $success_data[] = $brand->toArray();
                        } else {
                            $v['message'] = '数据库写入失败';
                            $error_data[] = $v;
                        }
                    }
                }
            });

        }
        $message['data'] = ['success_data' => $success_data, 'error_data' => $error_data];
        return response()->json($message);
    }

}
