<?php

namespace App\Http\Controllers\Admin;

use App\Model\PartInfo;
use App\Model\PartProductionLists;
use App\Model\ProductionPlan;
use App\Model\PurchasingOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//生产管理控制器
class ProductionController extends Controller
{
    public $model ;
    public function __construct(PurchasingOrder $purchasingOrder)
    {
        $this->model = $purchasingOrder;
    }

    //生产订单查看
    public function orderList()
    {
        $ordersUn = $this->model->orderList(2);//未处理订单
        $ordersEn = $this->model->orderList(1,1);//已处理订单
        return view('lha.production.production-order-list',['ordersUn'=>$ordersUn,'ordersEn'=>$ordersEn]);
    }

    /**
     * @param $orderId
     * @return \Illuminate\Http\RedirectResponse
     * @name:生产订单处理
     * @author: weikai
     * @date: 2018/6/29 10:49
     */
    public function productionHandle($orderId)
    {
        $order = PurchasingOrder::find($orderId);
        $order->status = 1;
        $res = $order->save();
        if (!$res) return withInfoErr('处理失败');
        return withInfoMsg('已处理');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:模糊搜索订单
     * @author: weikai
     * @date: 2018/6/29 11:05
     */
    public function fuzzySearch(Request $request)
    {
        //如果搜索值为空 重定向到双订单页面
        if(empty($request->input('keyword')))
          return  redirect('/ad/productionOrder');
        $key = 'order_no';
        $keyword = $request->input('keyword');
        $orderAll  = PurchasingOrder::orderFuzzySearch($key,$keyword);
        return view('lha.production.production-list',['orders'=>$orderAll]);
    }

    /**
     * @name:生产计划添加视图
     * @author: weikai
     * @date: 2018/6/29 14:48
     */
    public function productionPlanAddView($orderId)
    {
        return view('lha.production.production-add',['orderId'=>$orderId]);
    }

    /**
     * @param Request $request
     * @name:生产计划添加
     * @author: weikai
     * @date: 2018/6/29 15:15
     */
    public function productionPlan(Request $request)
    {
        $data = $request->except('_token');
        $data['user_id'] = session('user.id');
        $time = strtotime($data['production_plan_date']);
        $data['production_plan_date'] = date('Y-m-d H:i:s',$time);
        $res = ProductionPlan::create($data);
        if (!$res) return withInfoErr('添加失败');
        return withInfoMsg('添加成功');
    }

    /**
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:生产计划列表
     * @author: weikai
     * @date: 2018/6/29 16:26
     */
    public function productionPlanList($orderId)
    {
        $productionPlans = ProductionPlan::productionPlanList($orderId);
        return view('lha.production.productionPlan-list',['productionPlans'=>$productionPlans]);
    }

    /**
     * @name:生产计划完成
     * @author: weikai
     * @date: 2018/6/29 16:27
     */
    public function productionPlanFinish($orderId)
    {
        $productionPlan = ProductionPlan::where('order_no',$orderId)->first();
        if (empty($productionPlan)) return withInfoErr('没有此订单');
        $productionPlan->is_finish = 1;
        $res = $productionPlan->save();
        if(!$res) return withInfoErr('执行失败');
        return withInfoMsg('执行成功');
    }

    /**
     * @name:生产记录登记视图
     * @author: weikai
     * @date: 2018/7/10 9:03
     */
    public function productionRecordView($orderId)
    {
        $partInfosCZ = PartInfo::fuzzySearch('吹嘴');
        $partInfosDG = PartInfo::fuzzySearch('笛管');
        $partInfosSP = PartInfo::fuzzySearch('哨片');
        $partInfosDP = PartInfo::fuzzySearch('垫片');
        $partInfosD = PartInfo::fuzzySearch('袋');
        $partInfosPJ = PartInfo::fuzzySearch('皮筋');
        $partInfos = PartInfo::all();
        return view('lha.production.production-record-add',
            [
                'orderId'=>$orderId,
                'partInfosCZ'=>$partInfosCZ,
                'partInfosDG'=>$partInfosDG,
                'partInfosSP'=>$partInfosSP,
                'partInfosDP'=>$partInfosDP,
                'partInfosD'=>$partInfosD,
                'partInfosPJ'=>$partInfosPJ,
                'partInfos'=>$partInfos
            ]
        );
    }

    /**
     * @name:生产记录登记
     * @author: weikai
     * @date: 2018/7/10 9:35
     */
    public function productionMakeRecord(Request $request)
    {
        $data['order_no'] = $request->input('order_no');
        $data['number'] = $request->input('number');
        $data['part_id'] = $request->input('part_id');
        $data['part_number'] = $request->input('part_number');
        //零部件清单表写入
        for ($i = 0; $i < count($data['part_id']); $i++) {
           $model =  new PartProductionLists();
           $model->order_no = $data['order_no'];
//           $model->number = $data['number'];
           $model->part_id = $data['part_id'][$i];
           $model->part_number = $data['part_number'][$i];
           $model->save();
        }
    }


}
