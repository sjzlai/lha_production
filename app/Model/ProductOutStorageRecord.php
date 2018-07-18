<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductOutStorageRecord
 * @package App\Model
 * @name:成品出库模型
 * @author: weikai
 * @date: 2018/7/13 15:40
 */
class ProductOutStorageRecord extends Model
{
    protected $table = 'product_out_storage_record';
    public $timestamps = true;
    protected $guarded = [];

    public static function orderList($status=1,$page=5)
    {
        return self::from('purchasing_order as po')
            ->leftJoin('harvest_info as hi','po.harvest_info_id','hi.id')
            ->select('po.*','hi.address','hi.consignee_name','hi.phone')
            ->where('po.status',$status)
            ->orderBy('po.created_at','desc')
            ->paginate($page);
    }

    /**
     * @name:出库记录列表
     * @author: weikai
     * @date: 2018/7/13 15:00
     */
    public static function recordList($orderId,$page=5)
    {
        return self::from('product_out_storage_record as posr')
            ->where('posr.order_no',$orderId)
            ->select('posr.*','sri.store_name','si.shelf_name','u.name','u.phone','hi.address as hi_address','hi.consignee_name','hi.phone as hi_phone')
            ->leftJoin('storageroom_info as sri','sri.id','posr.storageroom_id')
            ->leftJoin('shelf_info as si','si.id','posr.shelf_id')
            ->leftJoin('user as u','u.id','posr.user_id')
            ->leftJoin('harvest_info as hi','hi.id','posr.consignee_id')
            ->orderBy('posr.created_at','desc')
            ->paginate($page);
    }
}
