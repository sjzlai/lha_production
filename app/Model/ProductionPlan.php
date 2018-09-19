<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    protected $table = 'production_plan';
    protected $guarded = [];
    public $timestamps = true;

    /**
     * @param $orderId
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     * @name:生产计划列表
     * @author: weikai
     * @date: 2018/7/11 11:46
     */
    public static function productionPlanList($orderId,$page=5)
    {
        return self::from( 'production_plan as pp')
        ->where('order_no',$orderId)
            ->leftJoin('user as u','u.id','=','pp.user_id')
            ->select('pp.*','u.id','u.user_name','u.phone','u.name')
            ->orderBy('pp.created_at','desc')
            ->paginate($page);
    }

    /**
     * @param $orderId
     * @return Model|null|static
     * @name:生产计划详情
     * @author: weikai
     * @date: 2018/7/11 12:00
     */
    public static function productionPlanInfo($orderId)
    {
        $data['product'] = self::from('production_plan as pp')
            ->select('olf.factory_no','pi.product_name','pi.product_code','pi.product_batch_number','pi.product_spec','u.name','u.phone','pp.*')
            ->where('pp.order_no',$orderId)
            ->leftJoin('user as u','u.id','=','pp.user_id')
            ->leftJoin('order_no_link_factory_no as olf','olf.order_no','=','pp.order_no')
//            ->leftJoin('part_info as pai','pai.id','=','ppl.part_id')
            ->leftJoin('product_info as pi','pi.order_no','=','pp.order_no')
            ->first()->toArray();
        //查询零部件信息
        $data['part'] = self::from('part_production_lists as ppl')
            ->where('ppl.order_no',$orderId)
            ->select('ppl.part_id','ppl.part_number','pai.part_name','pai.manufacturer','pid.batch_number','pid.model')
            ->leftJoin('part_info as pai','pai.id','=','ppl.part_id')
            ->leftJoin('part_info_detailed as pid','ppl.part_id','=','pid.part_id')
            ->get()->toArray();
        return $data;

    }
}
