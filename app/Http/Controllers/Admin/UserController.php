<?php

namespace App\Http\Controllers\Admin;

use App\Model\Roles;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

/**
 * @name:用户管理
 */
class UserController extends Controller
{
    /**
     * @name:用户列表
     */
    public function index()
    {
        $users = User::userAll();
        return view('lha.user.user-list',['users'=>$users]);
    }

    /**
     * @name:模糊搜索
     */
    public function fuzzySearch(Request $request)
    {
        $keyword = $request->Input('keyword');//获取搜索值
        $users = User::userFuzzySearch('user_name',$keyword,5);//如果有搜索值就模糊查询分页
        if (!$keyword) $users =  User::userAll();
        return view('lha.user.user-list',['users'=>$users]);
    }

    /**
     * @name:新增用户视图
     */
    public function create()
    {
        return view('lha.user.user-add');
    }

    /**
     * @name:新增用户储存
     */
    public function store(Request $request)
    {
        $userData = $request->except('_token');
        if (count($userData)<4) return withInfoErr('请填写完整');
        $userData['password'] = md5($userData['password']);
        $res = User::create($userData);
        if (!$res) return withInfoErr('添加失败');
        return redirect('/ad/userlist');
    }

    /**
     * @param  int  $id
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
        $user = User::find($id);
        return view('lha.user.user-edit',['user'=>$user]);
    }

    /**
     * @name:执行修改
     */
    public function update(Request $request, $id)
    {
        $data = $request->except('_token');
        $data['password'] = md5($data['password']);
        $user = User::find($id);
        $res = $user->update($data);
        if (!$res) return jsonReturn('0','修改失败');
        return jsonReturn('1','修改成功');
    }

    /**
     * @name:删除用户
     */
    public function destroy($id)
    {
        if (!$id) return jsonReturn('0','没有用户id');
        $res  = User::destroy($id);
        if(!$res) return jsonReturn('0','删除失败');
        return jsonReturn('1','删除成功');
    }

    /**
     * @name:用户角色列表
     */
    public function userRole($id)
    {
        $user  = User::userinfo($id);
        $roles = $user->getRoleNames()->toArray();//获取所有已定以的角色集合
        return view('lha.user.userrole-list',['roles'=>$roles,'userid'=>$user->id]);
    }

    /**
     * @name:为用户分配角色视图
     */
    public function addRole($id)
    {
        return view('lha.user.userrole-add',['userid'=>$id]);
    }

    /**
     * @name:为用户分配角色
     */
    public function allotRole(Request $request)
    {
        $inputs = $request->except('_token');
        $user = User::find($inputs['userid']);
        if(Roles::roleNameIsRepeat($inputs['roleName'])) return withInfoErr('角色名已存在请在“给此用户分配已有角色”添加');
        if ($user->hasRole($inputs['roleName'])) return withInfoErr('用户已存在此角色');
        $roleRes = Role::create(['name' => $inputs['roleName']]);//创建角色
        if (!$roleRes) return withInfoErr('添加失败');
        $res = $user->assignRole($inputs['roleName']);//为用户分配角色
        if (!$res) return withInfoErr('添加失败');
        return redirect('ad/userlist');
    }

    /**
     * @name:撤销此角色
     */
    public function removeRole($id,$roleName)
    {
        $user = User::find($id);
        $user->removeRole($roleName);
        return withInfoMsg('删除成功');
    }

    /**
     * @name:获取所有已定义的角色
     */
    public function roleListInAddView($id)
    {
        $user  = User::userinfo($id);
        $role = $user->getRoleNames()->toArray();//获取所有已定义的角色集合
        $roles =Roles::whereNotIn('name',$role)->orderBy('created_at','desc')->paginate($page=5);
        return view('lha.user.role-list-in-add',['userid'=>$id,'roles'=>$roles]);
    }

    /**
     * @name:从角色列表中为用户添加角色
     */
    public function roleListInAdd($roleId,$id)
    {
        $role = Roles::find($roleId);
        $user = User::find($id);
        if($user->hasRole($role->name)) return withInfoErr('用户已有此角色');
        $user->assignRole($role->name);
        return withInfoMsg('角色分配成功');
    }
}
