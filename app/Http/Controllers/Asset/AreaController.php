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
    public function index()
    {
        $list = Area::where("org_id",Auth::user()->org_id)->get()->toArray();

        foreach ($list as $k=>$v){
            $list[$k]['text'] = $v['name'];
            $list[$k]['nodeId'] = $v['id'];
        }
        $tree = list_to_tree($list, 'id', 'pid', 'nodes', "0");
        return view("asset.area.index",compact("tree"));
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

    public function add($id){
        if(Auth::user()->org_id == Area::where("id",$id)->value("org_id")){
            $info = Area::find($id);
            return response()->view("asset.area.add_son",compact("info"));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AreaRequest $request)
    {
        $arr = [
            'name' => $request->name,
            'org_id' => Auth::user()->org_id,
            'uid' => Uuid::generate()->string,
            'remarks' => $request->remarks?$request->remarks:'',
            'created_at' => date("Y-m-d H:i:s")
        ];
        if($request->pid){
            $arr['pid'] = $request->pid;
            $org_id = Auth::user()->org_id;
            $arr['path'] = Area::where('org_id',$org_id)->where("id",$request->pid)->value("path");
            $arr['path'] .= $request->pid.",";
        }else{
            $arr['pid'] = "0";
            $arr['path'] = "";
        }

        // QrCode::encoding("UTF-8")->format('png')->size("100")->margin("0")->generate($arr['uid'],config('filesystems.disks.area_qrcodes.root').$arr['uid'].'.png');

        QrCode::encoding("UTF-8")->format('png')->size("100")->margin("0")->generate($arr['uid'],public_path('uploads/area/'.$arr['uid'].'.png'));

        $arr['qrcode_path'] = 'uploads/area/'.$arr['uid'].'.png';
        $info = Area::insertGetId($arr);
        if($info){
            $message = [
                'code'=>1,
                'message'=>'添加成功'
            ];
        }else{
            $message = [
                'code'=>0,
                'message'=>'添加失败'
            ];
        }
        return response()->json($message);
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
        $info = Area::find($id);
        $org = Org::find(Auth::user()->org_id);
        if($info->pid=="0"){
            return response()->view("asset.area.edit",compact('info','org'));
        }else{
            $parent_info = Area::where("id",$info->pid)->where("org_id",Auth::user()->org_id)->first();
            return response()->view('asset.area.edit',compact("info","parent_info",'org'));
        }
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
        $user_org = Auth::user()->org_id;
        $info = Area::find($id);
        if($user_org == $info->org_id){
            $info = Area::where("id",$id)->update($request->except('_method','_token'));
            if($info){
                $arr = [
                    'code'=>1,
                    'message'=>'修改成功'
                ];
            }else{
                $arr = [
                    'code'=>0,
                    'message'=>'修改失败'
                ];
            }
            return response()->json($arr);
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
        if(Auth::user()->org_id == Area::where("id",$id)->value("org_id")){
            $list = Area::where("pid",$id)->where("org_id",Auth::user()->org_id)->first();
            if($list!=null){
                $message = [
                    'code'=>0,
                    'message'=>'此场地下还有场地，不能删除'
                ];
            }else{
                //判断此类别下还有资产
                if($list = Asset::where('area_id',$id)->first()){
                    $message = [
                        'code'=>0,
                        'message'=>'此场地下还有资产，不能删除'
                    ];
                }else{
                    $info = Area::where("id",$id)->delete();
                    if($info){
                        $message = [
                            'code'=>1,
                            'message'=>'删除成功'
                        ];
                    }
                }

            }
            return response()->json($message);
        }else{
            return redirect("home");
        }
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
