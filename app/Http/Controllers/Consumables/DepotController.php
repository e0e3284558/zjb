<?php

namespace App\Http\Controllers\Consumables;

use App\Models\Consumables\Depot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DepotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Depot::where('org_id',get_current_login_user_org_id())->get();
        return view('consumables.depot.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('consumables.depot.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($depot=Depot::create($request->except('_token'))){
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => $depot->toArray()
            ]);
        }else{
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
        $data = Depot::where('id', $id)->first();
        return response()->view('consumables.depot.edit', compact('data'));
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
        //修改分类信息
        if ($classify = Depot::where('id', $id)->update($request->except('_token', '_method'))) {
            return response()->json([
                'status' => 1, 'message' => '修改成功',
                'data' => '修改成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '修改失败',
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
        //获取id删除该条数据
        $info = Depot::where('id', $id)->delete();
        if ($info) {
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
