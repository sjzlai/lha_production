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
//后台登陆页

Route::group(['middleware'=>['web'],'namespace'=>'Admin'],function(){
    Route::get('ad/login', 'LoginController@login');
//后台登陆操作
    Route::post('ad/check', 'LoginController@check');
});

Route::group(['namespace'=>'Admin','middleware'=>['web'],'prefix'=>
'ad'],function (){
//首页
    Route::get('index','IndexController@index');
    Route::get('welcome','IndexController@welcome');
    Route::get('articleList','ArticleController@list');
    Route::get('articleAdd','ArticleController@add');
    Route::post('articleToAdd','ArticleController@articleAdd');
    Route::any('userlist','UserController@userList');
    Route::any('useradd','UserController@userAdd');
    Route::any('userlist','UserController@userList');
    Route::any('useradd','UserController@userAdd');
});

