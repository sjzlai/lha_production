<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    //
    protected $table = 'part_purchase'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单

    /**
     * Notes: 采购申请列表页查询
     * Author:sjzlai
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * Date:2018/7/2 10:02
     */
    public static function DateList()
    {
        return self::leftjoin('user', 'part_purchase.user_id', '=', 'user.id')
            ->where('part_purchase.status', '=', '0')
            ->paginate('5');
    }

    public static function searchList($keyword,$page=5)
    {
        return self::leftjoin('user', 'part_purchase.user_id', '=', 'user.id')
        ->where('order_number','like',"%$keyword%")->paginate($page);
    }
    /**
     * Notes:查看订单中采购零部件详情
     * Author:sjzlai
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Date:2018/7/2 10:04
     */
    public static function PartInfo($id)
    {
        return self::join('part_purchase_lists', 'part_purchase.order_number', '=', 'part_purchase_lists.purchase_order_no')
            ->join('part_info','part_purchase_lists.part_id','=','part_info.id')
            ->where(['part_purchase.order_number'=>$id,'part_purchase_lists.status'=>0])
            ->get();
    }

    /**
     * Notes: 订单修改详情页
     * Author:sjzlai
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     * Date:2018/7/2 10:11
     */
    public static function EditOrder($id)
    {
        return self::from('part_purchase as pp')
            ->join('part_purchase_lists as ppl', 'pp.order_number', '=', 'ppl.purchase_order_no')
            ->join('part_info as pi','ppl.part_id','=','pi.id')
            ->where(['pp.order_number'=> $id,'ppl.status'=>0])
            ->get();
    }
}
