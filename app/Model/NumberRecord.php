<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class NumberRecord
 * @package App\Model
 * @name:数字递增记录表
 * @author: weikai
 * @date: 2018/7/12 11:51
 */
class NumberRecord extends Model
{
    protected $table = 'number_record';
    protected $guarded = [];
    public $timestamps = true;
}
