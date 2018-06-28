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
    Route::get('pur', 'PurchaseController@PurList');                        //采购列表
    Route::any('purAdd', 'PurchaseController@PurAdd');                        //采购申请表页
    Route::any('purtoadd', 'PurchaseController@PurToAdd');                        //采购申请表页
    Route::any('info', 'PurchaseController@info');                         //查看订单中零件详情
    Route::get('edit/{id}','PurchaseController@edit');                          //修改采购页面
    Route::post('update','PurchaseController@store');                          //提交修改采购页面
    Route::get('delete/{no}','PurchaseController@delete');                     //删除采购订单
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


