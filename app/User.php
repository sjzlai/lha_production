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
    protected $hidden = [];
    protected $guard_name = 'web'; // 使用任何你想要的守卫

    public static function userinfo($id)
    {
        return self::find($id);
    }
}
