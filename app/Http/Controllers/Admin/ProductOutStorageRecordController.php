<?php

namespace App\Http\Controllers\Admin;

use App\Model\ProductOutStorageRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ProductOutStorageRecordController
 * @package App\Http\Controllers\Admin
 * @name:成品出库控制器
 * @author: weikai
 * @date: 2018/7/13 15:37
 */
class ProductOutStorageRecordController extends Controller
{
    public $posrModel;
    public function __construct(ProductOutStorageRecord $productOutStorageRecord)
    {
        $this->posrModel = $productOutStorageRecord;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:订单列表
     * @author: weikai
     * @date: 2018/7/13 9:14
     */
    public function orderList()
    {
        $ordersEn = $this->posrModel->orderList(1,5);//已处理订单
        //查询订单已入库数量
        return view('lha.productWarehousing.order-list',['ordersEn'=>$ordersEn]);
    }
}
