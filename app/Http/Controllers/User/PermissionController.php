<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * @param $list
     * @return mixed
     */
    public function test($list)
    {
        foreach ($list as $key => $value) {
            // var_dump($value);
            $s = $value->path;
            //转换为数组
            $arr = explode(',', $s);
            //获取数组的长度
            $len = count($arr);
            //获取逗号个数
            $dlen = $len - 1;
            //拼接分割符 str_repeat()重复字符串
            $list[$key]->name = str_repeat('|---', $dlen) . $value->name;
        }
        return $list;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $user = Permission::paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view('user.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = Permission::get();
        $data = $this->test($data);
        return view('user.permission.add', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arr = [];
        //如果要添加的是顶级分类  pid 和 path 都是0
        if ($request->parent_id == 0) {
            $arr['path'] = '0';
            $arr['parent_id'] = 0;
        } else {
            //如果不是顶级分类,读取父级分类信息
            $info = Permission::find($request->parent_id);
            $arr['parent_id'] = $request->parent_id;
            $arr['path'] = $info->path . ',' . $info->id;
        }
        $permission = Permission::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'parent_id' => $arr['parent_id'],
            'path' => $arr['path']
        ]);
        if ($permission) {
            return response()->json([
                'status' => 1, 'message' => '添加成功',
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $data['permission'] = Permission::find(request('id'));
        $data['all'] = Permission::get();
        $data['all'] = $this->test($data['all']);
        $data['parent'] = Permission::find($data['permission']->parent_id);
        return response()->view('user.permission.edit', compact('data'));
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
        $arr = [];
        //如果要添加的是顶级分类  pid 和 path 都是0
        if ($request->parent_id == 0) {
            $arr['path'] = '0';
            $arr['parent_id'] = 0;
        } else {
            //如果不是顶级分类,读取父级分类信息
            $info = Permission::find($request->parent_id);
            $arr['parent_id'] = $request->parent_id;
            $arr['path'] = $info->path . ',' . $info->id;
        }
        $permission = Permission::find($id);
        $permission->parent_id = $request->parent_id;
        $permission->name = $request->name;
        $permission->path = $arr['path'];
        $permission->display_name = $request->display_name;
        if ($permission->save()) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => $permission->toArray()
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '编辑失败',
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
        $id = request('id');
        $info = Permission::find($id);
        //删除子集分类
        $path = $info->path;
        $path = $path . ',' . $id;
        $info = Permission::where('path', 'like', $path . "%")->get();
        if ($info->isEmpty()) {
            if (Permission::where('id', $id)->delete()) {
                return response()->json([
                    'message' => '删除成功',
                    'status' => 1
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => '删除失败，请稍后重试',
                ]);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => '删除失败，该类别下面拥有子权限，请先将其删除',
            ]);
        }

    }
}
