<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ProductionPlan extends Model
{
    protected $table = 'production_plan';
    protected $guarded = [];
    public $timestamps = true;

    public static function productionPlanList($orderId,$page=5)
    {
        return self::from( 'production_plan as pp')
        ->where('order_no',$orderId)
            ->leftJoin('user as u','u.id','=','pp.user_id')
            ->select('pp.*','u.id','u.user_name','u.phone','u.name')
            ->orderBy('pp.created_at','desc')
            ->paginate($page);
    }
}
