<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\ServiceProviderRequest;
use App\Models\Repair\ServiceProvider;
use App\Models\Repair\ServiceWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $serviceProvider = ServiceProvider::with('org')
            ->orderBy('created_at','desc')
            ->get()->toArray();
        foreach ($serviceProvider as $a) {
            if (($a['org'])) {
                if ($a['org'][0]['id'] == Auth::user()->org_id) {
                    $data[] = $a;
                }
            }
        }
        $data = collect($data);
        //获取服务商下面的维修工
        foreach ($data as $k => $v) {
            $worker_id = DB::table('service_provider_service_worker')
                ->where('service_provider_id', $v['id'])->get();
            foreach ($worker_id as $value) {
                $service_worker[$k][] = ServiceWorker::where('id', $value->service_worker_id)->get()->toArray();

            }
        }
        return view('repair.service_provider.index', compact('data', 'service_worker'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repair.service_provider.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceProviderRequest $request)
    {
        $serviceProvider = new ServiceProvider;
        $serviceProvider->name = $request->name;
        $serviceProvider->comment = $request->comment;
        $serviceProvider->user = $request->user;
        $serviceProvider->tel = $request->tel;
        $serviceProvider->logo_id = $request->logo_id;
        $serviceProvider->upload_id = $request->upload_id;
        $serviceProvider->created_at = date('Y-m-d H:i:s');

        if ($serviceProvider->save()) {
            if ($serviceProvider->org()->sync(Auth::user()->org_id)) {
                return response()->json([
                    'status' => 1, 'message' => '添加成功'
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
        $data = ServiceProvider::find($id);
        $serviceWorker = $data->service_worker()->get();
        //综合好评评率

        return response()->view('repair.service_provider.show', compact('data', 'serviceWorker'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = ServiceProvider::find($id);
        return response()->view('repair.service_provider.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ServiceProviderRequest $request, $id)
    {
        $res = ServiceProvider::where('id', $id)->update($request->except('_token', '_method', 'id', ''));
        //修改服务商信息
        if ($res) {
            return response()->json([
                'status' => 1, 'message' => '更新成功'
            ]);
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
        if (DB::table('org_service_provider')
                ->where('org_id', Auth::user()->org_id)
                ->where('service_provider_id',$id)
                ->delete()) {
            return response()->json([
                'code' => 1,
                'message' => '移除成功'
            ]);
        } else {
            return response()->json([
                'code' => 0,
                'message' => '移除失败，请稍候重试'
            ]);
        }

    }
}
