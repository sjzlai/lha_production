<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Unqualified
 * Notes: 质检不合格表Model
 * @package App\Model
 */
class Unqualified extends Model
{
    //
    protected $table = 'part_info_unqualified'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单

}
