<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    //
    public function login()
    {
        return view('lha.login.login');
    }

    public function check(Request $request)
    {
        $username = $request->all();
        if ($username['username']== '' || $username['password'] ==''):
            return back()->with('账号或密码不能为空');
        endif;
        $userinfo = DB::table('admin')
            ->where([
                ['username', '=', $username['username']],
                ['password', '=', md5($username['password'])]
            ])
            ->first();

        if (!$userinfo):
            return back()->with('账号或密码错误!');
        else:
            Session::put('admin.id', $userinfo->id);
            Session::put('admin.name', $userinfo->username);
            //dd(Session('admin'));
            return Redirect::to('ad/index');
        endif;
    }

    /*
     *
     */
    public function imgCode()
    {
        $app = app('code');//可以使用app全局函数 参数为code 生成code实例
        $app->make();    //make() 为生成验证码的方法
        //$app->fontSize = 16;// 设置字体大小
        //$app->num = 4;// 设置验证码数量
        //$app->width = 100// 设置宽度
        //$app->height = 30// 设置宽度
        //$app->font = ./1.ttf // 设置字体目录
        return $app->get(); //get() 为获取验证码的方法
    }

    public function outLogin()
    {
        Session::forget('admin');
        return Redirect::to('ad/login');
    }

}
