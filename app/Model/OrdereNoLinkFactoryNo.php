<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
//生产订单号与工厂订单号关联表
class OrdereNoLinkFactoryNo extends Model
{
    protected $table = 'order_no_link_factory_no';
    protected $guarded = [];
    public $timestamps = true;
}
