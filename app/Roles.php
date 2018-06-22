<?php

namespace App;

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
    public static function roleAll()
    {
        return self::orderBy('created_at','desc')->paginate(5);
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
}
