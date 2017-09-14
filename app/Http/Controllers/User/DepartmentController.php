<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\DepartmentRequest;
use App\Models\User\Department;
use App\Models\User\Org;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class DepartmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | 单位组织机构管理
    |--------------------------------------------------------------------------
    |
    | 管理单位组织机构（部门）信息、单位管理员查看管理单位基本信息
    |
    */

    /**
     * 单位基本信息
     *
     * @return \Illuminate\Http\Response
     */
    public function unit(Request $request)
    {
        if ($request->method() == 'POST') {
            //表单验证
            $rules = [
                'name' => 'bail|required',
                'short_name' => 'bail|required',
                'contacts' => 'bail|required',
                'contacts_tel' => 'bail|required'
            ];
            $message = [
                'name.required' => '请填写单位全称',
                'short_name.required' => '请填写单位简称',
                'contacts.required' => '请填写单位联系人姓名',
                'contacts_tel.required' => '请填写单位联系电话',
            ];
            $data = Input::all();
            $validator = Validator::make($data, $rules, $message);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            } else {
                //编辑数据
                $unit = Org::userUint()->first();
                if ($unit) {
                    $unit->name = $data['name'];
                    $unit->short_name = $data['short_name'];
                    $unit->logo = $data['logo'];
                    $unit->describe = $data['describe'];
                    $unit->contacts = $data['contacts'];
                    $unit->contacts_tel = $data['contacts_tel'];
                    $unit->contacts_postion = $data['contacts_postion'];
                    $unit->contacts_email = $data['contacts_email'];
                    if ($unit->save()) {
                        return response()->json([
                            'status' => 1, 'message' => '保存成功',
                            'data' => $unit->toArray(), 'url' => ''
                        ]);
                    } else {
                        return response()->json([
                            'status' => 0, 'message' => '保存失败'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 0, 'message' => '无效参数'
                    ]);
                }
            }
        } else {
            $unit = Org::userUint()->first();
            return view('user.department.unit', ['unit' => $unit]);
        }
    }


    /**
     * 单位组织机构信息
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //获取所有部门信息
        if (request('tree') == 1) {
            $select = $request->select;
            $name = $request->name;
            $where = [];
            if($name){
                $where[] = ['name','like',"%{$name}%"];
            }
            $list = Department::org()->where($where)->get()->toArray();
            $org = get_current_login_user_org_info('name')->name;
            $tempData = [
                [
                    'id' => 0,
                    'parent_id' => -1,
                    'text' => $org,
                    'name' => $org,
                    'href' => '',//编辑地址
                    'icon' => asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/global.gif')
                ]
            ];
            if ($list) {
                /*//获取树形菜单(jsTree使用)
                foreach ($list as $key => $v) {
                    $temp = array(
                        'id' => $v['id'],
                        'parent_id' => $v['parent_id'],
                        'text' => $v['name']
                    );
                    $temp['li_attr'] = array(
                        'data-datas' => json_encode($v)
                    );
                    $temp['a_attr'] = array(
                        'href' => url('users/departments/' . $v['id'] . '/edit')
                    );
                    if ($select == $v['id']) {
                        $temp["state"] = array(
                            "open" => true,
                            "selected" => true
                        );
                    }
                    $tempData[] = $temp;
                }
                $tempData = list_to_tree($tempData, 'id', 'parent_id', 'children');
                */
                foreach ($list as $key => $val) {
                    $val['href'] = url('users/departments/' . $val['id'] . '/edit');
//                    if($val['is_company']){
//                        $val['icon'] = asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/home.gif');
//                    }else{
                        $val['icon'] = asset('assets/js/plugins/zTree/css/zTreeStyle2/img/diy/sub.gif');
//                    }
                    $tempData[] = $val;
                }
            }
            return response()->json($tempData);
        }
//        $list = Department::getSpaceTreeData();
        return view('user.department.index');
    }

    public function create()
    {
        return view('user.department.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        $department = new Department;
        $department->name = $request->name;
        $department->status = $request->status;
        $department->sort = $request->sort;
        $department->parent_id = $request->parent_id;
        $department->org_id = auth()->user()->org_id;
        if ($department->save()) {
            return response()->json([
                'status' => 1, 'message' => '添加成功',
                'data' => $department->toArray(), 'url' => url('users/departments?tree=1&select=' . $department->id)
            ]);
        } else {
            return response()->json([
                'status' => 0, 'message' => '保存失败',
                'data' => null, 'url' => ''
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User\Department $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department, $id)
    {
        $dep = $department->findOrFail($id);
        return view('user.department.edit', ['department' => $dep]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\User\Department $department
     * @return \Illuminate\Http\Response
     */
    public function update(DepartmentRequest $request, Department $department, $id)
    {
        $dep = $department->findOrFail($id);
        $dep->name = $request->name;
        $dep->parent_id = $request->parent_id;
        $dep->sort = $request->sort;
        $dep->status = $request->status;
        if ($dep->save()) {
            return response()->json([
                'status' => 1, 'message' => '编辑成功',
                'data' => $dep->toArray(), 'url' => url('users/departments?tree=1&select=' . $id)
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
     * @param  \App\Models\User\Department $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department, $id)
    {
        $result = [
            'status' => 1,
            'message' => '操作成功',
            'data' => '',
            'url' => '',
        ];
        $dp = $department->find($id);
        if ($dp) {
            $flag = 1;
            //判断是否有子部门
            if ($department->where(['parent_id' => $id])->first()) {
                $result['status'] = 0;
                $result['message'] = '存在子部门信息不能删除';
                $flag = 0;
            }
            //检测是否包含其他数据如部门用户
            if (User::where('department_id', $id)->first()) {
                $result['status'] = 0;
                $result['message'] = '该部门存在用户关联数据不能删除';
                $flag = 0;
            }
            //删除
            if ($flag && !$dp->delete()) {
                $result['status'] = 0;
                $result['message'] = '删除失败';
            }
        } else {
            $result['status'] = 0;
            $result['message'] = '操作的信息不存在';
        }
        return response()->json($result);
    }
}
