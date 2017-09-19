<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\UserRequest;
use App\Models\Repair\ServiceWorker;
use App\Models\User\Department;
use App\Models\User\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PensonalController extends Controller
{
    /**个人用户信息
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth('service_workers')->user()){
            $data = ServiceWorker::find(get_current_login_user_info('id','service_workers'));
        }else{
            $data = User::find(get_current_login_user_info('id'));
        }
        $data->depatment_id = Department::where("id",$data->department_id)->value("name");
        return response()->view('user.pensonal.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth('service_workers')->user()){
            $data = ServiceWorker::find(get_current_login_user_info('service_workers'));
        }else{
            $data = User::find(get_current_login_user_info('id'));
        }
        return response()->view('user.pensonal.edit', compact('data'));
    }

    /**
     * 修改个人账户密码
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(auth('service_workers')->user()){
            $user = ServiceWorker::find(get_current_login_user_info('id','service_workers'));
            // $user->username = $request->username;
            $user->name = $request->name;
            if ($request->password != null) $user->password = bcrypt($request->password);
            $user->tel = $request->tel;
//            $user->email = $request->email;
        }else{
            $user = User::find(get_current_login_user_info('id'));
            // $user->username = $request->username;
            $user->name = $request->name;
            if ($request->password != null) $user->password = bcrypt($request->password);
            $user->tel = $request->tel;
//            $user->email = $request->email;
        }
        if ($user->save()) {
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
