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
}
