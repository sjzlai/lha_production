<?php

namespace App\Http\Controllers\Admin;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

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
        $userinfo = DB::table('user')
            ->where([
                ['user_name', '=', $username['username']],
                ['password', '=', md5($username['password'])]
            ])
            ->first();

        if (!$userinfo):
            return back()->with('账号或密码错误!');
        else:
            Session::put('user.id', $userinfo->id);
            Session::put('user.name', $userinfo->name);
            Session::put('user.user_name', $userinfo->user_name);
            Auth::login(User::userinfo($userinfo->id));
            return Redirect::to('ad/index');
        endif;
    }

    /**
     *  Notes:验证码
     */
    public function imgCode()
    {
        $app = app('code');//可以使用app全局函数 参数为code 生成code实例
        $app->make();    //make() 为生成验证码的方法
        return $app->get(); //get() 为获取验证码的方法
    }

    public function outLogin()
    {
        Session::forget('admin');
        return Redirect::to('/');
    }

}
