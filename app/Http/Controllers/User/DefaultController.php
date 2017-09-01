<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 单位用户管理
    |--------------------------------------------------------------------------
    |
    | 管理单位用户所在单位的所有用户信息（维修工、普通用户、管理员设置）
    |
    */

    /**
     * 单位用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::where('org_id', Auth::user()->org_id)->with('department')->get();
        return view('user.user.index', compact('data'));
    }

    /**
     * 单位用户创建
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('user.user.add');
    }

    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->department_id = $request->department_id;
        $user->avatar = $request->avatar;
        $user->org_id = $request->org_id;
        if ($user->save()) {
            return response()->json([
                'status' => 1, 'message' => '添加成功'
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '添加失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    public function show($id)
    {
        if ($id=='*'){
            $data = User::where('org_id', Auth::user()->org_id)->with('department')->get();
        }else{
            $data = User::where('department_id',$id)->with('department')->get();
        }

        return  response()->view('user.user.show', compact('data','id'));
    }

    public function search($value)
    {
        if ($value){
            $data = User::where('name','like', "$value%")->with('department')->get();
            return  response()->view('user.user.show', compact('data'));
        }

    }

    public function edit($id)
    {
        $data = User::find($id);
        return response()->view('user.user.edit', compact('data'));
    }

    /**
     * 更新用户信息
     * @param Request $id
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        if ($request->password != null) $user->password = bcrypt($request->password);
        $user->department_id = $request->department_id;
        $user->tel = $request->tel;
        $user->email = $request->email;
        $user->avatar = $request->avatar;
        $user->org_id = $request->org_id;
        if ($user->save()) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => $user->toArray()
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '编辑失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    public function destroy($id)
    {
        if (User::where('id', $id)->delete()) {
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
