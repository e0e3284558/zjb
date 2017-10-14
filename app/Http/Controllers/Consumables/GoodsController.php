<?php

namespace App\Http\Controllers\Consumables;

use App\Models\Consumables\Goods;
use App\Models\Consumables\Sort;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->get('id')) {
            $user = Goods::where('classify_id',$request->get('id'))->paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        if ($request->ajax()) {
            $user = Goods::paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }


        return view('consumables.archiving.index');

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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //转换成数组
        $res = $request->all();
        //如果勾选的禁用，则为0，否则启用
        isset($res['disable']) ? $res['disable'] = 0 : $res['disable'] = 1;
        //移除两个不要的属性
        unset($res['_token'], $res['file']);
        //存储数据库
        if (Goods::create($res)) {
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => '修改成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '添加失败',
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
        $request = request();
        if ($request->ajax()) {
            $user = Goods::where('id', $request->id)->paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view('consumables.archiving.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $goods = Goods::find(request('id'));
        $sort=Sort::get();
        return response()->view('consumables.archiving.edit',compact('goods','sort'));

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
        //转换成数组
        $res = $request->all();
        //如果勾选的禁用，则为0，否则启用
        isset($res['disable']) ? $res['disable'] = 0 : $res['disable'] = 1;
        //移除两个不要的属性
        unset($res['_token'], $res['file'], $res['_method'], $res['id']);
        $res = Goods::where('id', $id)->update($res);
        if ($res) {
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {

        //获取id删除该条数据
        $info = Goods::where('id', request('id'))->delete();
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
