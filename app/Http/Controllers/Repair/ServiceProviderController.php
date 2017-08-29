<?php

namespace App\Http\Controllers\Repair;

use App\Models\Repair\ServiceProvider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServiceProviderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=ServiceProvider::get();
        return view('repair.service_provider.index',compact('data'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (ServiceProvider::create($request->except('_token'))) {
            return response()->json([
                'status' => 1, 'message' => '添加成功'
            ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data=ServiceProvider::find($id);
        return response()->view('repair.service_provider.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data=ServiceProvider::find($id);
        return response()->view('repair.service_provider.edit',compact('data'));
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
        //修改服务商信息
        if(ServiceProvider::where('id',$id)->update($request->except('_token','_method','id'))){
            return response()->json([
                'status' => 1, 'message' => '更新成功'
            ]);
        }else{
            return response()->json([
                'status' => 0, 'message' => '更新失败',
                'data' => null, 'url' => ''
            ]);
        }
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
