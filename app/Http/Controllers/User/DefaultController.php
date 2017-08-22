<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
    public function index(){
       return view('user.user.index');
    }


}
