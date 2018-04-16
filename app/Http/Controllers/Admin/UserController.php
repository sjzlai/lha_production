<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /*
     * 用户列表
     */
    public function userList()
    {

        $user = DB::table('user')
            ->get();
        return view('sjzlai.user.memberlist',['user' => $user]);
    }
    /*
     * 用户添加页面展示
     */
    public function userAdd()
    {

        return view('sjzlai.user.member-add');
    }

    /*
     * 用户添加保存
     */
    public function usersave(Request $request)
    {
        $data = $request->all();

    }
}
