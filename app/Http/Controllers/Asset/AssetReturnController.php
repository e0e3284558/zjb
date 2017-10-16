<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetReturn;
use App\Models\Asset\AssetUse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssetReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('asset.return.index')){
            return $res;
        }
        if ($request->ajax()) {
            $org_id = get_current_login_user_org_id();
            $map = [
                ['org_id', '=', $org_id]
            ];
            $data = AssetReturn::with("return_dispose_user")->where($map)->orderBy("id", "desc")->paginate(request('limit'));

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetReturn.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('asset.return.add')){
            return $res;
        }
        return view("asset.assetReturn.add");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($res = is_permission('asset.return.add')){
            return $res;
        }
        $arr = $request->except("_token","asset_ids");

        //查找当前org_id下的最大serial_number值
        $max_serial = AssetReturn::where(['org_id'=>get_current_login_user_org_id()])->orderBy("serial_number","desc")->first();
        if($max_serial){
            $code = str_pad($max_serial->serial_number+1,5,"0",STR_PAD_LEFT);
        }else{
            $code = '00001';
        }
        $arr['return_code'] = "TK".date("Ymd").$code;
        $arr['serial_number'] = $max_serial->serial_number+1;
        $arr['return_dispose_user_id'] = Auth::user()->id;
        $arr['org_id'] = get_current_login_user_org_id();
        $arr['asset_ids'] = implode(",",$request->asset_ids);
        $arr['created_at'] = date("Y-m-d H:i:s");
        $info = AssetReturn::insert($arr);
        if($info){
            foreach ($request->asset_ids as $v){
                Asset::where("id",$v)->update(['status' => '1']);
            }
            $message = [
                'status' => '1',
                'message' => '资产退库成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '资产退库失败，请稍后重试'
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
        if ($res = is_permission('asset.return.index')){
            return $res;
        }
        if ($res = is_permission('asset.category.index')){
            return $res;
        }
        $info = AssetReturn::with("return_dispose_user")->find($id);
        $arr = explode(",",$info->asset_ids);
        $list = [];
        foreach ($arr as $v){
            $list[] = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier')->where("id",$v)->first();
        }
        foreach ($list as $key => $value) {
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }

        return view("asset.assetReturn.show",compact("info","list"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
//        Auth::user()->id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function slt_asset(Request $request){
        if ($request->get("type")==2) {
            $org_id = get_current_login_user_org_id();
            $map = [
                ['org_id', '=', $org_id],
                ['status','=','3']
            ];
            $data = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier', 'contract')->where($map)->orderBy("id", "desc")->paginate(request('limit'));
            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetReturn.slt_asset");
    }
}
