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

    /**
     * @param $orderId
     * @name:生产计划列表
     * @author: weikai
     * @date: 2018/7/12 10:18
     */
    public static function recordList($orderId,$page=5)
    {
        return self::from('production_record as pr')
            ->where('pr.order_no',$orderId)
            ->select('pr.*','u.name','u.phone')
            ->leftJoin('user as u','u.id','=','pr.user_id')
            ->orderBy('pr.created_at','desc')
            ->paginate($page);
    }
}
