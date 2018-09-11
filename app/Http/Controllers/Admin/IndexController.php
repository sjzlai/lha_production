<?php

namespace App\Http\Controllers\Admin;


use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bouncer;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class IndexController extends Controller
{
    //
    public function index()
    {

        return view('lha.index.index');
    }

    public function welcome()
    {
        $serverInfo = [
            ['name' => '服务器域名','value'  =>$_SERVER['HTTP_HOST']],
            ['name' => 'php版本号', 'value'  => PHP_VERSION],
            ['name' => 'zend版本号', 'value' => zend_version() ],
            ['name' => '服务器系统', 'value' => PHP_OS],
            ['name' => '最大可上传附件限制', 'value' =>get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):'不允许上传附件'],
            ['name' => '最大内存限制', 'value' => get_cfg_var("memory_limit")?get_cfg_var("memory_limit"):'无'],
            ['name' => '服务器时间', 'value' =>date("Y-m-d G:i:s")],
            ['name' => '服务器端口', 'value' =>$_SERVER['SERVER_PORT']],
        ];
        return view('lha.index.welcome',['serverInfo'=>$serverInfo]);
    }


    public function test()
    {

//       $role = Role::create(['name'=>'admin']);//创建admin角色
//        $permission = Permission::create(['name'=>'admin auth']);//创建权限名字为admin auth
        $user = User::userinfo(2);
//        $user->givePermissionTo('admin auth');//通过用户分配权限
//        $user->assignRole('admin');
//        $user->assignRole('admin')->givePermissionTo('admin auth');
//        dd($user->hasRole('admin'));
//        $role->givePermissionTo($permission);//通过角色添加权限
//        $permission->assignRole($role);//为此权限分配角色
//        $role->revokePermissionTo($permission);//从该角色中删除权限
//        $permission->removeRole($role);//从该权限中删除角色
//        $users = User::role('admin')->get();//返回具有admin角色的用户集合
//        $users = User::permission('admin auth')->get(); //返回具有这个权限的所有用户
//        dd($users);

    }

}
