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
//不判断登陆的路由组
Route::group(['middleware'=>['web'],'namespace'=>'Admin','prefix'=>
    'ad'],function(){
    Route::get('login', 'LoginController@login');       //后台登录
    Route::get('imgCode', 'LoginController@imgCode');   //验证码
    Route::get('loginOut','LoginController@outLogin');  //退出登录
    Route::post('check', 'LoginController@check');       //后台登陆操作
});
//不验证权限的通用路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>
    'ad'],function () {
    Route::get('index', 'IndexController@index');                        //首页
    Route::get('welcome', 'IndexController@welcome');                    //首页
    Route::get('test', 'IndexController@test');                          //测试
});

//权限角色为admin才能访问的路由组
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:admin'],'prefix'=>
    'ad'],function (){
    Route::any('userlist','UserController@index');                   //用户列表
    Route::any('useradd','UserController@userAdd');                     //后台自定义添加用户
    Route::resource('role','RoleController');                     //权限管理-角色管理
    Route::post('role/fuzzySearch','RoleController@fuzzySearch');                     //权限管理-角色管理-模糊搜索
    Route::resource('user','UserController');
    Route::post('user/fuzzySearch','UserController@fuzzySearch');//模糊搜素
    Route::get('user/userRole/{id}','UserController@userRole');//用户的所有角色列表
    Route::get('addRole/{id}','UserController@addRole');//分配角色视图
    Route::post('allotRole','UserController@allotRole');//分配角色操作
    Route::get('removeRole/{id}/{roleName}','UserController@removeRole');//分配角色操作
    Route::get('roleListInAddView/{id}','UserController@roleListInAddView');//从角色列表中为用户添加角色
    Route::get('roleListInAdd/{roleid}/{id}','UserController@roleListInAdd');//从角色列表中为用户添加角色
});
//权限角色为采购才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:采购|admin'],'prefix'=>'ad'],function () {
    Route::get('purchase/pur', 'PurchaseController@PurList');                        //采购列表
    Route::any('purchase/purAdd', 'PurchaseController@PurAdd');                        //采购申请表页
    Route::any('purchase/purtoadd', 'PurchaseController@PurToAdd');                        //采购申请表页
    Route::any('purchase/info', 'PurchaseController@info');                         //查看订单中零件详情
    Route::get('purchase/edit/{id}','PurchaseController@edit');                          //修改采购页面
    Route::post('purchase/update','PurchaseController@store');                          //提交修改采购页面
    Route::get('purchase/delete/{no}','PurchaseController@delete');                     //删除采购订单
   Route::post('purchase/search','PurchaseController@search');    // 模糊搜索采购订单
});
//权限角色为零部件质检的才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:质检|admin'],'prefix'=>'ad'],function () {
    Route::get('quality','QualityController@index');                                        //质检列表
    Route::get('quality/show/{order_number}','QualityController@show');                     //质检详情
    Route::post('quality/store','QualityController@store');                                 //提交
    Route::get('quality/img/{order_number}','QualityController@img');                       //查看质检结果
    Route::post('quality/search','QualityController@search');                               //模糊搜索质检结果
});

//权限角色为仓库库管才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:库管|admin'],'prefix'=>'ad'],function (){
    //零部件仓库    入库
    Route::get('spare','SparePartsController@index');                                       //零部件仓库列表
    Route::get('spare/add/{order_number}','SparePartsController@addparts');                 //零部件入库页
    Route::get('spare/shelve/info','SparePartsController@shelveinfo');                      //货架信息
    Route::post('spare/addSpare','SparePartsController@store');                             //提交入库信息
    Route::get('spare/inrecord/{order_no}','SparePartsController@record');                  //查看单个订单入库记录
    Route::post('spare/WarehousingRecord','SparePartsController@WarehousingRecord');                  //查看入库记录中零部件信息
    //零部件仓库     出库
    Route::get('spare/out','SparePartsController@outlist');                                 //零部件列表
    Route::get('spare/outInfo/{part_id}/{part_number}','SparePartsController@outToInfo');                             //零部件出库
    Route::get('spare/outAll/{data}','SparePartsController@outToAll');                             //多个零部件出库跳转控制器
    Route::post('spare/outadd','SparePartsController@outAdd');                              //单个零部件出库提交
    Route::post('spare/outMany','SparePartsController@outMany');                             //多个零部件出库展示视图
});

//权限角色为库管才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:库管|admin'],'prefix'=>'ad'],function (){
    Route::resource('storageRoom','StorageRoomController');//库房资源控制器
    Route::post('storageRoom/fuzzySearch','StorageRoomController@fuzzySearch');//库房模糊搜素
    Route::resource('goodsShelve','GoodsShelveController');//货架资源控制器
    Route::get('goodsList/{goodsShelveId}','GoodsShelveController@goodsList');//货架内货物列表  货架id
    Route::post('goodsList/fuzzySearch','GoodsShelveController@goodsFuzzySearch');//物品模糊搜索
    Route::post('goodsShelve/fuzzySearch','GoodsShelveController@fuzzySearch');//货架模糊搜索
    Route::get('goodsShelveAdd/{id}','GoodsShelveController@goodsShelveAdd');//返回添加货架视图
});
// 权限角色为生产查看才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:生产|admin'],'prefix'=>'ad'],function () {
    Route::get('productionOrder', 'ProductionController@orderList');//生产订单查看
    Route::get('productionHandle/{orderId}', 'ProductionController@productionHandle');//生产订单处理
    Route::post('productionFuzzySearch', 'ProductionController@fuzzySearch');//生产订单处理
    Route::post('productionPlan', 'ProductionController@productionPlan');//生产计划添加
    Route::get('productionPlanAddView/{orderId}', 'ProductionController@productionPlanAddView');//生产计划添加视图
    Route::get('productionPlanInfo/{orderId}', 'ProductionController@productionPlanInfo');//生产计划详情
    Route::get('productionPlanFinish/{orderId}', 'ProductionController@productionPlanFinish');//生产计划完成
    Route::get('productionRecordView/{orderId}', 'ProductionController@productionRecordView');//生产记录登记视图
    Route::post('productionMakeRecord', 'ProductionController@productionMakeRecord');//生产记录登记
    Route::get('productionRecordList/{orderId}', 'ProductionController@productionRecordList');//生产记录列表
    Route::get('productExcelDown/{orderId}', 'ProductionController@productExcelDown');//成品记录excel导出
    Route::get('partExcelDown/{orderId}', 'ProductionController@partExcelDown');//零部件清单excel导出
    Route::get('codeMake/{orderId}', 'ProductionController@codeMake');//零部件清单excel导出
    Route::get('test', 'ProductionController@test');//零部件清单excel导出
});

//成品质检 角色才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:质检|admin'],'prefix'=>'ad'],function (){
    Route::get('qualityProductionOrder','ProductQualityController@orderList');//生产订单查看
    Route::get('qualityAddView/{orderId}','ProductQualityController@qualityAddView');//质检添加
    Route::post('qualityAdd','ProductQualityController@qualityAdd');//质检添加
});

//成品入库 角色才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:库管|admin'],'prefix'=>'ad'],function (){
    Route::get('productWarehousingOrderList','ProductWarehousingController@orderList');//订单查看
    Route::get('productWarehousingView/{orderId}','ProductWarehousingController@productWarehousingView');//成品入库视图
    Route::post('productWarehousing','ProductWarehousingController@productWarehousing');//成品入库
    Route::get('shelfInfo/{storageRoomId}','ProductWarehousingController@shelfInfo');//展示货架信息
    Route::get('warehousingNumber/{orderId}','ProductWarehousingController@warehousingNumber');//已入库数量查询
    Route::get('productWarehousingRecord/{orderId}','ProductWarehousingController@productWarehousingRecord');//入库记录查看

});
//成品出库 角色才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:库管|admin'],'prefix'=>'ad'],function (){
    Route::get('ProductOutStorageRecordOrderList','ProductOutStorageRecordController@orderList');//订单查看
    Route::get('productOutStorageView/{OrderId}','ProductOutStorageRecordController@productOutStorageView');//出库视图
    Route::post('productOutStorage','ProductOutStorageRecordController@productOutStorage');//出库处理
    Route::get('outStorageNumber/{OrderId}','ProductOutStorageRecordController@outStorageNumber');//出库数量查询
    Route::get('productOutStorageRecord/{OrderId}','ProductOutStorageRecordController@productOutStorageRecord');//出库记录列表


});

