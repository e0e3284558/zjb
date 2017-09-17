<?php

namespace App\Http\Controllers\Repair;

use App\Models\Repair\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //新工单
        $list1 = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("service_worker_id",auth('service_workers')->user()->id)->where("status","2")->get();
        //待填写维修结果
        $list2 = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("service_worker_id",auth('service_workers')->user()->id)->where("status","3")->orWhere('status',"0")->get();
        //工单已经结束
        $list3 = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("service_worker_id",auth('service_workers')->user()->id)->where("status","6")->orWhere('status',"0")->get();
        return view("repair.process.index",compact("list1","list2","list3"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view("repair.process.add",compact("id"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 填写维修结果
     */
    public function store(Request $request)
    {
        $info = Process::where("id",$request->id)->update($request->except('id','_token'));
        $message = [];
        if($info){
            $message = [
                'code' => '1',
                'message' => '成功'
            ];
        }else{
            $message = [
                'code' => '0',
                'message' => '失败'
            ];
        }
        return response()->json($message);
    }


    public function show($id){
//        dd($id);
        $info = Process::with('org','user','admin','area','otherAsset','asset','category','serviceWorker','serviceProvider')->find($id);
        return response()->view("repair.process.show",compact('info'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 接收维修单
     */
    public function edit($id)
    {
        $info = Process::where("id",$id)->update(['status'=>'3']);
        $message = [];
        if($info){
            $message = [
                'code' => '1',
                'message' => '成功'
            ];
        }else{
            $message = [
                'code' => '0',
                'message' => '失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * @param $str
     * @return \Illuminate\Http\JsonResponse
     * 批量接收维修单
     */
    public function batchEdit($str){
        $arr = explode(',',$str);
        foreach ($arr as $v){
            $info = Process::where("id",$v)->update(['status'=>'3']);
        }
//        $message = [];
//        if($info){
            $message = [
                'code' => '1',
                'message' => '成功'
            ];
//        }else{
//            $message = [
//                'code' => '0',
//                'message' => '失败'
//            ];
//        }
        return response()->json($message);
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
     * 拒接接收维修单
     */
    public function refuse($id)
    {
        $info = Process::where('id',$id)->update(['status'=>'4']);
        $message = [];
        if($info){
            $message = [
                'code' => 1,
                'message' => '成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * @param $str
     * @return \Illuminate\Http\JsonResponse
     * 批量拒接接收维修单
     */
    public function BatchRefuse($str)
    {
        dd($str);
        $arr = explode(',',$str);
        foreach ($arr as $v){
            $info = Process::where('id',$v)->update(['status'=>'4']);
        }
        $message = [];
        if($info){
            $message = [
                'code' => 1,
                'message' => '成功'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '失败'
            ];
        }
        return response()->json($message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response
     * 报修图片显示
     */
    public function showImg($id){
        $list = Process::where("id",$id)->with("img")->first()->img;
        return response()->view("repair.repair_list.showImg",compact('list'));
    }
}
