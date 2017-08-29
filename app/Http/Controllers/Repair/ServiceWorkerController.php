<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\ServiceWorkerRequest;
use App\Models\Repair\Classify;
use App\Models\Repair\ServiceProvider;
use App\Models\Repair\ServiceWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        $data = Classify::where('org_id', 0)->OrderBy('sorting', 'desc')->get();
        $serviceWorker = ServiceWorker::get();
        return view('repair.service_worker.index', compact('data', 'serviceWorker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Classify::where('org_id', 0)->OrderBy('sorting', 'desc')->get();
        $serviceProvider = ServiceProvider::get();
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
        $serviceWorker = new ServiceWorker;
        $serviceWorker->username = $request->username;
        $serviceWorker->password = bcrypt($request->password);
        $serviceWorker->name = $request->name;
        $serviceWorker->tel = $request->tel;
        $serviceWorker->upload_id = $request->upload_id;
        if ($serviceWorker->save()) {
            //将tag数据存入到中间表post_tag中
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
        // 读取该维修工信息
        $data = ServiceWorker::find($id);
        // 根据维修工id获取所在服务商信息
        $service_provider_id = DB::table('service_provider_service_worker')
                                    ->where('service_worker_id', $data->id)
                                    ->value('service_provider_id');
        // 读取所有分类信息
        $classifies = Classify::get();
        // 读取维修工与分类关联信息
        $serviceWorkerClassify = $data->classify->toArray();
        foreach ($serviceWorkerClassify as $k => $v) {
            $ids[] = $v['id'];
        }
        $serviceProvider = ServiceProvider::get();
        return response()->view('repair.service_worker.edit',
            compact('data', 'ids', 'classifies', 'service_provider_id','serviceProvider')
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
                return redirect('repair/service_worker')->with('success', '更新成功');
            }

        } else {
            return redirect('repair/service_worker')->with('error', '更新失败');
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
        if (ServiceWorker::where('id', $id)->delete()) {
            if (DB::table('classify_service_worker')->where('service_worker_id', $id)->delete()) {
                return response()->json([
                    'message' => '删除成功',
                    'status' => 'success'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => '删除失败，请稍后重试',
                ]);
            }
        }
    }
}
