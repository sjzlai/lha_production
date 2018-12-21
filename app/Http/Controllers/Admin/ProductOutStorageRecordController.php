<?php

namespace App\Http\Controllers\Admin;

use App\Model\OrdereNoLinkFactoryNo;
use App\Model\ProductOutStorageRecord;
use App\Model\PurchasingOrder;
use App\Model\ShelfHasPart;
use App\Model\ShelfInfo;
use App\Model\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * @name:成品出库控制器
 */
class ProductOutStorageRecordController extends Controller
{
    public $posrModel;
    public function __construct(ProductOutStorageRecord $productOutStorageRecord)
    {
        $this->posrModel = $productOutStorageRecord;
    }

    /**
     * @name:订单列表
     */
    public function orderList()
    {
        $ordersEn = $this->posrModel->orderList(1,5);//已处理订单

//        dd($ordersEn);
        if ($ordersEn->isEmpty())      return view('lha.productWarehousing.black');
        //查询订单
//        dd($ordersEn);
        return view('lha.productQutStorage.order-list',['ordersEn'=>$ordersEn]);
    }

    /**
     * @name:出库视图
     */
    public function productOutStorageView($orderId)
    {
        //将订单号存入session
        \Session::put('order.order_number',$orderId);
        //$orderId = '08482714';
        //查询所有库房判断此订单是否已全部完成,未完成时,不可做出库操作
        $sum_number=PurchasingOrder::where('order_no',$orderId)->select(['goods_number'])->get(); //订单数量
        $order_sum = ShelfHasPart::where('order_no',$orderId)->sum('part_number');            //仓库数量
        $orderout_sum = ProductOutStorageRecord::where('order_no',$orderId)->sum('number');  //出库记录
//        var_dump(intval($sum_number[0]->goods_number));
//        var_dump(intval($order_sum));
//        var_dump(intval($orderout_sum));
//        dd(intval($sum_number[0]->goods_number - (intval($order_sum) + intval($orderout_sum))));

        if (intval($sum_number[0]->goods_number - intval($order_sum) - intval($orderout_sum)) != 0 )
        {
            return redirect('ad/ProductOutStorageRecordOrderList')->with(['message'=>'订单未完成,完成后才可做出库']);
        }elseif (intval($orderout_sum) >= $sum_number[0]->goods_number ){
            return redirect('ad/ProductOutStorageRecordOrderList')->with(['message'=>'订单已完成出库!!!']);
        }

        $factoryNo =  OrdereNoLinkFactoryNo::where('order_no',$orderId)->pluck('factory_no')->first();//工厂订单号
//        dd($factoryNo);
        $storageRooms = StorageRoom::productLinkShelf($orderId);//查询所有成品所在的全部货架
        //出库的数量查询
        foreach ($sum_number as $good_number){
            $su_nmuber=$good_number['goods_number'];
        }
        $number=ProductOutStorageRecord::where('order_no',$orderId)->sum('number');
        $number_weichu=intval($su_nmuber)-intval($number);
        $consignees = DB::table('harvest_info')->get();//收货信息

        return view('lha.productQutStorage.productOutStorage',[
            'orderId'=>$orderId,
            'factoryNO'=>$factoryNo,
            'storageRooms'=>$storageRooms,
            'consignees'=>$consignees,
            'numbers'=>$number_weichu
        ]);
    }

    /**
     * @name:出库操作
     */
    public function productOutStorage(Request $request)
    {

        $datas = $request->except('_token');
//        if (count($datas)<7) return withInfoErr('请填写完整');
        //出库记录表写入
        $outStorageData['order_no'] =$datas['production_order_no'];
        if($datas['number']>0){
        $outStorageData['number'] =$datas['number'];
        }else{
            return redirect("ad/productOutStorageView/" .$datas['production_order_no'])->with(['message'=>'数量小于0不能再提交']);
        }

        $outStorageData['logistics_company'] =$datas['logistics_company'];
        $orderNum=session()->get('order.order_number');
        $arr['logistics_company']=$datas['logistics_company'];
        $arr['order_status']=1;
        $arr['order_status']=1;
        $orderInfoBool = DB::connection('mysql_fu')->table('order_info')->where('order_num',$orderNum)->update($arr);
        //dd($orderInfoBool);

        $outStorageData['shelf_id'] =$datas['shelf_id'];
        $storage = ShelfInfo::find($datas['shelf_id']);
        $outStorageData['storageroom_id'] =$storage->storageroom_id;
//        dd($outStorageData);
        $oprRes = ProductOutStorageRecord::create($outStorageData);

        //货架表数量减少
        $model = new ShelfHasPart();
       $shpData = $model
            ->where('shelf_id',$datas['shelf_id'])
            ->where('part_name',1)
            ->first();
//       dd($shpData);
       $shpData->part_number = intval($shpData->part_number) - intval($datas['number']);
        if ($shpData->part_number < 0 )return redirect("ad/ProductOutStorageRecordOrderList" )->with(['message'=>'数量小于0不能再操作出库']);
       $shpRes = $shpData->save();
       if (!$shpRes || !$oprRes) return withInfoErr('出库失败');
       return redirect('ad/ProductOutStorageRecordOrderList');
    }

    /**
     * @name:已出库数量查询
     */
    public function outStorageNumber($orderId)
    {
        $num = $this->posrModel->where('order_no',$orderId)->count('number');//查询已出库总数
        return jsonReturn('1','已出库总数',$num);
    }

    /**
     * @name:出库记录列表
     */
    public function productOutStorageRecord($orderId)
    {
        $recordlists = ProductOutStorageRecord::recordList($orderId);
        //dd($recordlists);
        if ($recordlists->isEmpty()) return withInfoErr('没有数据');
        return view('lha.productQutStorage.record-list',['recordlists'=>$recordlists]);
    }

}
