<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\AssetCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                $arr = [
                    'code'=>0,
                    'message'=>'此类别下还有类别'
                ];
            }else{
                //判断此类别下还有资产
                /*if(){

                }*/
                $info = AssetCategory::where("id",$id)->delete();
                if($info){
                    $arr = [
                        'code'=>1,
                        'message'=>'删除成功'
                    ];
                }
            }
            return response()->json($arr);
        }else{
            return redirect("home");
        }
    }

}
