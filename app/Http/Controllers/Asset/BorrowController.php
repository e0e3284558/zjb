<?php

namespace App\Http\Controllers\Asset;

use App\Models\Asset\Asset;
use App\Models\Asset\Borrow;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($res = is_permission('borrow.index')){
            return $res;
        }
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
            $data = Borrow::where($map)->orderBy("id", "desc")->paginate(request('limit'));

            foreach ($data as $key => $value) {
                if($value->borrow_status=="1"){
                    $data[$key]['borrow_status'] = '<span class="btn-sm label-primary" >借用</span>';
                }else{
                    $data[$key]['borrow_status'] = '<span class="btn-sm label-danger" >已归还</span>';
                }
            }

            $data = $data->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view("asset.borrow.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('borrow.add')){
            return $res;
        }
        $map = [
            'org_id' => Auth::user()->org_id,
            'status' => "1"
        ];
        $list = Asset::with("category","file")->where($map)->get();
        foreach ($list as $key => $value) {
            //图片
            $list[$key]['file'] = Asset::find($value->id)->file()->first();
            $list[$key]['img_path'] = $list[$key]['file']["path"];
            $list[$key]['file_id'] = $list[$key]['file']['id'];
        }
        return view("asset.borrow.add",compact("list"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($res = is_permission('borrow.add')){
            return $res;
        }
//        dd($request->all());
        $arr = $request->except("_token","borrow_asset_ids");
        $arr['borrow_asset_ids'] = implode(",",$request->borrow_asset_ids);
        $arr['borrow_status'] = "1";
        $arr['borrow_code'] = "JY".date("Ymd").rand("0001",'9999');
        $arr['org_id'] = Auth::user()->org_id;
        $arr['borrow_handle_user_id'] = Auth::user()->id;       //借用处理人
        $arr['created_at'] = date("Y-m-d H:i:s");

        $info = Borrow::insert($arr);
        $message = [];
        if($info){
            foreach ($request->borrow_asset_ids as $v){
                Asset::where("id",$v)->update(['status'=>'2']);
            }
            $message = [
                'status' => '1',
                'message' => '借用成功'
            ];
        }else{
            $message = [
                'status' => 0,
                'message' => '借用失败'
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
        if ($res = is_permission('borrow.index')){
            return $res;
        }
        $info = Borrow::with("borrow_handle_user","return_handle_user")->find($id);
        $arr = explode(",",$info->borrow_asset_ids);
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

        return view("asset.borrow.show",compact("info","list"));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('borrow.edit')){
            return $res;
        }
        return view("asset.borrow.edit",compact('id'));
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
        if ($res = is_permission('borrow.edit')){
            return $res;
        }
        //归还
//        dd($request->all());
        $arr = [
            'return_time' => $request->return_time,
            'return_handle_user_id' => Auth::user()->id,
            'borrow_status' => "2",
        ];
        $info = Borrow::where("id",$id)->update($arr);
        if($info){
            $ids = Borrow::where("id",$id)->value("borrow_asset_ids");
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
