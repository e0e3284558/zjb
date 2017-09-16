<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\ServiceWorkerRequest;
use App\Models\File\File;
use App\Models\Repair\Classify;
use App\Models\Repair\ServiceProvider;
use App\Models\Repair\ServiceWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceWorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $serviceWorker = collect([]);
        //获取当前公司下的所有服务商
        $service_provider_all_id = DB::table('org_service_provider')->where('org_id', Auth::user()->org_id)->get();
        foreach ($service_provider_all_id as $v) {
             $service_provider=ServiceProvider::find($v->service_provider_id);
             $service_worker=$service_provider->service_worker()->get();
            $serviceWorker->push($service_worker);
        }
        $data = Classify::where('org_id', Auth::user()->org_id)
            ->where('enabled',1)
            ->OrderBy('sorting', 'desc')
            ->get();
        return view('repair.service_worker.index', compact('data', 'serviceWorker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Classify::where('org_id', Auth::user()->org_id)
            ->where('enabled', 1)
            ->OrderBy('sorting', 'desc')
            ->get();
        $serviceProvider = ServiceProvider::with('org')->get();
        $my_Provider = [];
        //只获取当前公司已拥有的服务商
        foreach ($serviceProvider as $v) {
            if (!collect($v->org)->isEmpty()) {
                if ($v->org !== null && ($v->org[0]->id) == Auth::user()->org_id) {
                    $my_Provider[] = $v;
                }
            }
        }
        $serviceProvider = $my_Provider;
        return response()->view('repair.service_worker.add', compact('data', 'serviceProvider'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceWorkerRequest $request)
    {
        dd($request->all());
        $serviceWorker = new ServiceWorker;
        $serviceWorker->username = $request->username;
        $serviceWorker->password = bcrypt($request->password);
        $serviceWorker->name = $request->name;
        $serviceWorker->tel = $request->tel;
        $serviceWorker->upload_id = $request->upload_id;
        if ($serviceWorker->save()) {
            //将serviceWorker数据存入到中间表serviceWorker_service_provider中
            if ($serviceWorker->classify()->sync($request->classify) && $serviceWorker->service_provider()->sync($request->serviceProvider)) {
                return response()->json([
                    'status' => 1, 'message' => '添加成功',
                    'data' => $serviceWorker->toArray()
                ]);
            }
        } else {
            return response()->json([
                'status' => 0, 'message' => '保存失败',
                'data' => null, 'url' => ''
            ]);
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

        $classify = Classify::find($id);
        $data = $classify->serviceWorker()->get();
        $title = $classify->comment;
        return response()->view('repair.service_worker.show', compact('data', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ids=[];
        // 读取该维修工信息
        $data = ServiceWorker::find($id);
        // 根据维修工id获取所在服务商信息
        $service_provider_id = DB::table('service_provider_service_worker')
            ->where('service_worker_id', $data->id)
            ->value('service_provider_id');
        // 读取所有分类信息
        $classifies = Classify::withTrashed()->where('org_id', Auth::user()->org_id)->get();
        // 读取维修工与分类关联信息
        $serviceWorkerClassify = $data->classify->toArray();
        foreach ($serviceWorkerClassify as $k => $v) {
            $ids[] = $v['id'];
        }
        $serviceProvider = ServiceProvider::get();
        return response()->view('repair.service_worker.edit',
            compact('data', 'ids', 'classifies', 'service_provider_id', 'serviceProvider')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceWorkerRequest $request, $id)
    {
        $serviceWorker = ServiceWorker::find($id);
        $serviceWorker->username = $request->username;
        if ($request->password != null) $serviceWorker->password = bcrypt($request->password);
        $serviceWorker->name = $request->name;
        $serviceWorker->tel = $request->tel;
        $serviceWorker->upload_id = $request->upload_id;
        if ($serviceWorker->save()) {
            //将tag数据存入到中间表post_tag中
            if ($serviceWorker->classify()->sync($request->classify) && $serviceWorker->service_provider()->sync($request->serviceProvider)) {
                return response()->json([
                    'status' => 1, 'message' => '更新成功',
                    'data' => $serviceWorker->toArray()
                ]);
            }
        } else {
            return response()->json([
                'status' => 0, 'message' => '更新失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if (DB::table('classify_service_worker')->where('service_worker_id', $id)->delete()) {
            if (ServiceWorker::where('id', $id)->delete()) {
                return response()->json([
                    'code' => 1,
                    'message' => '删除成功'
                ]);
            } else {
                return response()->json([
                    'code' => 0,
                    'message' => '删除失败'
                ]);
            }
        }
    }
}
