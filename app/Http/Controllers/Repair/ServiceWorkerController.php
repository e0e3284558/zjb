<?php

namespace App\Http\Controllers\Repair;

use App\Models\Repair\Classify;
use App\Models\Repair\ServiceWorker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('repair.service_worker.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Classify::where('org_id', 0)->OrderBy('sorting', 'desc')->get();
        return response()->view('repair.service_worker.add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $serviceWorker = new ServiceWorker;
        $serviceWorker->username = $request->username;
        $serviceWorker->password = bcrypt($request->password);
        $serviceWorker->name = $request->name;
        $serviceWorker->tel = $request->tel;
        $serviceWorker->upload_id = $request->upload_id;
        if ($serviceWorker->save()) {
            //将tag数据存入到中间表post_tag中
            if ($serviceWorker->classify()->sync($request->classify)) {
                return redirect('repair/service_worker')->with('success', '创建成功');
            }

        } else {
            return redirect('repair/service_worker')->with('error', '创建失败');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
