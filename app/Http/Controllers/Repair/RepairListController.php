<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\RepairListRequest;
use App\Models\Repair\Process;
use App\Models\Repair\ServiceProvider;
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
        if ($res = is_permission('repair.list.index')){
            return $res;
        }
        //新工单
        $list1 = Process::with('org', 'user', 'admin', 'asset', 'category', 'serviceWorker', 'serviceProvider')
            ->where("user_id", Auth::user()->id)
            ->orderBy('id', 'desc')
            ->where("status", "2")
            ->orWhere('status', '1')
            ->orWhere('status', '7')
            ->orWhere('status', '4')
            ->paginate(10, ['*'],'page');
        //待评价
        $list2 = Process::with('org', 'user', 'admin', 'asset', 'category', 'serviceWorker', 'serviceProvider')
            ->where("user_id", Auth::user()->id)
            ->orderBy('id', 'desc')
            ->where("status", "5")
            ->paginate(10, ['*'],'page');
        //全部工单
        $list3 = Process::with('org', 'user', 'admin', 'asset', 'category', 'serviceWorker', 'serviceProvider')
            ->where("user_id", Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate(10, ['*'],'page');
        return view("repair.repair_list.index", compact("list1", "list2", "list3"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('repair.list.add')){
            return $res;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($res = is_permission('repair.list.add')){
            return $res;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($res = is_permission('repair.list.index')){
            return $res;
        }
        $info = Process::with('org', 'user', 'admin', 'area', 'otherAsset', 'asset', 'category', 'serviceWorker', 'serviceProvider')->find($id);
        $list = Process::where("id", $id)->with("img")->first()->img;
        $list1 = Process::where("id", $id)->with("worker_img")->first()->worker_img;
        return response()->view("repair.repair_list.show", compact('info',"list","list1"));
    }


    public function showImg($id)
    {
        $list = Process::where("id", $id)->with("img")->first()->img;
        return response()->view("repair.repair_list.showImg", compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('repair.list.edit')){
            return $res;
        }
        return view("repair.repair_list.add", compact("id"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(RepairListRequest $request, $id)
    {
        if ($res = is_permission('repair.list.edit')){
            return $res;
        }
        $arr = [
            'score' => $request->score,
            'appraisal' => $request->appraisal,
            'status' => '6'
        ];
        $info = Process::where("id", $id)->update($arr);
        $service_provider_id=Process::find($id)->service_provider_id;
        $provider=ServiceProvider::find($service_provider_id);
        $score=($provider->score+$request->score)/(($provider->about?$provider->about:1)+1);
        ServiceProvider::where('id',$service_provider_id)->increment('bout',1,['score'=>$score]);
        $message = [];
        if ($info) {
            $message = [
                'code' => 1,
                'message' => '评价成功,感谢您的评价'
            ];
        } else {
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($res = is_permission('repair.list.del')){
            return $res;
        }
    }
}
