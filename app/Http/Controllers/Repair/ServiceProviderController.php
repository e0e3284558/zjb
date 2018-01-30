<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\ServiceProviderRequest;
use App\Models\Repair\Process;
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
        if ($res = is_permission('service.provider.index')){
            return $res;
        }
        $data = [];
        $serviceProvider = ServiceProvider::with('org', 'service_worker')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('repair.service_provider.index', compact('data', 'serviceProvider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if ($res = is_permission('service.provider.add')){
            return $res;
        }
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
        if ($res = is_permission('service.provider.add')){
            return $res;
        }
        $serviceProvider = new ServiceProvider;
        $serviceProvider->name = $request->name;
        $serviceProvider->comment = $request->comment;
        $serviceProvider->user = $request->user;
        $serviceProvider->tel = $request->tel;
        $serviceProvider->logo_id = $request->logo_id;
        $serviceProvider->upload_id = $request->upload_id;
        $serviceProvider->created_at = date('Y-m-d H:i:s');
        $serviceProvider->bout=0;
        $serviceProvider->score=0;
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
        if ($res = is_permission('service.provider.index')){
            return $res;
        }
        $data = ServiceProvider::find($id);
        $serviceWorker = $data->service_worker()->get();
        $processProvider1 = Process::where('service_provider_id', $data->id)->latest()->paginate(10);
        $processProvider2 = $processProvider1;
        return response()->view('repair.service_provider.show',
            compact('data', 'serviceWorker', 'processProvider1','processProvider2')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ($res = is_permission('service.provider.edit')){
            return $res;
        }
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
        if ($res = is_permission('service.provider.edit')){
            return $res;
        }
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
        if ($res = is_permission('service.provider.del')){
            return $res;
        }
        if (DB::table('service_provider_service_worker')
            ->where('service_provider_id',$id)
            ->where('status',0)
            ->get()->isEmpty()
        ) {
            if (DB::table('org_service_provider')
                ->where('org_id', Auth::user()->org_id)
                ->where('service_provider_id', $id)
                ->where('status', 0)
                ->delete()) {
                if (ServiceProvider::find($id)->delete()) {
                    return response()->json([
                        'code' => 1,
                        'message' => '成功删除该服务商'
                    ]);
                } else {
                    return response()->json([
                        'code' => 1,
                        'message' => '已移除与服务商关联关系'
                    ]);
                }

            } else {
                return response()->json([
                    'code' => 0,
                    'message' => '移除失败，请稍候重试'
                ]);
            }
        }else{
            return response()->json([
                'code' => 0,
                'message' => '当前服务商下有维修人员，请将所有维修人员移除后再移除该服务商'
            ]);
        }
    }
}
