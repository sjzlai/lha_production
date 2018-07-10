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
//权限角色为采购才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>'ad'],function () {
    Route::get('purchase/pur', 'PurchaseController@PurList');                        //采购列表
    Route::any('purchase/purAdd', 'PurchaseController@PurAdd');                        //采购申请表页
    Route::any('purchase/purtoadd', 'PurchaseController@PurToAdd');                        //采购申请表页
    Route::any('purchase/info', 'PurchaseController@info');                         //查看订单中零件详情
    Route::get('purchase/edit/{id}','PurchaseController@edit');                          //修改采购页面
    Route::post('purchase/update','PurchaseController@store');                          //提交修改采购页面
    Route::get('purchase/delete/{no}','PurchaseController@delete');                     //删除采购订单
    Route::post('purchase/search','PurchaseController@search');                     //模糊搜索采购订单
});
//权限角色为零部件质检的才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>'ad'],function () {
    Route::get('quality','QualityController@index');                                        //质检列表
    Route::get('quality/show/{order_number}','QualityController@show');                     //质检详情
    Route::post('quality/store','QualityController@store');                                 //提交
    Route::get('quality/img/{order_number}','QualityController@img');                       //查看质检结果
    Route::post('quality/search','QualityController@search');                               //模糊搜索质检结果
});

//权限角色为仓库库管才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>'ad'],function (){
    //零部件仓库
    Route::get('spare','SparePartsController@index');                                       //零部件仓库列表
    Route::get('spare/add/{order_number}','SparePartsController@addparts');                            //零部件入库页
    Route::get('spare/shelve/info','SparePartsController@shelveinfo');                          //货架信息


});
//权限角色为admin才能访问的路由组
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:admin'],'prefix'=>
    'ad'],function (){
    Route::any('userlist','UserController@userList');                   //用户列表
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
//权限角色为库管才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>'ad'],function (){
    Route::resource('storageRoom','StorageRoomController');//库房资源控制器
    Route::post('storageRoom/fuzzySearch','StorageRoomController@fuzzySearch');//库房模糊搜素
    Route::resource('goodsShelve','GoodsShelveController');//货架资源控制器
    Route::get('goodsList/{goodsShelveId}','GoodsShelveController@goodsList');//货架内货物列表  货架id
    Route::post('goodsList/fuzzySearch','GoodsShelveController@goodsFuzzySearch');//物品模糊搜索
    Route::post('goodsShelve/fuzzySearch','GoodsShelveController@fuzzySearch');//货架模糊搜索
    Route::get('goodsShelveAdd/{id}','GoodsShelveController@goodsShelveAdd');//返回添加货架视图
});
//权限角色为生产查看才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>'ad'],function () {
    Route::get('productionOrder', 'ProductionController@orderList');//生产订单查看
    Route::get('productionHandle/{orderId}', 'ProductionController@productionHandle');//生产订单处理
    Route::post('productionFuzzySearch', 'ProductionController@fuzzySearch');//生产订单处理
    Route::post('productionPlan', 'ProductionController@productionPlan');//生产计划添加
    Route::get('productionPlanAddView/{orderId}', 'ProductionController@productionPlanAddView');//生产计划添加视图
    Route::get('productionPlanList/{orderId}', 'ProductionController@productionPlanList');//生产计划列表
    Route::get('productionPlanFinish/{orderId}', 'ProductionController@productionPlanFinish');//生产计划完成
    Route::get('productionRecordView/{orderId}', 'ProductionController@productionRecordView');//生产记录登记视图
    Route::post('productionMakeRecord', 'ProductionController@productionMakeRecord');//生产记录登记视图
});

//成品质检 角色才能访问的路由
Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>'ad'],function (){
    Route::get('qualityProductionOrder','ProductQualityController@orderList');//生产订单查看
    Route::get('qualityAddView/{orderId}','ProductQualityController@qualityAddView');//质检添加
    Route::post('qualityAdd','ProductQualityController@qualityAdd');//质检添加
});