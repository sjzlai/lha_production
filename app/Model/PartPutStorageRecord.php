<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class PartPutStorageRecord extends Model
{
    //
    protected $table = "part_put_storage_record";
    protected $guarded = [];
    public $timestamps = true;

    /**
     * Notes:查询单个订单零部件入库记录
     * Author:sjzlai
     * @param $order_no
     * Date:2018/07/18 10:23
     */
    public static function InRecord($order_no,$page=10)
    {

        return self::from('part_put_storage_record as ppsr')
                ->where(['ppsr.purchase_order_no'=>$order_no])
                ->paginate($page);
    }
}
