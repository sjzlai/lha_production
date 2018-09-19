<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductOutStorageRecord
 * @package App\Model
 * @name:成品出库模型
 * @author: 
 * @date: 2018/9/6 15:40
 */
class ProductOutStorageRecord extends Model
{
    protected $table = 'product_out_storage_record';
    public $timestamps = true;
    protected $guarded = [];

    public static function orderList($status=1,$page=5)
    {

//        return self::from('shelf_has_part as shp')
//            ->leftJoin('shelf_info as si','shp.shelf_id','=','si.id')
//            ->leftJoin('storageroom_info as s','shp.storageroom_id','=','s.id')
//            ->select('shp.*','si.shelf_name','s.store_name')
//            ->where('shp.part_name','=',1)
//            ->where('shp.part_number','>','0')
//            ->whereNotNull('shp.part_number')
//            ->orderBy('shp.created_at','desc')
//            ->paginate($page);
        return self::from('purchasing_order as po')
            ->leftJoin('harvest_info as hi','po.harvest_info_id','hi.id')
            ->select('po.*','hi.address','hi.consignee_name','hi.phone')
            ->where('po.status',$status)
            ->orderBy('po.created_at','desc')
            ->paginate($page);
    }

    /**
     * @name:出库记录列表
     * @author: 
     * @date: 2018/9/6 15:00
     */
    public static function recordList($orderId,$page=5)
    {
        return self::from('product_out_storage_record as posr')
            ->where('posr.order_no',$orderId)
            ->select('posr.*','sri.store_name','si.shelf_name')
            ->leftJoin('storageroom_info as sri','sri.id','posr.storageroom_id')
            ->leftJoin('shelf_info as si','si.id','posr.shelf_id')
            ->orderBy('posr.created_at','desc')
            ->paginate($page);
    }
}
