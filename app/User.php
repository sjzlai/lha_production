<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    protected $table = 'user';
    protected $guarded = [];
    protected $guard_name = 'web'; // 使用任何你想要的守卫

    public static function userinfo($id)
    {
        return self::find($id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * @name: 查询所有用户
     * @author: weikai
     * @date: 2018/6/22 10:10
     */
    public static function userAll($page=5)
    {
        return self::orderBy('created_at','desc')->paginate($page);
    }

    /**
     * @param $key
     * @param $keyword
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @name:模糊搜索
     * @author: weikai
     * @date: 2018/6/25 10:45
     */
    public static function userFuzzySearch($key,$keyword,$page=5)
    {
        return User::where($key,'like',"%$keyword%")->paginate($page);
    }

}
