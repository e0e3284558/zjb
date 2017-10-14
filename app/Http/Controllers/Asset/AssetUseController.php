<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetUse;
use App\Models\User\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssetUseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('asset.use.index')){
            return $res;
        }
        if ($request->ajax()) {
            $org_id = get_current_login_user_org_id();
            $map = [
                ['org_id', '=', $org_id]
            ];
//            if ($request->category_id) {
//                $map[] = ['category_id', '=', $request->category_id];
//            }
//            if ($request->search) {
//                $map[] = ['name', 'like', '%' . $request->search . '%'];
//            }
            $data = AssetUse::where($map)->orderBy("id", "desc")->paginate(request('limit'));

            foreach ($data as $key => $value) {
                if($value->status=="1"){
                    $data[$key]['status'] = '<span class="btn-sm label-primary" >领用</span>';
                }else{
                    $data[$key]['status'] = '<span class="btn-sm label-danger" >已归还</span>';
                }
            }

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetUse.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->get("type")==2) {
            $org_id = get_current_login_user_org_id();
            $map = [
                ['org_id', '=', $org_id],
                ['status','=','1']
            ];
            $data = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier', 'contract')->where($map)->orderBy("id", "desc")->paginate(request('limit'));
            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetUse.add");
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($res = is_permission('asset.use.add')){
            return $res;
        }
        $arr = $request->except("_token","asset_ids");
        $arr['asset_ids'] = implode(",",$request->asset_ids);
        $arr['status'] = "1";

        //查找当前org_id下的最大serial_number值
        $max_serial = AssetUse::where(['org_id'=>get_current_login_user_org_id()])->orderBy("serial_number","desc")->first();
        if($max_serial){
            $code = str_pad($max_serial->serial_number+1,5,"0",STR_PAD_LEFT);
        }else{
            $code = '00001';
        }
        $arr['code'] = "LY".date("Ymd").$code;
        $arr['serial_number'] = $max_serial->serial_number+1;

        $arr['org_id'] = get_current_login_user_org_id();
        $arr['use_dispose_user_id'] = Auth::user()->id;       //领用处理人
        $arr['created_at'] = date("Y-m-d H:i:s");
        $info = AssetUse::insert($arr);

        if($info){
            foreach ($request->asset_ids as $v){
                Asset::where("id",$v)->update(['status'=>"3"]);
            }
            $message = [
                'status' => '1',
                'message' => '资产领用成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '资产领用失败，请稍后'
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
        if ($res = is_permission('asset.use.index')){
            return $res;
        }
        $info = AssetUse::with("use_dispose_user","use_department","return_dispose_user")->find($id);
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

        return view("asset.assetUse.show",compact("info","list"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('asset.use.edit')){
            return $res;
        }
        return view("asset.assetUse.edit",compact('id'));
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
        if ($res = is_permission('asset.use.edit')){
            return $res;
        }
        //归还
        $arr = [
            'return_time' => $request->return_time,
            'return_dispose_user_id' => Auth::user()->id,
            'status' => "2",
            "updated_at" => date("Y-m-d H:i:s")
        ];
        $info = AssetUse::where("id",$id)->update($arr);
        if($info){
            $ids = AssetUse::where("id",$id)->value("asset_ids");
            $ids = explode(",",$ids);
            foreach ($ids as $v){
                Asset::where("id",$v)->update(['status'=>'1']);
            }
            $message = [
                'status' => '1',
                'message' => '资产归还成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '资产归还失败'
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
                ['status','=','1']
            ];
            $data = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier', 'contract')->where($map)->orderBy("id", "desc")->paginate(request('limit'));
            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetUse.slt_asset");
    }

}
