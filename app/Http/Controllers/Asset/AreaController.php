<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Webpatser\Uuid\Uuid;

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
            'remarks' => $request->remarks,
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

        if($info->pid=="0"){
            return response()->view("asset.area.edit",compact('info'));
        }else{
            $parent_info = Area::where("id",$info->pid)->where("org_id",Auth::user()->org_id)->first();
            return response()->view('asset.area.edit',compact("info","parent_info"));
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
        if(Auth::user()->org_id == Area::where("id",$id)->value("org_id")){
            $info = Area::where("id",$id)->update($request->except("_token","_method"));
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
                $arr = [
                    'code'=>0,
                    'message'=>'此场地下还有场地'
                ];
            }else{
                //判断此类别下还有资产
                /*if(){

                }*/
                $info = Area::where("id",$id)->delete();
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
