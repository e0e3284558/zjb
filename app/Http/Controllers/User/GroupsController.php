<?php

namespace App\Http\Controllers\User;

use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use function Sodium\compare;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class GroupsController extends Controller
{
    /**
     * @param $list
     * @return mixed
     */

    public function index(Request $request)
    {
       if ($res = is_permission('role.index')){
           return $res;
       }
        if ($request->ajax()) {
            $user = Role::paginate(request('limit'));
            $data = $user->toArray();
            $data['msg'] = '';
            $data['code'] = 0;
            return response()->json($data);
        }
        return view('user.group.index');
    }

    public function create()
    {
        is_permission('role.add');
        $permission = Permission::get()->toJson();
        return view('user.group.add', compact('permission'));
    }


    public function store(Request $request)
    {
        if ($res = is_permission('role.add')){
            return $res;
        }
        $role_res = Role::create([
            'name' => $request->name,
            'display_name' => $request->name,
            'org_id' => Auth::user()->org_id
        ]);
        if (!$role_res) {
            return response()->json([
                'status' => 0, 'message' => '添加失败',
                'data' => null, 'url' => ''
            ]);
        }
        $role = Role::findByName($request->name);
        $permission_name = explode(',', $request->permission);
        foreach ($permission_name as $v) {
            $role->givePermissionTo($v);
        }
        if ($role) {
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

    public function edit()
    {
        if ($res = is_permission('role.edit')){
            return $res;
        }
        $permission = [];
        $permissions = [];
        $role = Role::find(request('id'));
        //取出当前已选中的权限
        $select_permission = DB::table('role_has_permissions')
            ->where('role_id', $role->id)->get()->toArray();
        //将取出的数据，进行处理，只保留权限数据
        foreach ($select_permission as $p) {
            $permissions[] = $p->permission_id;
        }
        //以数组的形式取出所有权限
        $data = Permission::get()->toArray();
        //将当前以选中的权限进行  增加checked属性
        foreach ($data as $v) {
            if (in_array($v['id'], $permissions)) {
                $v['checked'] = 'true';
            }
            $permission[] = $v;
        }
        //转换为Json形式
        $permission = json_encode($permission);
        return response()->view('user.group.edit', compact('role', 'permission'));
    }

    public function update(Request $request, $id)
    {
        if ($res = is_permission('role.edit')){
            return $res;
        }
        //取回Role实例
        $role = Role::find($id);
        //拆分数组
        $permission_name = explode(',', $request->permission);
        //更新权限
        $role->syncPermissions($permission_name);
        //更新名字
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        if ($role->save()) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => $role->toArray()
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
        if ($res = is_permission('role.del')){
            return $res;
        }
        $id = request('id');
        $id = array_unique((array)$id);
        if (count($id) == 1 && !current($id)) {
            return response()->json([
                'status' => 0,
                'message' => '请选择要操作的数据',
            ]);
        }
        DB::table('model_has_roles')->whereIn('role_id', $id)->delete();
        DB::table('role_has_permissions')->whereIn('role_id', $id)->delete();
        if (Role::whereIn('id', $id)->delete()) {
            return response()->json([
                'message' => '删除成功',
                'status' => 1
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => '删除失败，请稍候重试',
            ]);

        }
    }


}
