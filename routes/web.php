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
});
//-------------------------------------------------------------------------
//报修模块路由结束


//资产管理模块路由开始
//-------------------------------------------------------------------------
Route::group(["namespace"=>"Asset",'middleware'=>['auth']],function (){

    Route::get("Address/export","AddresssController@export");
    Route::get("Address/model","AddresssController@model");
    Route::get("Address/import","AddresssController@import");
    Route::post("Address/lead","AddresssController@lead");
    Route::get("Address/add/{id}","AddresssController@add");
    Route::resource("Address","AddresssController");

    //其他报修项
    ROute::resource("otherAsset","OtherAssetController");

    Route::get("AssetType/create/{id}","AssetTypesController@create");
    Route::resource("AssetType","AssetTypesController");
    //资产入库管理
    Route::get("asset/excelTemplate","AssetsController@ExcelTemplate");
    //导出资产
    Route::get("asset/export","AssetsController@export");
    Route::get("asset/addImport","AssetsController@addImport");
    Route::post("asset/import","AssetsController@import");
    Route::get("asset/showImg/{img_id}","AssetsController@showImg");
    Route::get("asset/download/{id}","AssetsController@download");
    Route::resource("asset","AssetsController");

    //公司/部门管理
    Route::get("org/create/{id}","OrgsController@create");
    Route::resource("org","OrgsController");

    //文件信息
    Route::resource("files","FileController");
    Route::post("upload/uploadFile","UploadController@uploadFile");
    Route::resource("upload","UploadController");

});
//-------------------------------------------------------------------------
//资产管理模块路由开始
