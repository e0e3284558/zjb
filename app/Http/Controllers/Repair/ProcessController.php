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
        $list = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("service_worker_id",session('worker')->id)->get();
        return view("repair.process.index",compact("list"));
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
        $info = Process::where("id",$id)->update(['status'=>'4']);
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
    public function refuse($id)
    {
        $info = Process::where('id',$id)->update(['status'=>'2']);
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
}
