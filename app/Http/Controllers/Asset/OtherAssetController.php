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

class OtherAssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $map = [
            ['org_id','=',Auth::user()->org_id]
        ];
        if($request->category_id){
            $map[] = ['category_id','=',$request->category_id];
        }
        if($request->name){
            $map[] = ['name','like','%'.$request->name.'%'];
        }
        $list = OtherAsset::where($map)->paginate(1);
        foreach ($list as $k=>$v){
            //资产类别
            $list[$k]['category_id'] = $v->category->name;
            $list[$k]['org_id'] = $v->org->name;
        }
        //资产类别
        $category_list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        $list = $list->appends(array('category_id'=>$request->category_id,'name'=>$request->name,'app_groups'=>'asset'));
        return view("asset.otherAsset.index",compact('list','category_list'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list = AssetCategory::where("org_id",Auth::user()->org_id)->get();
        return response()->view("asset.otherAsset.add",compact("list"));
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
            'category_id' => $request->category_id,
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
        //类别
        $info->category_id = AssetCategory::where("id",$info->category_id)->where("org_id",Auth::user()->org_id)->value("name");
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
            //图片
//            $file_id = AssetFile::where("asset_id",$info->id)->value("file_id");
//            $file = File::where("id",$file_id)->first();
            //资产类别
            $list = AssetCategory::select(DB::raw('*,concat(path,id) as paths'))->orderBy("paths")->get();

            return response()->view("asset.otherAsset.edit", compact("info", "list"));
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
            'category_id' => $request->category_id,
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
}
