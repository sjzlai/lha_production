<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchasingOrder
 * @package App\Model
 * @name:生产订单模型
 * @author: weikai
 * @date: 2018/6/29 9:50
 */
class PurchasingOrder extends Model
{
    public $timestamps = true;
    protected $table = 'purchasing_order';
    protected $guarded = [];

    /**
     * @param int $status 默认 1 已处理订单  2未处理订单
     * @param int $page
     * @name:生产订单查看
     * @author: weikai
     * @date: 2018/6/29 9:57
     */
    public static function orderList( $status=1,$page = 5)
    {
        return self::from('purchasing_order as po')
            ->leftJoin('harvest_info as hi','po.harvest_info_id','hi.id')
            ->select('po.*','hi.address','hi.consignee_name','hi.phone')
            ->where('po.status',$status)
            ->orderBy('po.created_at','desc')
            ->paginate($page);

    }
    public static function orderFuzzySearch($key,$keyword,$page=5)
    {

        return self::where($key,'like',"%$keyword%")->paginate($page);
    }
}
