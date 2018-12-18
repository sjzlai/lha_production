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
 * @name:产品入库控制器
 */
class ProductWarehousingController extends Controller
{
    public $ppsrModel;
    public function __construct(ProductPutStorageRecord $productPutStorageRecord)
    {
        $this->ppsrModel = $productPutStorageRecord;
    }

    /**
     * @name:订单列表
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
     */
    public function productWarehousingView($orderId)
    {
        $factoryNo =  OrdereNoLinkFactoryNo::where('order_no',$orderId)->pluck('factory_no')->first();//工厂订单号
        $storageRooms = StorageRoom::all();//所有库房
        return view('lha.productWarehousing.productWarehousing',['orderId'=>$orderId,'factoryNO'=>$factoryNo,'storageRooms'=>$storageRooms]);
    }

    /**
     * @name: 通过库房id 查询所有货架
     */
    public function shelfInfo($storageRoomId)
    {
        if (!$storageRoomId) return jsonReturn('0','没有id');
        $shelfInfo = ShelfInfo::shelfInfo($storageRoomId);//货架信息
        return jsonReturn('1','货架信息',$shelfInfo);
    }

    /**
     * @name:入库操作
     */
    public function productWarehousing(Request $request)
    {
       $data = $request->except('_token');
        $a['part_name'] = 1;
        $a['part_id'] = 0;
        $a['part_number'] = $data['number'];
        $a['shelf_id'] = $data['shelf'];
        $a['storageroom_id'] = $data['storageRoom'];
        $a['order_no']  =$data['production_order_no'];
        $b['order_no'] = $data['production_order_no'];
        $b['number'] = $data['number'];
        $b['storageroom_id'] = $data['storageRoom'];
        $b['shelf_id'] = $data['shelf'];
        $b['user_id'] = session('user.id');
        $b['remark'] = $data['remark'];
        if (count($data)<5) return withInfoErr('请填写完整');
        if ($b['storageroom_id'] == '' || $b['shelf_id'] == '') return withInfoErr('请正确选择库房与货架');
        $num = ProductPutStorageRecord::where('order_no','=',$b['order_no'])->sum('number');
        $number =PurchasingOrder::select('purchasing_order.goods_number')->where('order_no','=',$b['order_no'])->first();
        if ($num > $number->goods_number || $b['number']+$num > $number->goods_number){ return withInfoErr('入库数量大于生产数量,无法再次入库!');}
        $res = ProductPutStorageRecord::create($b);//入库记录表写入
        //入库前判断已入库数量和生产成品数量对比
        //将库房存入货架关联表中
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
     */
    public function warehousingNumber($orderId)
    {
        $num = $this->ppsrModel->where('order_no',$orderId)->count('number');//查询已入库总数
       return jsonReturn('1','已入库总数',$num);
    }

    /**
     * @name:入库记录查看
     */
    public function productWarehousingRecord($orderId)
    {
        $records = $this->ppsrModel->recordList($orderId);
        if ($records->isEmpty()) return withInfoErr('没有入库记录');
        return view('lha.productWarehousing.record-list',['records'=>$records]);
    }

    /**
     * Notes:入库记录修改视图
     * Author:sjzlai
     * @param $id
     * Date:2018/09/27 15:45
     */
    public function productWarehousingRecordEdit($id)
    {
        $data = ProductPutStorageRecord::
            select('product_put_storage_record.*','product_put_storage_record.id as ppsr_id','shelf.*','shelf.id as shelf_id','room.*','room.id as room_id')
        ->join('storageroom_info as room','room.id','=','product_put_storage_record.storageroom_id')
        ->join('shelf_info as shelf','shelf.id','=','product_put_storage_record.shelf_id')
        ->where('product_put_storage_record.id','=',$id)->get();
        //dd($data);
        $storageRooms = StorageRoom::all();//所有库房
        $shelf = ShelfInfo::where('storageroom_id','=',$data[0]->storageroom_id)->get();
       // dd($shelf);
        $factoryNo =  OrdereNoLinkFactoryNo::where('order_no',$id)->pluck('factory_no')->first();//工厂订单号
        return view('lha.productWarehousing.record-edit',['data'=>$data,'storageRooms'=>$storageRooms,'shelf'=>$shelf]);
    }

    /**
     * Notes:入库记录修改提交
     * Author:sjzlai
     * @param Request $request
     * Date:2018/09/28 16:28
     */
    public function productWarehousingRecordStore(Request $request)
    {
        $data = $request->except('_token');
        $id = $request->input('id');
        $old = ProductPutStorageRecord::where('id','=',$id)->get();
        $dataNew = [
            'order_no'=>$data['production_order_no'],
            'number' =>$data['number'],
            'storageroom_id'=>$data['storageRoom'],
            'shelf_id'=>$data['shelf'],
            'remark' =>$data['remark']
        ];
        $num = $dataNew['number']-$old[0]->number;
        //对比入库数量与订单数量
        $nums = ProductPutStorageRecord::where('order_no','=',$dataNew['order_no'])->sum('number');
        $number =PurchasingOrder::select('purchasing_order.goods_number')->where('order_no','=',$dataNew['order_no'])->first();
//        dd($nums - $old[0]->number + $dataNew['number']);
        if ($nums - $old[0]->number + $dataNew['number'] >$number->goods_number){ return withInfoErr('入库数量大于生产数量,无法再次入库!');}
        if ($old[0]->storageroom_id == $data['storageRoom']  && $old[0]->shelf_id ==$data['shelf']){ //如果库房和货架未改变,则只改变库存数量
            //更新库房货架数量
            if ($num >0) {
                $res = ShelfHasPart::where(['storageroom_id' => $dataNew['storageroom_id'], 'shelf_id' => $dataNew['shelf_id']])->increment('part_number', $num);
            }else{
                $res = ShelfHasPart::where(['storageroom_id' => $dataNew['storageroom_id'], 'shelf_id' => $dataNew['shelf_id']])->decrement('part_number', $num);
            }
           //更新入库记录
            $r = ProductPutStorageRecord::where('id','=',$data['id'])->update($dataNew);
        }else{
            //减少原始库房货架数量
            $res = ShelfHasPart::where(['storageroom_id'=>$old[0]->storageroom_id,'shelf_id'=>$old[0]->shelf_id])->decrement('part_number',$old[0]->number);
            $new =[
                'part_name' =>1,
                'part_number'=>$dataNew['number'],
                'shelf_id'  =>$dataNew['shelf_id'],
                'storageroom_id'=>$dataNew['storageroom_id'],
            ];
            $res =ShelfHasPart::insert($new);
            //更新入库记录
            $r = ProductPutStorageRecord::where('id','=',$data['id'])->update($dataNew);
        }
        if ($res){
            return redirect()->to('/ad/productWarehousingRecord/'.$dataNew['order_no'])->with('error','修改完成');
        }else{
            return redirect()->to('/ad/productWarehousingRecord/'.$id)->with('error','修改失败');
        }
    }
}
