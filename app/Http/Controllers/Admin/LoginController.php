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
        $userinfo = DB::table('admin')
            ->where([
                ['username','=',$username['username']],
                ['password','=',md5($username['password'])]
            ])
                ->first();
        if($userinfo):
            Session::put('admin.id',$userinfo->id);
            Session::put('admin.name',$userinfo->username);
            return Redirect::to('ad/index');
            endif;
    }

}
