<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @name: 查询所有角色
     * @author: weikai
     * @date: 2018/6/22 10:10
     */
    public static function roleAll($page=5)
    {
        return self::orderBy('created_at','desc')->paginate($page);
    }

    /**
     * @name:角色名字是否重复
     * @author: weikai
     * @date: 2018/6/22 11:08
     */
    public static function roleNameIsRepeat($roleName)
    {
        return self::where('name',$roleName)->first();
    }

    public static function roleFuzzySearch($key,$keyword,$page=5)
    {
       return Roles::where($key,'like',"%$keyword%")->paginate($page);
    }
}