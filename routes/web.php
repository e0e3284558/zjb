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

Route::get('/', function (Request $request) {
    return view('auth.login');
});

//认证路由开始
//--------------------------------------------------------------------------

Auth::routes();
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

//Route::get()

//cas
Route::get('cas/{uuid}/{type?}','Cas\DefaultController@index')->name('cas');

//--------------------------------------------------------------------------
//认证路由结束


//门户模块路由开始
//--------------------------------------------------------------------------

Route::get('/home', 'Portal\IndexController@index')->name('home');
Route::get('/worker','Portal\ServiceWorkerController@index')->name('worker');

//--------------------------------------------------------------------------
//门户模块路由结束

//耗材模块路由开始
//--------------------------------------------------------------------------
Route::group(['prefix'=>'consumables','namespace'=>'Consumables','middleware'=>'auth'],function (){
    Route::resource('depot','DepotController');
    Route::get('sort/{id}/createSub','SortController@createSub');
    Route::get('sort/{id}/editName','SortController@editName');
    Route::resource('sort','SortController');

    Route::get('archiving/downloadModel', 'ArchivingController@downloadModel');
    Route::get('archiving/add_import', 'ArchivingController@add_import');
    Route::post('archiving/import', 'ArchivingController@import');
    Route::get('archiving/export', 'ArchivingController@export');
    Route::resource('archiving','ArchivingController');
    Route::get('warehousing/add_foods','WarehousingController@addGoods');

    Route::resource('warehousing','WarehousingController');
    Route::get('goods/edit', 'GoodsController@edit')->name('consumables.goods.edit');
    Route::delete('goods/delete', 'GoodsController@destroy')->name('consumables.goods.destroy');
    Route::resource('goods','GoodsController');
    Route::get('shipments/select_user/{id}','ShipmentsController@selectUser');
    Route::get('shipments/shipments_goods','ShipmentsController@shipmentsGoods');
    Route::resource('shipments','ShipmentsController');
});
//--------------------------------------------------------------------------
//耗材模块路由结束



//用户模块路由开始
//-------------------------------------------------------------------------
Route::group(['prefix' => 'users', 'namespace' => 'User', 'middleware' => 'auth'], function () {
    Route::get('default/index', 'DefaultController@index')->name('users.index');
    Route::get('default/create', 'DefaultController@create')->name('users.create');
    Route::post('default/store', 'DefaultController@store')->name('users.store');
    Route::get('default/{id}', 'DefaultController@show')->name('users.show')->where('id', '[0-9]+');;
    Route::get('default/edit', 'DefaultController@edit')->name('users.default.edit');
    Route::get('default/{id}/edit', 'DefaultController@edit')->name('users.edit');
    Route::put('default/{id}', 'DefaultController@update')->name('users.update');
    Route::delete('default/delete', 'DefaultController@destroy')->name('users.destroy');

    Route::get('unit', 'DepartmentController@unit')->name('users.unit');
    Route::post('unit', 'DepartmentController@unit')->name('users.unit_edit');


    Route::get('departments', 'DepartmentController@index')->name('users.departments');
    Route::get('departments/create', 'DepartmentController@create')->name('users.departments.create');
    Route::post('departments', 'DepartmentController@store')->name('users.departments.store');
    Route::get('departments/{id}/edit', 'DepartmentController@edit')->name('users.departments.edit');
    Route::put('departments/{id}', 'DepartmentController@update')->name('users.departments.update');
    Route::delete('departments/{id}', 'DepartmentController@destroy')->name('users.departments.destroy');


    Route::get('groups', 'GroupsController@index')->name('users.groups');
    Route::get('groups/create', 'GroupsController@create')->name('users.groups.create');
    Route::post('groups/store', 'GroupsController@store')->name('users.groups.store');
    Route::get('groups/edit', 'GroupsController@edit')->name('users.groups.edit');
    Route::put('groups/{id}', 'GroupsController@update')->name('users.groups.update');
    Route::delete('groups/delete', 'GroupsController@destroy')->name('users.groups.destroy');



    Route::get('permission/edit', 'PermissionController@edit')->name('users.permission.edit');
    Route::delete('permission/delete', 'PermissionController@destroy')->name('users.permission.destroy');
    Route::resource('permission', 'PermissionController');
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
    Route::get('create_repair/success/{id}', 'CreateRepairController@success');
    Route::post('create_repair/success_store', 'CreateRepairController@successStore');
    //批量完成
    Route::get('create_repair/batch_success/{str}', 'CreateRepairController@batchSuccess');
    Route::post('create_repair/batch_success_store', 'CreateRepairController@batchSuccessStore');
    //修改状态为不可再修
    Route::post('create_repair/del/{id}', 'CreateRepairController@del');
    //批量分派
    Route::get('create_repair/edit/{arr}', 'CreateRepairController@edit');
    Route::post('create_repair/update', 'CreateRepairController@update');
    //创建报修
    Route::resource('create_repair', 'CreateRepairController');
    //选择分类
    Route::get('create_repair/select_asset/{id}', 'CreateRepairController@selectAsset');
    //分派维修工
    Route::get('create_repair/assign_worker/{id}', 'CreateRepairController@assignWorker');
    //分派维修工
    Route::get('create_repair/change_status/{id}', 'CreateRepairController@changeStatus');

    Route::get('create_repair/reason/{id}', 'CreateRepairController@reason');

    //根据选择条件选取维修工
    Route::post('create_repair/select_worker', 'CreateRepairController@selectWorker');

    //选中维修工进行派工
    Route::post('create_repair/confirm_worker', 'CreateRepairController@confirmWorker');
    //我的报修列表
    Route::get('repair_list/showImg/{id}','RepairListController@showImg');
    Route::resource('repair_list','RepairListController');

});
Route::group(['prefix' => 'repair', 'namespace' => 'Repair','middleware' => 'auth:service_workers'], function () {

    //维修人员的维修单管理
    Route::get('process/showImg/{id}','ProcessController@showImg');
    //接收维修单
    Route::post('process/create/{id}', 'ProcessController@create');
    //加载拒绝维修单视图
    Route::get('process/refuse/{str}', 'ProcessController@refuse');
    //批量接收维修单
    Route::get('process/batchEdit/{str}', 'ProcessController@batchEdit');
    //批量拒绝维修单
    Route::post('process/batchRefuse/{str}', 'ProcessController@batchRefuse');
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
    Route::get('asset_category/downloadModel', 'AssetCategoryController@downloadModel');
    Route::get('asset_category/add_import', 'AssetCategoryController@add_import');
    Route::post('asset_category/import', 'AssetCategoryController@import');
    Route::resource('asset_category', 'AssetCategoryController');

    //场地管理
    Route::get('area/add_son/{id}', 'AreaController@add');
    Route::get('area/prints', 'AreaController@prints');
    Route::get('area/export', 'AreaController@export');
    Route::get('area/downloadModel', 'AreaController@downloadModel');
    Route::get('area/add_import', 'AreaController@add_import');
    Route::post('area/import', 'AreaController@import');
    Route::resource('area', 'AreaController');

    //其他报修项
//    Route::get('other_asset/downloadModel', 'OtherAssetController@downloadModel');
//    Route::get('other_asset/add_import', 'OtherAssetController@add_import');
//    Route::post('other_asset/import', 'OtherAssetController@import');
//    Route::resource('other_asset', 'OtherAssetController');

    //资产管理
    Route::get('asset/contract_create', 'AssetController@contract_create');
    Route::post('asset/contract_store', 'AssetController@contract_store');

    Route::get('asset/show_img/{file_id}', 'AssetController@show_img');
//    Route::get('asset/add_copy/{id}', 'AssetController@add_copy');
//    Route::get('asset/copy', 'AssetController@copy');
    Route::get('asset/export', 'AssetController@export');
    Route::get('asset/downloadModel', 'AssetController@downloadModel');
    Route::get('asset/add_import', 'AssetController@add_import');
    Route::post('asset/import', 'AssetController@import');
    Route::get('asset/slt_supplier/{id}', 'AssetController@slt_supplier');
    Route::resource('asset', 'AssetController');

    //资产调拨
    Route::get('asset_transfer/slt_asset',"AssetTransferController@slt_asset");
//    Route::get('asset_transfer/put_slt_asset',"AssetTransferController@put_slt_asset");
    Route::resource('asset_transfer','AssetTransferController');

    //领用
    Route::get('asset_use/slt_asset',"AssetUseController@slt_asset");
    Route::post('asset_use/lists','AssetUseController@lists');
    Route::resource('asset_use','AssetUseController');
    //退库
    Route::get('asset_return/slt_asset',"AssetReturnController@slt_asset");
    Route::resource("asset_return",'AssetReturnController');
    //借用&归还
    Route::get('borrow/slt_asset',"BorrowController@slt_asset");
    Route::resource('borrow','BorrowController');

    //清理报废
    Route::get('asset_clear/slt_asset',"AssetClearController@slt_asset");
    Route::resource("asset_clear","AssetClearController");

    //供应商管理
    Route::get('supplier/export', 'SupplierController@export');
    Route::get('supplier/downloadModel', 'SupplierController@downloadModel');
    Route::get('supplier/add_import', 'SupplierController@add_import');
    Route::post('supplier/import', 'SupplierController@import');
    Route::post("supplier/page_pro",'SupplierController@page_pro');
    Route::resource("supplier",'SupplierController');

    //合同管理
    Route::post("contract/bill_store",'ContractController@bill_store');
    Route::get("contract/add_bill/{id}",'ContractController@add_bill');
    Route::post("contract/bill_del",'ContractController@bill_del');
    Route::get("contract/test",'ContractController@test');
    Route::resource("contract",'ContractController');

    //清单管理

//    Route::post("bill/asset_store",'BillController@asset_store');
//    Route::get("bill/create/{id}",'BillController@create');
//    Route::get("bill/create/{id}",'BillController@create');
//    Route::resource("bill",'BillController');

    //附件信息
    Route::post("upload/uploadFile", "UploadController@uploadFile");
    Route::resource("upload", "UploadController");
});
//-------------------------------------------------------------------------
//资产管理模块路由开始


//文件管理模块路由开始
//-------------------------------------------------------------------------
Route::group(['prefix' => 'file', 'namespace' => 'File'],function () {
    Route::post('image_upload', 'DefaultController@imageUpload')->name('image.upload');
    Route::post('img_file', 'DefaultController@imgFile');
    Route::post('delete_img_file', 'DefaultController@deleteImgFile');
});
Route::group(['prefix' => 'file', 'namespace' => 'File', 'middleware' => 'auth'], function () {
    Route::post('image_upload', 'DefaultController@imageUpload')->name('image.upload');
    Route::post('file_upload', 'DefaultController@fileUpload')->name('file.upload');
    Route::post('video_upload', 'DefaultController@videoUpload')->name('video.upload');
    Route::post('asset_file_upload', 'DefaultController@assetFileUpload')->name('asset.file.upload');
});

//-------------------------------------------------------------------------
//文件管理模块路由结束

//个人信息及密码修改
//-------------------------------------------------------------------------

Route::group(['prefix' => 'users', 'namespace' => 'User'], function () {
    Route::resource('pensonal', 'PensonalController');
});

//-------------------------------------------------------------------------
//维修工登录



//微信小程序API路由开始
//-------------------------------------------------------------------------

Route::group(['prefix' => 'wx', 'namespace' => 'WX'], function () {
    Route::post('worker_login', 'WxLoginController@workerLogin');
    Route::post("phone_authorize",'WxLoginController@phoneAuthorize');
    Route::post("find_phone",'WxLoginController@findPhone');
    Route::post("authentication",'WxLoginController@authentication');
    Route::post("need_validation",'WxLoginController@needValidation');
    Route::post("job_number",'WxLoginController@jobNumber');
    Route::post("login",'WxLoginController@login');

    Route::post("asset_find",'WxAssetController@find');

    //报修管理
    Route::post("repair/add",'WxRepairController@add');
    Route::post("repair/repair_list",'WxRepairController@repairList');
    //工单详情
    Route::post("repair/repair_info",'WxRepairController@repairInfo');
    //提交评价信息
    Route::post("repair/evaluate",'WxRepairController@evaluate');
    //维修人员的待服务列表(还未确认接的单)
    Route::post("repair/service_list",'WxRepairController@ServiceList');
    //维修人员点击确认接单
    Route::post("repair/confirm_repair",'WxRepairController@confirmRepair');
    //维修人员填写维修结果
    Route::post("repair/write_result",'WxRepairController@writeResult');
    //维修人员拒绝接单
    Route::post("repair/refuse_repair",'WxRepairController@refuseRepair');
    //用户查看已完成工单全部详情
    Route::post("repair/repair_all_info",'WxRepairController@repairAllInfo');
    //用户投诉表单提交
    Route::post("repair/complain",'WxRepairController@complain');
    Route::resource("repair",'WxRepairController');

    //场地报修管理
    Route::post("area/find_area",'WxAreaController@findArea');
    Route::post("area/find_asset",'WxAreaController@findAsset');

});

//-------------------------------------------------------------------------
//微信小程序API路由结束


