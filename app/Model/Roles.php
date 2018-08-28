<?php

namespace App\Model;

use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Roles extends Model
{
    protected $table = 'roles';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @name: 查询所有角色
     * @author: weikai
     * @date: 2018/6/22 10:10
     */
    public static function roleAll($page=15)
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
