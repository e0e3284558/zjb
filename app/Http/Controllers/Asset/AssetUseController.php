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
        if ($request->ajax()) {
            $org_id = Auth::user()->org_id;
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
    public function create()
    {
        $map = [
            'org_id' => Auth::user()->org_id,
            'status' => "1"
        ];
//        $department_list = Department::where()->get();
        $list = Asset::with("category","file")->where($map)->get();
        foreach ($list as $key => $value) {
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }
        return view("asset.assetUse.add",compact("list"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        dd($request->all());
        $arr = $request->except("_token","asset_ids");
        $arr['asset_ids'] = implode(",",$request->asset_ids);
        $arr['status'] = "1";
        $arr['code'] = "LY".date("Ymd").rand("0001",'9999');
        $arr['org_id'] = Auth::user()->org_id;
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
        $info = AssetUse::with("use_dispose_user","return_dispose_user")->find($id);
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
        //归还
//        dd($request->all());
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
}
