<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionRecord
 * @package App\Model
 * @name:生产记录表
 * @author: weikai
 * @date: 2018/7/11 9:15
 */
class ProductionRecord extends Model
{
    protected $table = 'production_record';
    public $timestamps = true;
    protected $guarded = [];
}
