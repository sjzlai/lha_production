<?php

namespace App\Http\Controllers\Admin;

use App\Roles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

/**
 * Class RoleController
 * @package App\Http\Controllers\Admin
 * @name:角色管理资源控制器
 * @author: weikai
 * @date: 2018/6/22 10:06
 */
class RoleController extends Controller
{
    /**
     * @name:角色列表
     * @author: weikai
     * @date: 2018/6/22 10:06
     */
    public function index()
    {
       $roles =  Roles::roleAll();
       return view('lha.auth.role-list',['roles'=>$roles]);

    }

    /**
     * @param Request $request
     * @name:返回新增视图
     * @author: weikai
     * @date: 2018/6/22 11:29
     */
    public function create(Request $request)
    {
        return view('lha.auth.role-add');

    }

    /**
     * @name:新增角色储存
     * @author: weikai
     * @date: 2018/6/22 10:58
     */
    public function store(Request $request)
    {
        $roleName = $request->input('roleName');//获取要添加的角色名
        if (Roles::roleNameIsRepeat($roleName)) return withInfoErr('角色名字已存在');
        if (empty($roleName)) return withInfoErr('角色名字不能为空');
        $role = Role::create(['name'=>$roleName]);
        if(!$role) return withInfoErr('创建角色失败');
        return withInfoMsg('创建角色成功');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @name:删除角色
     * @author: weikai
     * @date: 2018/6/22 12:52
     */
    public function destroy($id)
    {
        if(!Roles::deleted($id)) return withInfoErr('删除失败');
        return withInfoMsg('删除成功');
    }
}
