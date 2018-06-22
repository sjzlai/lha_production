<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Notes:
     * Author:sjzlai
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userList()
    {

        $user = DB::table('user')
            ->get();
        return view('lha.user.memberlist',['user' => $user]);
    }
    /*
     * 用户添加页面展示
     */
    public function userAdd()
    {
        return view('lha.user.member-add');
    }

    /*
     * 用户添加保存
     */
    public function usersave(Request $request)
    {
        $data = $request->all();

    }
}
