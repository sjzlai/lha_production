<?php

namespace App\Http\Controllers\Admin;

use App\Model\OrdereNoLinkFactoryNo;
use App\Model\ProductPutStorageRecord;
use App\Model\PurchasingOrder;
use App\Model\ShelfHasPart;
use App\Model\ShelfInfo;
use App\Model\StorageRoom;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class ProductWarehousingController
 * @package App\Http\Controllers\Admin
 * @name:产品入库控制器
 * @author: weikai
 * @date: 2018/7/13 8:51
 */
class ProductWarehousingController extends Controller
{
    public $ppsrModel;
    public function __construct(ProductPutStorageRecord $productPutStorageRecord)
    {
        $this->ppsrModel = $productPutStorageRecord;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:订单列表
     * @author: weikai
     * @date: 2018/7/13 9:14
     */
    public function orderList()
    {
        $ordersEn = $this->ppsrModel->orderList(1,5);//已处理订单
        //查询订单已入库数量
        if ($ordersEn->isEmpty()):
            return view('lha.productWarehousing.black');
        else:
            return view('lha.productWarehousing.order-list',['ordersEn'=>$ordersEn]);
        endif;
    }

    /**
     * @name:入库视图
     * @author: weikai
     * @date: 2018/7/13 9:15
     */
    public function productWarehousingView($orderId)
    {
        $factoryNo =  OrdereNoLinkFactoryNo::where('order_no',$orderId)->pluck('factory_no')->first();//工厂订单号
        $storageRooms = StorageRoom::all();//所有库房
        return view('lha.productWarehousing.productWarehousing',['orderId'=>$orderId,'factoryNO'=>$factoryNo,'storageRooms'=>$storageRooms]);
    }

    /**
     * @param $storageRoomId
     * @name: 通过库房id 查询所有货架
     * @author: weikai
     * @date: 2018/7/13 10:25
     */
    public function shelfInfo($storageRoomId)
    {
        if (!$storageRoomId) return jsonReturn('0','没有id');
        $shelfInfo = ShelfInfo::shelfInfo($storageRoomId);//货架信息
        return jsonReturn('1','货架信息',$shelfInfo);
    }

    /**
     * @name:入库操作
     * @author: weikai
     * @date: 2018/7/13 12:40
     */
    public function productWarehousing(Request $request)
    {
       $data = $request->except('_token');
        $a['part_name'] = 1;
        $a['part_number'] = $data['number'];
        $a['shelf_id'] = $data['shelf'];
        $a['storageroom_id'] = $data['storageRoom'];
        $b['order_no'] = $data['production_order_no'];
        $b['number'] = $data['number'];
        $b['storageroom_id'] = $data['storageRoom'];
        $b['shelf_id'] = $data['shelf'];
        $b['user_id'] = session('user.id');
        $b['remark'] = $data['remark'];
        if (count($data)<5) return withInfoErr('请填写完整');
        $num = ProductPutStorageRecord::where('order_no','=',$b['order_no'])->sum('number');
        $number =PurchasingOrder::select('purchasing_order.goods_number')->where('order_no','=',$b['order_no'])->first();
        //dd($num);
        if ($num >= $number->goods_number){ return withInfoErr('入库数量大于生产数量,无法再次入库!');}
        $res = ProductPutStorageRecord::create($b);//入库记录表写入
        //入库前判断已入库数量和生产成品数量对比
        //dd($num);
        //将库房存入货架关联表中
        //$ress[] =ShelfHasPart::insert($b['storageroom_id']);
        //查询库房中是否已存在商品 已存在增加数量，否则新增
        $part_number = DB::table('shelf_has_part')->where('shelf_id',$data['shelf'])->where('part_name','1')->pluck('part_number')->toArray();
        $addRes = null;
        $numRes = null;
        if ($part_number){
            $numRes = DB::table('shelf_has_part')->where('shelf_id',$data['shelf'])->where('part_name','1')->increment('part_number',$data['number']);
        }else{

            $addRes = ShelfHasPart::create($a);
        }
        if (!$res) return withInfoErr('入库失败');
        if($numRes || $addRes ) return redirect('/ad/productWarehousingOrderList');
    }

    /**
     * @name:已入库数量查询
     * @author: weikai
     * @date: 2018/7/13 14:25
     */
    public function warehousingNumber($orderId)
    {
        $num = $this->ppsrModel->where('order_no',$orderId)->count('number');//查询已入库总数
       return jsonReturn('1','已入库总数',$num);
    }

    /**
     * @name:入库记录查看
     * @author: weikai
     * @date: 2018/7/13 14:53
     */
    public function productWarehousingRecord($orderId)
    {
        $records = $this->ppsrModel->recordList($orderId);
        if ($records->isEmpty()) return withInfoErr('没有入库记录');
        return view('lha.productWarehousing.record-list',['records'=>$records]);
    }
}
