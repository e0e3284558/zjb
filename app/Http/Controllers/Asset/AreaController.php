<?php

namespace App\Http\Controllers\Asset;

use App\Http\Requests\AreaRequest;
use App\Models\Asset\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Webpatser\Uuid\Uuid;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('area.index')){
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
            $list = Area::orgs()->where($where)->get()->toArray();
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
                    $val['href'] = url('area/' . $val['id'] . '/edit');
                    $val['icon'] = asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/sub.gif');
                    $tempData[] = $val;
                }
            }
            return response()->json($tempData);
        }
        return view('asset.area.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('area.add')){
            return $res;
        }
        return response()->view("asset.area.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        if ($res = is_permission('area.add')){
            return $res;
        }
        $org_id = get_current_login_user_org_id();
        //单位场地code进行唯一性验证
        Validator::make($request->all(), [
            'code' => [
                'required',
                Rule::unique('areas')->where(function ($query) use ($org_id) {
                    $query->where('org_id', $org_id);
                })
            ]
        ], ['code.unique' => '场地编码已存在'])->validate();
        $area = new Area();
        $area->name = $request->name;
        $area->status = $request->status;
//        $area->sort = $request->sort;
        $area->pid = $request->pid;
        $area->remarks = $request->remarks;
        $area->code = $request->code;
        $area->org_id = $org_id;
        $area->uuid = Uuid::generate()->string;
        //场地父级path设置
        $area->path = '';
        if ($area->save()) {
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => $area->toArray(), 'url' => url('users/departments?tree=1&select=' . $area->id)
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('area.edit')){
            return $res;
        }
        $dep = Area::orgs()->findOrFail($id);
        return view('asset.area.edit', ['area' => $dep]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {
        if ($res = is_permission('area.edit')){
            return $res;
        }
        $area = Area::orgs()->findOrFail($id);
        $area->name = $request->name;
        $area->pid = $request->pid;
//        $area->sort = $request->sort;
        $area->status = $request->status;
        $area->remarks = $request->remarks;
//        $area->code = $request->code;
        $area->path = '';
        if ($area->save()) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => $area->toArray(), 'url' => url('area?tree=1&select=' . $id)
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($res = is_permission('area.del')){
            return $res;
        }
        $result = [
            'status' => 1,
            'message' => '操作成功',
            'data' => '',
            'url' => '',
        ];
        $dp = Area::orgs()->findOrFail($id);
        if ($dp) {
            $flag = 1;
            //判断是否有子部门
            if (Area::where(['pid' => $id])->first()) {
                $result['status'] = 0;
                $result['message'] = '存在子场地信息不能删除';
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
     * 场地管理  数据导出
     */
    public function export()
    {

        $list = Area::orgs()->get();
        $cellData = [
            ['编码', '名称', '上级场地', '备注', '状态']
        ];
        $arr = [];
        foreach ($list as $key => $value) {
            $arr['code'] = $value->code;
            $arr['name'] = $value->name;

            $arr['remarks'] = $value->remarks;
            $arr['status'] = $value->status ? '可用':'不可用';
            array_push($cellData, $arr);
        }
        Excel::create('场地列表_' . date("YmdHis"), function ($excel) use ($cellData) {
            $excel->sheet('场地数据', function ($sheet) use ($cellData) {
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
     * 下载模板
     */
    /*public function downloadModel()
    {
        $cellData = [['场地名称','父类','场地备注']];
        $cellData2 = [['场地名称','场地编号']];

        //类别
        $list = Area::where("org_id", Auth::user()->org_id)->get();
        foreach ($list as $k => $v) {
            $arr = [
                $list[$k]->name, $list[$k]->id
            ];
            array_push($cellData2, $arr);
        }
        Excel::create('场地模板', function ($excel) use ($cellData, $cellData2) {

            // Our first sheet
            $excel->sheet('sheet1', function ($sheet1) use ($cellData) {
                $sheet1->setPageMargin(array(
                    0.30, 0.30, 0.30
                ));
                $sheet1->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40
                ));
                $sheet1->cells('A1:C1', function ($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet1->rows($cellData);
            });

            // Our second sheet
            $excel->sheet('场地类别', function ($sheet2) use ($cellData2) {
                $sheet2->setPageMargin(array(
                    0.30, 0.30
                ));
                $sheet2->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet2->cells('A1:B1', function ($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet2->rows($cellData2);
            });


        })->export('xls');
    }*/

    public function add_import()
    {
        return response()->view('asset.area.add_import');
    }

    public function import(Request $request)
    {
        $message = [
            'code' => '1',
            'message' => '数据导入成功'
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
                        $area = new Area();
                        $area->code = $v['编码'];
                        //检测编码是否已存在
                        if ($area->where('code', $v['编码'])->where('org_id', $org_id)->first()) {
                            $v['message'] = '编码已存在';
                            $error_data[] = $v;
                            continue;
                        }

                        $area->name = $v['名称'];
                        //获取父级场地信息，获取父级场地id
                        $p_area = explode('/', $v['上级场地']);
                        if ($p_area) {
                            $pid = 0;
                            $is_have_pid = 0;
                            foreach ($p_area as $ks => $vs) {
                                $p_area_info = $area->where('pid', $pid)->where('name', $vs)->where('org_id', $org_id)->first();
                                if ($p_area_info) {
                                    $is_have_pid = 1;
                                    $pid = $p_area_info->id; //子级的pid
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
                        $area->pid = $pid;
                        $area->org_id = $org_id;
                        $area->remarks = $v['备注'];
                        $area->status = $v['状态'] == '不可用' ? 0 : 1;
                        $area->uuid = Uuid::generate()->string;
                        //获取所有父级id路径
                        
                        $area->path = '';
                        if ($area->save()) {
                            $success_data[] = $area->toArray();
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
