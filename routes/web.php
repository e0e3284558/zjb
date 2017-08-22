<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//认证路由开始
//--------------------------------------------------------------------------

Auth::routes();

//--------------------------------------------------------------------------
//认证路由结束


//门户模块路由开始
//--------------------------------------------------------------------------

Route::get('/home', 'Portal\IndexController@index')->name('home');


//--------------------------------------------------------------------------
//门户模块路由结束


//用户模块路由开始
//-------------------------------------------------------------------------
Route::group(['prefix' => 'users','namespace' => 'User'], function () {
    Route::get('index', 'DefaultController@index')->name('users.index');
    Route::get('unit', 'OrganizationController@unit')->name('users.unit');
    Route::get('orgs', 'OrganizationController@index')->name('users.orgs');
    Route::get('groups', 'GroupsController@index')->name('users.groups');
});
//-------------------------------------------------------------------------
//用户模块路由结束



//报修模块路由开始
//-------------------------------------------------------------------------
Route::group(['prefix' => 'repair','namespace' => 'Repair'], function () {
    //报修分类
    Route::resource('classify', 'ClassifyController');
});
//-------------------------------------------------------------------------
//报修模块路由结束