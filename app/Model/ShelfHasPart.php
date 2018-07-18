<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShelfHasPart
 * @package App\Model
 * @name:货架产品关联
 * @author: weikai
 * @date: 2018/7/17 11:28
 */
class ShelfHasPart extends Model
{
    protected $table = 'shelf_has_part';
    protected $guarded = [];
    public $timestamps = true;
}
