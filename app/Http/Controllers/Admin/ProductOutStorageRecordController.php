<?php

namespace App\Http\Controllers\Admin;

use App\Model\OrdereNoLinkFactoryNo;
use App\Model\ProductOutStorageRecord;
use App\Model\ShelfHasPart;
use App\Model\ShelfInfo;
use App\Model\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

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
        $ordersEn = $this->posrModel->orderList(5);//已处理订单
//        dd($ordersEn);
        if ($ordersEn->isEmpty())      return view('lha.productWarehousing.black');
        //查询订单
        return view('lha.productQutStorage.order-list',['ordersEn'=>$ordersEn]);
    }

    /**
     * @name:出库视图
     * @author: weikai
     * @date: 2018/7/13 9:15
     */
    public function productOutStorageView($orderId)
    {
//        $factoryNo =  OrdereNoLinkFactoryNo::where('order_no',$orderId)->pluck('factory_no')->first();//工厂订单号
        $storageRooms = StorageRoom::productLinkShelf($orderId);//查询orderId成品所在的货架
        return view('lha.productQutStorage.productOutStorage',[
            'orderId'=>$orderId,
            'storageRooms'=>$storageRooms,
        ]);
    }

    /**
     * @name:出库操作
     * @author: weikai
     * @date: 2018/7/17 10:27
     */
    public function productOutStorage(Request $request)
    {
        $datas = $request->except('_token');
//        if (count($datas)<7) return withInfoErr('请填写完整');
        //出库记录表写入
        $outStorageData['order_no'] =$datas['production_order_no'];
        $outStorageData['number'] =$datas['number'];
        $outStorageData['shelf_id'] =$datas['shelf_id'];
        $storage = ShelfInfo::find($datas['shelf_id']);
        $outStorageData['storageroom_id'] =$storage->storageroom_id;
        $oprRes = ProductOutStorageRecord::create($outStorageData);
        //货架表数量减少
        $model = new ShelfHasPart();
       $shpData = $model
            ->where('shelf_id',$datas['shelf_id'])
            ->where('part_name',1)
            ->first();
//       dd($shpData);
       $shpData->part_number = intval($shpData->part_number) - intval($datas['number']);
       $shpRes = $shpData->save();
       if (!$shpRes || !$oprRes) return withInfoErr('入库失败');
       return redirect('ad/ProductOutStorageRecordOrderList');
    }

    /**
     * @name:已出库数量查询
     * @author: weikai
     * @date: 2018/7/13 14:25
     */
    public function outStorageNumber($orderId)
    {
        $num = $this->posrModel->where('order_no',$orderId)->count('number');//查询已出库总数
        return jsonReturn('1','已出库总数',$num);
    }

    /**
     * @name:出库记录列表
     * @author: weikai
     * @date: 2018/7/17 12:34
     */
    public function productOutStorageRecord($orderId)
    {
        $recordlists = ProductOutStorageRecord::recordList($orderId);
        if ($recordlists->isEmpty()) return withInfoErr('没有数据');
        return view('lha.productQutStorage.record-list',['recordlists'=>$recordlists]);
    }

}
