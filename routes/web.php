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

Route::group(['middleware'=>['web'],'namespace'=>'Admin'],function(){
    //后台登录
    Route::get('ad/login', 'LoginController@login');
    Route::get('ad/imgCode', 'LoginController@imgCode');
    Route::get('ad/loginOut','LoginController@outLogin');
//后台登陆操作
    Route::post('ad/check', 'LoginController@check');
});

Route::group(['namespace'=>'Admin','middleware'=>['web','login'],'prefix'=>
'ad'],function (){
//首页
    Route::get('index','IndexController@index');                        //首页
    Route::get('welcome','IndexController@welcome');                    //首页
    Route::get('articleList','ArticleController@articleList');          //文章列表
    Route::get('articleAdd','ArticleController@add');                   //文章添加页展示
    Route::post('articleToAdd','ArticleController@articleAdd');         //文章添加保存
    Route::any('userlist','UserController@userList');                   //用户列表
    Route::any('useradd','UserController@userAdd');                     //后台自定义添加用户
    Route::any('categoryList','CategoryController@list');                     //后台自定义添加用户
    Route::any('categoryAdd','CategoryController@add');                     //后台自定义添加用户
    Route::get('pur','PurchaseController@PurList');                        //采购列表
    Route::any('purAdd','PurchaseController@PurAdd');                        //采购申请表页
    Route::any('purtoadd','PurchaseController@PurToAdd');                        //采购申请表页
});

