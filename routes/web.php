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
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//--------------------------------------------------------------------------
//认证路由结束


//门户模块路由开始
//--------------------------------------------------------------------------

Route::get('/home', 'Portal\IndexController@index')->name('home');


//--------------------------------------------------------------------------
//门户模块路由结束


//用户模块路由开始
//-------------------------------------------------------------------------
Route::group(['prefix' => 'users','namespace' => 'User','middleware'=>'auth'], function () {
    Route::get('index', 'DefaultController@index')->name('users.index');
    
    Route::get('unit', 'DepartmentController@unit')->name('users.unit');
    

    Route::get('departments', 'DepartmentController@index')->name('users.departments');
    Route::get('departments/create', 'DepartmentController@create')->name('users.departments.create');
    Route::post('departments', 'DepartmentController@store')->name('users.departments.store');
    Route::get('departments/{id}/edit', 'DepartmentController@edit')->name('users.departments.edit');
    Route::put('departments/{id}', 'DepartmentController@update')->name('users.departments.update');
    Route::delete('departments/{id}', 'DepartmentController@destroy')->name('users.departments.destroy');


    Route::get('groups', 'GroupsController@index')->name('users.groups');
});
//-------------------------------------------------------------------------
//用户模块路由结束



//报修模块路由开始
//-------------------------------------------------------------------------
Route::group(['prefix' => 'repair','namespace' => 'Repair'], function () {
    //报修分类
    Route::resource('classify', 'ClassifyController');
    Route::resource('service_worker', 'ServiceWorkerController');
});
//-------------------------------------------------------------------------
//报修模块路由结束


//资产管理模块路由开始
//-------------------------------------------------------------------------
Route::group(["namespace"=>"Asset",'middleware'=>['auth']],function (){
    //资产分类
    Route::get('asset_category/add_son/{id}','AssetCategoryController@add');
    Route::get('asset_category/find/{id}','AssetCategoryController@find');
    Route::resource('asset_category','AssetCategoryController');

    Route::get('area/add_son/{id}','AreaController@add');
    Route::resource('area','AreaController');

    //其他报修项
    Route::resource('other_asset','OtherAssetController');

    //附件信息
    Route::post("upload/uploadFile","UploadController@uploadFile");
    Route::resource("upload","UploadController");
});
//-------------------------------------------------------------------------
//资产管理模块路由开始
