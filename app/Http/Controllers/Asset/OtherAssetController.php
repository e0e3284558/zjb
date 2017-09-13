<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\AssetCategory;
use App\Models\Asset\AssetFile;
use App\Models\Asset\File;
use App\Models\Asset\OtherAsset;
use App\Models\User\Org;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Webpatser\Uuid\Uuid;

use Excel;

class OtherAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $org_id = Auth::user()->org_id;
        $map = [
            ['org_id','=',$org_id]
        ];
        if($request->name){
            $map[] = ['name','like','%'.$request->name.'%'];
        }
        $list = OtherAsset::with('category')->where($map)->get();
        return view("asset.otherAsset.index",compact('list'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("asset.otherAsset.add");
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
            'code' => date("mdis").rand(1000,9999),
            'name' => $request->name,
            'uid' => Uuid::generate()->string,
            'remarks' => $request->remarks,
            'org_id' => Auth::user()->org_id
        ];
        $asset_id = OtherAsset::insertGetId($arr);

        $message = [
            'code' => 1,
            'message' => '添加成功'
        ];
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
        $info = OtherAsset::where("id",$id)->first();
        $info->org_id = Org::where("id",$info->org_id)->value("name");

        return response()->view("asset.otherAsset.show",compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->org_id == OtherAsset::where("id",$id)->value("org_id")) {
            $info = OtherAsset::where("id", $id)->first();
            return response()->view("asset.otherAsset.edit", compact("info"));
        }else{
            return redirect("home");
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
        $arr = [
            'name' => $request->name,
            'remarks' => $request->remarks,
        ];
        $info = OtherAsset::where("id",$id)->update($arr);

        if($info){
            $message = [
                'code' => 1,
                'message' =>'信息修改成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' =>'信息修改失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arr = explode(",",$id);
        if(Auth::user()->org_id == OtherAsset::where("id",$arr[0])->value("org_id")) {
            foreach ($arr as $k=>$v){
                $info = OtherAsset::where("id",$v)->where("org_id",Auth::user()->org_id)->delete();
            }
            $message = [
                'code' => 1,
                'message' => '删除成功'
            ];
            return response()->json($message);
        }else{
            return redirect("home");
        }
    }


    //下载模板
    function downloadModel(){

        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        $cellData = [
            ['资产类别id','类别名称'],
        ];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['id'] = $value->id;
            $arr['name'] = $value->name;
            array_push($cellData,$arr);
        }
        $lists = [['资产类别','报修项名称','备注']];
        Excel::create('其他报修项模板', function($excel) use ($lists,$cellData){

            // sheet1
            $excel->sheet('sheet1', function($sheet) use ($lists){
                $sheet->setPageMargin(array(
                    0.25, 0.30,0.30
                ));
                $sheet->setWidth(array(
                    'A' => 10, 'B' => 40,'C' => 40
                ));
                $sheet->cells('A1:C1', function($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($lists);
            });

            // sheet2
            $excel->sheet('sheet2', function($sheet) use ($cellData){
                $sheet->setPageMargin(array(
                    0.25, 0.30,
                ));
                $sheet->setWidth(array(
                    'A' => 10, 'B' => 40,
                ));
                $sheet->cells('A1:B1', function($row) {
                    $row->setBackground('#cfcfcf');
                });
                $sheet->rows($cellData);
            });

        })->export('xls');
    }

    function add_import(){
        return response()->view('asset.otherAsset.add_import');
    }

    function import(Request $request){
//        dd($request->filepath);
        $filePath =  'uploads/file/201709/05/59adff0f5762d.xls';
        Excel::load($filePath, function($reader) {
            $data = $reader->first();
            $org_id = Auth::user()->org_id;
            foreach ($data as $k=>$v){
                $arr = $v->toArray();
                $arr['uid'] = Uuid::generate()->string;
                $arr['code'] = date("mdis").rand(1000,9999);
                $arr['org_id'] = $org_id;
                OtherAsset::insert($arr);
            }
            $message = [
                'code'=>'1',
                'message'=> '数据导入成功'
            ];
            return response()->json($message);
        });
    }

}
