<?php

namespace App\Http\Controllers\Repair;

use App\Http\Requests\ClassifyRequest;
use App\Models\Repair\Classify;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ClassifyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=Classify::where('org_id',Auth::user()->org_id)->OrderBy('sorting','desc')->get();
        return view('repair.classify.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return  response()->view('repair.classify.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassifyRequest $request)
    {
        //批量保存用户提交的数据
        if(Classify::create($request->except('_token'))){
            return  redirect('repair/classify')->with('success', '创建成功');
        }else{
            return  redirect('repair/classify')->with('error', '创建失败');
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
        $data=Classify::where('id',$id)->first();
        return  response()->view('repair.classify.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClassifyRequest $request, $id)
    {
        //修改分类信息
        if(Classify::where('id',$id)->update($request->except('_token','_method'))){
            return  redirect('repair/classify')->with('success', '编辑成功');
        }else{
            return  redirect('repair/classify')->with('error', '编辑失败，请稍候重试');
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
        $info = Classify::where('id', $id)->delete();
        if ($info) {
            return response()->json([
                'message' => '删除成功',
                'status' => 'success'
            ]);
        } else {
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}
