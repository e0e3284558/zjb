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
Route::group(['prefix' => 'users', 'namespace' => 'User', 'middleware' => 'auth'], function () {
    Route::get('default/index', 'DefaultController@index')->name('users.index');
    Route::get('default/create', 'DefaultController@create')->name('users.create');
    Route::post('default/store', 'DefaultController@store')->name('users.store');
    Route::get('default/{id}', 'DefaultController@show')->name('users.show');
    Route::get('default/search/{value}', 'DefaultController@search')->name('users.show');
    Route::get('default/{id}/edit', 'DefaultController@edit')->name('users.edit');
    Route::put('default/{id}', 'DefaultController@update')->name('users.update');
    Route::delete('default/{id}', 'DefaultController@destroy')->name('users.destroy');

    Route::get('unit', 'DepartmentController@unit')->name('users.unit');
    Route::post('unit', 'DepartmentController@unit')->name('users.unit_edit');


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
Route::group(['prefix' => 'repair', 'namespace' => 'Repair', 'middleware' => 'auth'], function () {
    //报修分类
    Route::resource('classify', 'ClassifyController');
    //维修工管理
    Route::resource('service_worker', 'ServiceWorkerController');
    //服务商管理
    Route::resource('service_provider', 'ServiceProviderController');
    //完成报修
    Route::post('create_repair/success/{id}', 'CreateRepairController@success');
    //修改状态为不可再修
    Route::post('create_repair/del/{id}', 'CreateRepairController@del');
    //创建报修
    Route::resource('create_repair', 'CreateRepairController');

    //选择分类
    Route::get('create_repair/select_asset/{id}', 'CreateRepairController@selectAsset');
    //分派维修工
    Route::get('create_repair/assign_worker/{id}', 'CreateRepairController@assignWorker');
    //分派维修工
    Route::get('create_repair/change_status/{id}', 'CreateRepairController@changeStatus');

    //根据选择条件选取维修工
    Route::post('create_repair/select_worker', 'CreateRepairController@selectWorker');
    //选中维修工进行派工
    Route::post('create_repair/confirm_worker', 'CreateRepairController@confirmWorker');

});
Route::group(['prefix' => 'repair', 'namespace' => 'Repair'], function () {

    //我的报修列表
    Route::resource('repair_list','RepairListController');
    //报修流程
    Route::post('process/create/{id}', 'ProcessController@create');
    Route::get('process/refuse/{id}', 'ProcessController@refuse');
    Route::resource('process', 'ProcessController');
});
//-------------------------------------------------------------------------
//报修模块路由结束


//资产管理模块路由开始
//-------------------------------------------------------------------------
Route::group(["namespace" => "Asset", 'middleware' => ['auth']], function () {
    //资产分类
    Route::get('asset_category/add_son/{id}', 'AssetCategoryController@add');
    Route::get('asset_category/find/{id}', 'AssetCategoryController@find');
    Route::get('asset_category/export', 'AssetCategoryController@export');
    Route::resource('asset_category', 'AssetCategoryController');

    Route::get('area/add_son/{id}', 'AreaController@add');
    Route::get('area/prints', 'AreaController@prints');
    Route::get('area/export', 'AreaController@export');
    Route::get('area/downloadModel', 'AreaController@downloadModel');
    Route::resource('area', 'AreaController');

    //其他报修项
    Route::get('other_asset/downloadModel', 'OtherAssetController@downloadModel');
    Route::get('other_asset/add_import', 'OtherAssetController@add_import');
    Route::post('other_asset/import', 'OtherAssetController@import');
    Route::resource('other_asset', 'OtherAssetController');

    //资产管理
    Route::get('asset/show_img/{file_id}', 'AssetController@show_img');
    Route::get('asset/add_copy/{id}', 'AssetController@add_copy');
    Route::post('asset/copy', 'AssetController@copy');
    Route::resource('asset', 'AssetController');

    //附件信息
    Route::post("upload/uploadFile", "UploadController@uploadFile");
    Route::resource("upload", "UploadController");
});
//-------------------------------------------------------------------------
//资产管理模块路由开始


//文件管理模块路由开始
//-------------------------------------------------------------------------

Route::group(['prefix' => 'file', 'namespace' => 'File', 'middleware' => 'auth'], function () {
    Route::post('image_upload', 'DefaultController@imageUpload')->name('image.upload');
    Route::post('file_upload', 'DefaultController@fileUpload')->name('file.upload');
    Route::post('video_upload', 'DefaultController@videoUpload')->name('video.upload');
    Route::post('asset_file_upload', 'DefaultController@assetFileUpload')->name('asset.file.upload');
});

//-------------------------------------------------------------------------
//文件管理模块路由结束

//维修工登录
//-------------------------------------------------------------------------

Route::group(['namespace' => 'Repair'], function () {
    Route::resource('work_login', 'WorkerLoginController');
});

//-------------------------------------------------------------------------
//维修工登录