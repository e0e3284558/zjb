<?php

namespace App\Http\Controllers\Asset;

use App\Http\Requests\AreaRequest;
use App\Models\Asset\Area;
use App\Models\Asset\Asset;
use App\Models\User\Org;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

use Intervention\Image\ImageManager;
use PDF;
use Webpatser\Uuid\Uuid;
use QrCode;
use Excel;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取所有部门信息
        if (request('tree') == 1) {
            $select = $request->select;
            $name = $request->name;
            $where = [];
            if($name){
                $where[] = ['name','like',"%{$name}%"];
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
        return response()->view("asset.area.add");
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $area = new Area();
        $area->name = $request->name;
        $area->status = $request->status;
//        $area->sort = $request->sort;
        $area->pid = $request->pid;
        $area->remarks = $request->remarks;
        $area->code = $request->code;
        $area->org_id = get_current_login_user_org_id();
        $area->uuid = Uuid::generate()->string;
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
        $dep = Area::orgs()->findOrFail($id);
        return view('asset.area.edit', ['area' => $dep]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AreaRequest $request, $id)
    {
        $area = Area::orgs()->findOrFail($id);
        $area->name = $request->name;
        $area->pid = $request->pid;
//        $area->sort = $request->sort;
        $area->status = $request->status;
        $area->remarks = $request->remarks;
        $area->code = $request->code;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
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
    public function export(){

        $list = Area::where("org_id",Auth::user()->org_id)->get();
        $cellData = [
            ['场地名称','父级场地名称类别','备注'],
        ];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['name'] = $value->name;
            //所在位置
            $arr['path'] = "";
            $str = $value->path.$value->area_id;
            $str = explode(",",$str);
            foreach ($str as $k=>$v){
                $arr['path'] .= Area::where("id",$v)->value("name")." / ";
            }
            $arr['path'] = rtrim($arr['path']," /");
            $arr['remarks'] = $value->remarks;
            array_push($cellData,$arr);
        }
        Excel::create('场地列表_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('场地管理', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40
                ));
                $sheet->cells('A1:C1', function($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($cellData);
            });
        })->export('xlsx');
        return ;
    }


    //下载模板
    public function downloadModel(){
        $cellData = [['场地名称','父类','场地备注']];
        $cellData2 = [['场地名称','场地编号']];
        //类别
        $list = Area::where("org_id",Auth::user()->org_id)->get();
        foreach ($list as $k=>$v){
            $arr = [
                $list[$k]->name,$list[$k]->id
            ];
            array_push($cellData2,$arr);
        }
        Excel::create('场地模板', function($excel) use ($cellData,$cellData2){

            // Our first sheet
            $excel->sheet('sheet1', function($sheet1) use ($cellData){
                $sheet1->setPageMargin(array(
                    0.30,0.30,0.30
                ));
                $sheet1->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40
                ));
                $sheet1->cells('A1:C1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet1->rows($cellData);
            });

            // Our second sheet
            $excel->sheet('场地类别', function($sheet2) use ($cellData2){
                $sheet2->setPageMargin(array(
                    0.30,0.30
                ));
                $sheet2->setWidth(array(
                    'A' => 40, 'B' => 40
                ));
                $sheet2->cells('A1:B1', function($row) {
                    $row->setBackground('#dfdfdf');
                });
                $sheet2->rows($cellData2);
            });


        })->export('xls');
    }

    public function add_import(){
        return response()->view('asset.area.add_import');
    }

    public function import(Request $request){
        $filePath =  $request->file_path;
        Excel::selectSheets('sheet1')->load($filePath, function($reader) {
            $data = $reader->getsheet(0)->toArray();
            $org_id = Auth::user()->org_id;
            foreach ($data as $k=>$v){
                if($k==0){
                    continue;
                }
                $arr = [
                    'name' => $v[0],
                    'pid' => $v[1],
                    'uid' => Uuid::generate()->string,
                    'remarks' => $v[2],
                    'org_id' => $org_id
                ];
                if($arr['pid']=='0'){
                    $arr['path'] = '';
                }else{
                    $path = Area::where("id",$arr['pid'])->value("path");
                    $arr['path'] = $path.$arr['pid'].',';
                }
                Area::insert($arr);
            }
        });
        $message = [
            'code'=>'1',
            'message'=> '数据导入成功'
        ];
        return response()->json($message);
    }

}
