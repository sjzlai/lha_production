<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Purchase_quality extends Model
{
    //
    protected $table = 'purchase_quality_test'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单

    /**
     * Notes:质检列表查询
     * Author:sjzlai
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * Date:2018/7/3 10:04
     */
    public static function QualityList($page =5)
    {
        return self::from('part_purchase as part')
        ->select('part.*','user.id','user.name','test.purchase_order_no','test.status')
        ->leftjoin('user', 'part.user_id', '=', 'user.id')
        ->leftjoin('purchase_quality_test as test','part.order_number','=','test.purchase_order_no')
        ->where(['part.status' => '0', 'part.warehousing' => '0'])
        ->orderBy('part.created_at','desc')
        ->paginate($page);
    }


    /**
     * Notes:质检列表页搜索
     * Author:sjzlai
     * @param $keyword
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * Date:2018/7/3 10:04
     */
    public static function QualitySearch($keyword,$page=5)
    {
        return self::from('part_purchase as part')
            ->select('part.*','user.id','user.name','test.purchase_order_no','test.status')
            ->leftjoin('user', 'part.user_id', '=', 'user.id')
            ->leftjoin('purchase_quality_test as test','part.order_number','=','test.purchase_order_no')
            ->where(['part.status' => '0', 'part.warehousing' => '0'])
            ->where('part.order_number','like',"%$keyword%")
            ->paginate($page);
    }

    /**
     * Notes:查询所有合格产品
     * Author:sjzlai
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * Date:2018/07/06 10:04
     */
    public static function QualityOk($status,$page=5)
    {
        return self::from('part_purchase as part')
            ->select('part.*','user.id','user.name','test.purchase_order_no','test.status')
            ->join('user', 'part.user_id', '=', 'user.id')
            ->join('purchase_quality_test as test','part.order_number','=','test.purchase_order_no')
           // ->where(['part.status' => '0','test.status'=>1])
            ->where(['part.warehousing'=>$status])
            ->orderBy('part.created_at','desc')
            ->paginate($page);
    }
}
