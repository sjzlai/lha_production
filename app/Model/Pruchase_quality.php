<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Pruchase_quality extends Model
{
    //
    protected $table = 'purchase_quality_test'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单

    public static function QualityList($page =5)
    {
        return self::from('part_purchase as part')
        ->select('part.*','user.id','user.name','test.purchase_order_no','test.status')
        ->leftjoin('user', 'part.user_id', '=', 'user.id')
        ->leftjoin('purchase_quality_test as test','part.order_number','=','test.purchase_order_no')
        ->where(['part.status' => '0', 'part.warehousing' => '0'])
        ->paginate($page);
    }

    public static function QualitySearch($keyword,$page=5)
    {
        return self::from('part_purchase as part')
            ->select('part.*','user.id','user.name','test.purchase_order_no','test.status')
            ->leftjoin('user', 'part.user_id', '=', 'user.id')
            ->leftjoin('purchase_quality_test as test','part.order_number','=','test.purchase_order_no')
            ->where(['part.status' => '0', 'part.warehousing' => '0','part.order_number'=>$keyword])
            ->paginate($page);
    }
}
