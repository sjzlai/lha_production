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
'ad'],function (){

    Route::get('index','IndexController@index');                        //首页
    Route::get('welcome','IndexController@welcome');                    //首页
    Route::get('test','IndexController@test');                          //测试


});
//权限角色为admin才能访问的路由组
Route::group(['namespace'=>'Admin','middleware'=>['web','login','role:admin'],'prefix'=>
    'ad'],function (){
         Route::any('userlist','UserController@userList');                   //用户列表
         Route::any('useradd','UserController@userAdd');                     //后台自定义添加用户
         Route::resource('role','RoleController');                     //权限管理-角色管理
    });

