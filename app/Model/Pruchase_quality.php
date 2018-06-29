<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pruchase_quality extends Model
{
    //
    protected $table = 'purchase_quality_test'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单
}
