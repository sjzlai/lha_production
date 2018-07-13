<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductPutStorageRecord extends Model
{
    //
    protected $table = 'product_put_storage_record';
    public $timestamps = true;
    protected $guarded = [];

    /**
     * @param int $status 默认 1 已处理订单  2未处理订单
     * @param int $page
     * @name:订单查看
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

    /**
     * @name:入库记录列表
     * @author: weikai
     * @date: 2018/7/13 15:00
     */
    public static function recordList($orderId,$page=5)
    {
        return self::from('product_put_storage_record as ppsr')
            ->where('ppsr.order_no',$orderId)
            ->select('ppsr.*','sri.store_name','si.shelf_name','u.name','u.phone')
            ->leftJoin('storageroom_info as sri','sri.id','ppsr.storageroom_id')
            ->leftJoin('shelf_info as si','si.id','ppsr.shelf_id')
            ->leftJoin('user as u','u.id','ppsr.user_id')
            ->orderBy('ppsr.created_at','desc')
            ->paginate($page);
    }
}
