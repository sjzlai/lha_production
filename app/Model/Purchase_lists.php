<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Purchase_lists extends Model
{
    //
    protected $table = 'part_purchase_lists'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单
}
