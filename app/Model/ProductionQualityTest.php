<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProductionQualityTest
 * @package App\Model
 * @name:成品质检表模型
 * @author: 
 * @date: 2018/7/9 11:30
 */
class ProductionQualityTest extends Model
{
    protected $table = 'production_quality_test'; //表名
    protected $primaryKey = 'id'; //主键
    public $timestamps = 'true'; //自动维护时间
    protected $guarded = []; //批量添加字段黑名单


    public static function orderList($order_no,$page=10)
    {
        return self::from('production_quality_test as pqt')
            ->join('purchasing_order as po' ,'po.order_no','pqt.production_order_no')
            ->where('pqt.production_order_no',$order_no)
            ->paginate($page);
    }
}
