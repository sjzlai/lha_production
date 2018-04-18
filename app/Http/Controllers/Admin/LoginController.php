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
        return view('sjzlai.login.login');
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
            return Redirect::to('ad/index');
        endif;
    }

    public function outLogin()
    {
        Session::forget('admin');
        return Redirect::to('ad/login');
    }

}
