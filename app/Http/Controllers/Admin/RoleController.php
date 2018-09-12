<?php

namespace App\Http\Controllers\Admin;

use App\Model\Roles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

/**
 * @name:角色管理资源控制器
 */
class RoleController extends Controller
{
    /**
     * @name:角色列表
     */
    public function index()
    {
       $roles =  Roles::roleAll();
       return view('lha.auth.role-list',['roles'=>$roles]);

    }

    /**
     * @name:模糊搜索
     */
    public function fuzzySearch(Request $request)
    {
        $keyword = $request->Input('keyword');//获取搜索值
        $roles = Roles::roleFuzzySearch('name',$keyword,5);//如果有搜索值就模糊查询分页
        if (!$keyword) $roles =  Roles::roleAll();
        return view('lha.auth.role-list',['roles'=>$roles]);
    }

    /**
     * @name:返回新增视图
     */
    public function create(Request $request)
    {
        return view('lha.auth.role-add');

    }

    /**
     * @name:新增角色储存
     */
    public function store(Request $request)
    {
        $roleName = $request->input('roleName');//获取要添加的角色名
        if (Roles::roleNameIsRepeat($roleName)) return withInfoErr('角色名字已存在');
        if (empty($roleName)) return withInfoErr('角色名字不能为空');
        $role = Role::create(['name'=>$roleName]);
        if(!$role) return withInfoErr('创建角色失败');
        return redirect('/ad/role');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * @name:返回编辑视图
     */
    public function edit($id)
    {
        $role = Roles::find($id);
        return view('lha.auth.role-edit',['role'=>$role]);
    }

    /**
     * @name:执行修改操作
     */
    public function update(Request $request, $id)
    {
        if (!$request->input('name')) return jsonReturn('0','没有角色名称');
        if (!$id) return jsonReturn('0','没有角色id');
        $role = Roles::find($id);
        $role->name = $request->input('name');
        $res = $role->save();
        if (!$res) return jsonReturn('0','修改失败');
        return jsonReturn('1','修改成功');
    }

    /**
     * @name:删除角色
     */
    public function destroy($id)
    {
        if(!Roles::destroy($id)){
            return jsonReturn('0','删除失败',null);
        } else{
            return jsonReturn('1','删除成功',null);
        }

    }
}
