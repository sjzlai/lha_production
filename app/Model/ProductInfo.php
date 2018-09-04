<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductInfo
 * @package App\Model
 * @name:成品信息表
 * @author: weikai
 * @date: 2018/7/11 9:33\
 */
class ProductInfo extends Model
{
    protected $table = 'product_info';
    protected $guarded = [];
    public $timestamps = true;
}
