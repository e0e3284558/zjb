<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserRequest;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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
    public function index(Request $request)
    {
        $user = get_current_login_user_info(true);
        if (!$user->hasAnyPermission('user')) {
            return redirect('/home');
        }
        if ($request->ajax()) {
            $search = $request->get('search');
            $department = $request->get('department_id');
            $name = $request->get('name');
            $username = $request->get('username');
            $tel = $request->get('tel');
            $email = $request->get('email');
            $user = User::where('org_id', get_current_login_user_org_id())
                ->where(function ($query) use ($search) {
                    $query->when($search, function ($querys) use ($search) {
                        $querys->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('tel', 'like', "%{$search}%")
                            ->orWhere('username', 'like', "%{$search}%");
                    });
                })->when($department, function ($query) use ($department) {
                    $query->where('department_id', $department);
                })->when($name, function ($query) use ($name) {
                    $query->where('name', 'like', "%{$name}%");
                })->when($username, function ($query) use ($username) {
                    $query->where('username', 'like', "%{$username}%");
                })->when($tel, function ($query) use ($tel) {
                    $query->where('tel', 'like', "%{$tel}%");
                })->when($email, function ($query) use ($email) {
                    $query->where('email', 'like', "%{$email}%");
                })->orderBy('id', 'desc')->with('department')->paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
//        $data = User::where('org_id', Auth::user()->org_id)->with('department')->orderBy('id','desc')->get();
        return view('user.user.index');
    }

    /**
     * 单位用户创建
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role = Role::where('org_id', Auth::user()->org_id)->get();
        return view('user.user.add', compact('role'));
    }

    public function store(UserRequest $request)
    {
        $user = new User;
        $user->username = $request->username;
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->email = $request->email;
        $user->tel = $request->tel;
        $user->department_id = $request->department_id ? $request->department_id : 0;
//        $user->avatar = $request->avatar;
        $user->org_id = get_current_login_user_org_id();
        if ($user->save()) {
            $user = User::where('username', $request->username)->first();
            $user->assignRole($request->role);
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => $user->toArray(), 'url' => ''
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
        if ($id == '*') {
            $data = User::where('org_id', Auth::user()->org_id)->with('department')->get();
        } else {
            $data = User::where('department_id', $id)->with('department')->get();
        }

        return response()->view('user.user.show', compact('data', 'id'));
    }

    public function search($value)
    {
        if ($value) {
            $data = User::where('name', 'like', "$value%")->with('department')->get();
            return response()->view('user.user.show', compact('data'));
        }

    }

    public function edit()
    {
        $data = User::find(request('id'));
        $role = Role::where('org_id', Auth::user()->org_id)->get();
        $select_role = DB::table('model_has_roles')
            ->where('model_type', 'App\Models\User\User')
            ->where('model_id', $data->id)
            ->first()->role_id;
        return response()->view('user.user.edit', compact('data', 'role', 'select_role'));
    }

    /**
     * 更新用户信息
     * @param Request $id
     * @param $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        if ($request->password != null) $user->password = bcrypt($request->password);
        $user->department_id = $request->department_id ? $request->department_id : 0;
        $user->tel = $request->tel;
        $user->email = $request->email;
//        $user->avatar = $request->avatar;
        if ($user->save()) {
            $user->syncRoles($request->role);
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => User::with('department')->find($user->id)->toArray()
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '编辑失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    public function destroy()
    {
        $id = request('id');
        $id = array_unique((array)$id);
        if (count($id) == 1 && !current($id)) {
            return response()->json([
                'status' => 0,
                'message' => '请选择要操作的数据',
            ]);
        }
        if (User::where('is_org_admin', '<>', 1)
            ->whereIn('id', $id)->delete()
        ) {
            if (DB::table('model_has_roles')
                ->where('model_type', 'App\Models\User\User')
                ->whereIn('model_id', $id)->delete()) {
                return response()->json([
                    'message' => '删除成功',
                    'status' => 1
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => '用户删除成功，关联角色删除失败',
                ]);
            }
        } else {
            return response()->json([
                'status' => 0,
                'message' => '删除失败，请稍后重试',
            ]);
        }

    }


}
