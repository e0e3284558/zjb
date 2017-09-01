<?php

namespace App\Http\Controllers\Asset;

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
    public function store(Request $request)
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
        QrCode::encoding("UTF-8")->format('png')->size("100")->merge('/public/uploads/qrcodes/logo.png', .3)->margin("0")->generate($arr['uid'],public_path('uploads/area/'.$arr['uid'].'.png'));

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
    public function update(Request $request, $id)
    {
        $user_org = Auth::user()->org_id;
        $info = Area::find($id);
        if($user_org == $info->org_id){
            $info = Area::find($id);
            //删除原来的二维码图片
            unlink(public_path('uploads/qrcodes/'.$info->uid.'.png'));
            QrCode::encoding("UTF-8")->format('png')->size("300")->merge('/public/uploads/qrcodes/logo.png', .3)->margin("6")->generate($info->uid,public_path('uploads/qrcodes/'.$info->uid.'.png'));

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
            ['场地名称','父类别','备注','所属公司'],
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
            $arr['org_id'] = $value->org->name;
            array_push($cellData,$arr);
        }
        Excel::create('场地列表_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30, 0.25, 0.30
                ));
                $sheet->setWidth(array(
                    'A' => 40, 'B' => 40, 'C' => 40,'D' => 40
                ));
                $sheet->cells('A1:D1', function($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($cellData);
            });
        })->export('xlsx');



        return ;
    }


    public function prints(){

    }


}
