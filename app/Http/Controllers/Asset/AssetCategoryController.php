<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetCategory;
use App\Models\User\Org;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Excel;

class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get()->toArray();

        foreach ($list as $k=>$v){
            $list[$k]['text'] = $v['name'];
            $list[$k]['nodeId'] = $v['id'];
        }
        $tree = list_to_tree($list, 'id', 'pid', 'nodes', "0");
        return view("asset.asset_category.index",compact("tree"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view("asset.asset_category.add");
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function add($id){
        if(Auth::user()->org_id == AssetCategory::where("id",$id)->value("org_id")){
            $info = AssetCategory::find($id);
            return response()->view("asset.asset_category.add_son",compact("info"));
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
            'category_code' => "13124",
            'name' => $request->name,
            'org_id' => Auth::user()->org_id,
            'created_at' => date("Y-m-d H:i:s")
        ];
        if($request->pid){
            $arr['pid'] = $request->pid;
            $org_id = Auth::user()->org_id;
            $arr['path'] = AssetCategory::where('org_id',$org_id)->where("id",$request->pid)->value("path");
            $arr['path'] .= $request->pid.",";
        }else{
            $arr['pid'] = 0;
            $arr['path'] = "";
        }
        $info = AssetCategory::insertGetId($arr);
        if($info){
            $arr = [
                'code'=>1,
                'message'=>'添加成功'
            ];
        }else{
            $arr = [
                'code'=>0,
                'message'=>'添加失败'
            ];
        }
        return response()->json($arr);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = AssetCategory::find($id);
        return response()->view("asset.asset_category.edit",compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $info = AssetCategory::find($id);
        return response()->view("asset.asset_category.edit",compact('info'));
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
        if(Auth::user()->org_id == AssetCategory::where("id",$id)->value("org_id")){
            $info = AssetCategory::where("id",$id)->update($request->except("_token","_method"));
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
        if(Auth::user()->org_id == AssetCategory::where("id",$id)->value("org_id")){
            $list = AssetCategory::where("pid",$id)->first();

            if($list!=null){
                $message = [
                    'code'=>0,
                    'message'=>'此类别下还有子类别'
                ];
            }else{
                //判断此类别下还有资产
                if($info = Asset::where("category_id",$id)->first()){
                    $message = [
                        'code'=>0,
                        'message'=>'此类别下还有资产，不能删除'
                    ];
                }else{
                    $info = AssetCategory::where("id",$id)->delete();
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
     * @param $id
     * @return string
     */
    public function find($id){
        $list = AssetCategory::where("pid",$id)->first();
        if($list){
            $message = [
                'code'=>1,
                'message' => '还有子类'
            ];
        }else{
            $message = [
                'code'=>0,
                'message' => '没有子类'
            ];
        }
        return response()->json($message);
    }

    /**
     * 导出资产类别  数据
     */
    public function export(){

        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        $cellData = [
            ['资产类别名称','父类别','所属公司'],
        ];
        $arr = [];
        foreach ($list as $key=>$value){
            $arr['name'] = $value->name;
            $arr['path'] = $value->path;
            $arr['org_id'] = $value->org->name;
            array_push($cellData,$arr);
        }

        Excel::create('资产分类_'.date("YmdHis"),function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
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
        })->export('xls');
        return ;
    }
}
