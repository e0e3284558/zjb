<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetClear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssetClearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $org_id = get_current_login_user_org_id();
            $map = [
                ['org_id', '=', $org_id]
            ];
            $data = AssetClear::with("user")->where($map)->orderBy("id", "desc")->paginate(request('limit'));

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetClear.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $map = [
            'org_id' => get_current_login_user_org_id(),
            'status' => "1"
        ];
        $list = Asset::with("category","file")->where($map)->get();
        foreach ($list as $key => $value) {
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }
        return view("asset.assetClear.add",compact("list"));
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
            'asset_ids' => implode(",",$request->asset_ids),
            'remarks' => $request->remarks,
            'clear_time' => $request->clear_time,
            'user_id' => Auth::user()->id,
            'created_at' => date("Y-m-d H:i:s"),
            'org_id' => get_current_login_user_org_id()
        ];

        //查找当前org_id、当前资产类别下的最大serial_number值
        $max_serial = AssetClear::where('org_id',get_current_login_user_org_id())->orderBy("serial_number","desc")->first();
        if($max_serial){
            $arr['code'] = "QL".date("Ymd").str_pad($max_serial->serial_number+1,4,"0",STR_PAD_LEFT);
            $arr['serial_number'] = $max_serial->serial_number+1;
        }else{
            $arr['code'] = "QL".date("Ymd").'0001';
            $arr['serial_number'] = 1;
        }
        $info = AssetClear::insert($arr);
        if($info){
            foreach ($request->asset_ids as $v){
                Asset::where("id",$v)->update(['status'=>"0"]);
            }
        }
        return response()->json([
            'status' => '1',
            'message' => '清理报废成功'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = AssetClear::with("user")->find($id);
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

        return view("asset.assetClear.show",compact("info","list"));
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
        //
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
        foreach ($arr as $k=>$v){
            $info = AssetClear::find($v);
            foreach (explode(",",$info->asset_ids) as $key=>$value){
                Asset::where("id",$value)->update(['status'=>"1"]);
            }
        }
        foreach ($arr as $k=>$v){
            AssetClear::where("id",$v)->delete();
        }
        return response()->json([
            'status' => '1',
            'message' => '资产还原成功'
        ]);
    }

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
        return view("asset.assetClear.slt_asset");
    }

}
