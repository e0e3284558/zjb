<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\RepairListRequest;
use App\Models\Repair\Process;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RepairListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //新工单
        $list1 = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("user_id",Auth::user()->id)->orderBy('id','desc')->where("status","2")->orWhere('status','1')->orWhere('status','7')->orWhere('status','4')->get();
        //待评价
        $list2 = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("user_id",Auth::user()->id)->orderBy('id','desc')->where("status","5")->get();
        //全部工单
        $list3 = Process::with('org','user','admin','asset','category','serviceWorker','serviceProvider')->where("user_id",Auth::user()->id)->orderBy('id','desc')->get();
        $list = Process::with('org','user','admin','asset','otherAsset','category','serviceWorker','serviceProvider')
                         ->where("user_id",Auth::user()->id)->orderBy('id','desc')->get();
//        return view("repair.process.index",compact("list1","list2","list3"));
        return view("repair.repair_list.index",compact("list1","list2","list3","list"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $info = Process::with('org','user','admin','area','otherAsset','asset','category','serviceWorker','serviceProvider')->find($id);
        return response()->view("repair.repair_list.show",compact('info'));
    }


    public function showImg($id){
        $list = Process::where("id",$id)->with("img")->first()->img;
        return response()->view("repair.repair_list.showImg",compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view("repair.repair_list.add",compact("id"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RepairListRequest $request, $id)
    {
        $arr = [
            'score' => $request->score,
            'appraisal' => $request->appraisal,
            'status' => '6'
        ];
        $info = Process::where("id",$id)->update($arr);
        $message = [];
        if($info){
            $message = [
                'code' => 1,
                'message' => '评价成功,感谢您的评价'
            ];
        }else{
            $message = [
                'code' => 0,
                'message' => '评价失败'
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
