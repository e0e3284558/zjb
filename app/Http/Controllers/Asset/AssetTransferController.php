<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\AssetTransfer;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AssetTransferController extends Controller
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
            if ($request->search) {
                $map[] = ['name', 'like', '%' . $request->search . '%'];
            }
            $data = AssetTransfer::with("out_admin","put_area","put_admin")->where($map)->orderBy("id", "desc")->paginate(request('limit'));

            foreach ($data as $k=>$v){
                switch ($v->status){
                    case "1":
                        $data[$k]['status'] = '<span class="btn-sm label-info" >已调出</span>';
                        break;
                    case "2":
                        $data[$k]['status'] = '<span class="btn-sm label-success" >完成</span>';
                        break;
                    case "3":
                        $data[$k]['status'] = '<span class="btn-sm label-primary" >已取消</span>';
                        break;
                }
                $info = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier', 'contract')->find($v->asset_id);
                $data[$k]['code'] = $info->code;
                $data[$k]['name'] = $info->name;
                $data[$k]['category'] = $info->category;
                $data[$k]['spec'] = $info->spec;
                $data[$k]['calculate'] = $info->calculate;
                $data[$k]['money'] = $info->money;
            }
            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.assetTransfer.index");
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
        //管理员
        $list1 = User::where("org_id",get_current_login_user_org_id())->get();
        return view("asset.assetTransfer.add",compact("list","list1"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->asset_ids as $v){
            $arr = [
                'status' => '1',
                'out_time' => date("Y-m-d"),
                'out_admin_id' => Auth::user()->id,
                'out_remarks' => $request->out_remarks,
                'asset_id' => $v,
                'org_id' => get_current_login_user_org_id(),
                'transfer_time' => date('Y-m-d'),
                'put_admin_id' => $request->put_admin_id,
                'created_at' => date("Y-m-d H:i:s")
            ];

            $info = AssetTransfer::insert($arr);
            if($info){
                Asset::where("id",$v)->update([
                    'status'=>'5',
                    'area_id' => $request->put_area_id,
                    'department_id' => $request->put_department_id
                ]);
            }
        }
        return response()->json([
            'status' => '1',
            'message' => '资产调出成功'
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
        foreach (explode(',',$id) as $v){
            $info = AssetTransfer::find($v);
            if(Auth::user()->id != $info->put_admin_id){
                $message = '只能操作调入管理员是当前用户的单据。';
                return view("asset.assetTransfer.error",compact("message"));

            }
            if($info->status==2){
                $message = "已调拨完成的资产不能重复操作";
                return view("asset.assetTransfer.error",compact("message"));
            }
        }
        $list = [];
        foreach (explode(',',$id) as $v){
            $info = AssetTransfer::find($v);
            $list[] = Asset::with('category', 'org', 'user', 'admin', 'source', 'department', 'useDepartment', 'area', 'supplier', 'contract')->find($info->asset_id);
        }
        foreach ($list as $key => $value) {
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }

        return view("asset.assetTransfer.edit",compact("list","id"));

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
        foreach (explode(",",$id) as $v){
            $arr = $request->except("_token","_method");
            $arr['status'] = 2;
            $info = AssetTransfer::where("id",$v)->update($arr);
            if($info){
                $asset_id = AssetTransfer::where("id",$v)->value("asset_id");
                Asset::where("id",$asset_id)->update(['status'=>'4']);
            }
        }
        return response()->json([
            'status' => '1',
            'message' => '资产调拨完成'
        ]);
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
        return view("asset.assetTransfer.slt_asset");
    }
}
