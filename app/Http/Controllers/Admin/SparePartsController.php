<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use App\Model\PartInfo;
use App\Model\PartInfoDetailed;
use App\Model\PartPutStorageRecord;
use App\Model\Purchase;
use App\Model\Purchase_quality;
use App\Model\ShelfHasPart;
use App\Model\ShelfInfo;
use App\Model\StorageRoom;
use App\Model\Unqualified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Notes:零部件仓库管理:页面展示,入库,查询
 * Class SparePartsController
 * @package App\Http\Controllers\Admin
 * Author:sjzlai
 * Date:2018/07/13 10:08
 */
class SparePartsController extends Controller
{
    /**
     * 零部件仓库
     */
    /**
     * Notes:列表页
     * explain: 分别查询已有入库记录和未有入库记录的订单信息
     * Author:sjzlai
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Date:2018/7/3 10:51
     */
    public function index()
    {
        $orderEn = Purchase_quality::QualityOk(1);
        $orderUn = Purchase_quality::QualityOk(0);
        return view('lha.spareparts.list', ['orderEn' => $orderEn, 'orderUn' => $orderUn]);
    }

    /**
     * Notes:添加入库内容页
     * Author:sjzlai
     * @param $order_number
     * @param $room  查询返回所有库房
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Date:2018/07/03 11:09
     */
    public function addparts($order_number)
    {
        $info = Purchase::where(['order_number' => $order_number])->get();
        $room = StorageRoom::roomAll();
        return view('lha.spareparts.parts-add', ['info' => $info, 'room' => $room]);
    }

    /**
     * Notes:依据库房ID查询其所有货架
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Date:2018/07/04 9:58
     */
    public function shelveinfo(Request $request)
    {
        $id = $request->except('_token','random');
        $shelve = GoodsShelve::RoomShelveList($id);
        return jsonReturn('1', '货架列表', $shelve);
    }

    /**
     * Notes:订单入库操作
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Date:2018/07/13 10:06
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'purchase_order_no', 'put_storage_no', 'user_id');
        $info['purchase_order_no'] = $request->input('purchase_order_no');
        $info['storageroom_id'] = $request->input('store_room');
        $info['put_storage_no'] = $request->input('put_storage_no');
        $info['shelve_id'] = $request->input('shelve');
        $info['user_id'] = $request->input('user_id');
       // dd($data);
        $result = PartPutStorageRecord::create($info);      //将存库信息存入记录表
        if ($result):
            for ($i = 1; $i <= count($data); $i++):
                for ($j = 0; $j < count($data[$i]['part_number']); $j++):
                    //将零部件详细信息:数量,批号,型号存入表part_info_detailed
                    $a['part_id'] = $i;
                    $a['part_number'] = $data[$i]['part_number'][$j];
                    $a['batch_number'] = $data[$i]['batch_number'][$j];
                    $a['model'] = $data[$i]['model'][$j];
                    $a['status'] = 1;
                    $a['purchase_order_no'] = $info['purchase_order_no'];
                    $a['put_storage_no'] = $info['put_storage_no'];
                    if (!$a['put_storage_no']) {
                        return withInfoErr('请填写入库编号');
                        exit();
                    }
                    if ($a['part_number']):
                        $re = PartInfoDetailed::create($a);//将零部件信息填入表part_info_detailed表中
                    else:
                        continue;
                    endif;
                    if ($re):
                        //将入库信息填入shelf_has_part表中:查询某货架中是否有此配件,有则增加数量,无则增加货架及配件信息
                        $shelf_info['shelf_id'] = $data[$i]['shelve'][$j];
                        $shelf_info['storageroom_id'] = $data[$i]['store_room'][$j];
                        $shelf_info['part_id'] = $i;
                        $shelf_info['part_number'] = $data[$i]['part_number'][$j];
                        $part_number = DB::table('shelf_has_part')->where('shelf_id', $shelf_info['shelf_id'])->where('part_id', $shelf_info['part_id'])->pluck('part_number')->toArray();
                        $addRes = null;
                        $numRes = null;
                        if ($part_number):
                            $numRes = ShelfHasPart::where('shelf_id', $shelf_info['shelf_id'])->where('part_id', $shelf_info['part_id'])->increment('part_number', $shelf_info['part_number']);
                        else:
                            $addRes = ShelfHasPart::create($shelf_info);
                        endif;
                    endif;
                endfor;
            endfor;
            if ($numRes || $addRes):       //更改订单入库状态
                $res = Purchase::UpdateStatus($info['purchase_order_no']);
            endif;
            if ($res):
                return redirect('ad/spare');
            else:
                return back()->withInfoErr('入库失败');
            endif;
        endif;
    }

    /**
     * Notes:查看单个订单入库记录
     * Author:sjzlai
     * @param $order_no
     * Date:2018/07/18 10:18
     */
    public function record($order_no)
    {
        $record = PartPutStorageRecord::InRecord($order_no);
        return view('lha.spareparts.part-inrecord', ['data' => $record]);
    }


    /**
     * Notes:根据入库编号查看相应零部件入库数量
     * Author:sjzlai
     * Date:2018/08/01 15:02
     */
    public function WarehousingRecord(Request $request)
    {
        $put_storage_no = $request->except('_token');
        $data = PartInfoDetailed::SpareWarehousingRecord($put_storage_no);
        return jsonReturn(1, '返回结果', $data);
    }

    /**
     * Notes:零部件列表
     * Author:sjzlai
     * Date:2018/08/07 10:24
     */
    public function outlist()
    {
        $data = ShelfHasPart::PartRecordInfo();
        return view('lha.spareparts.part-out-list',['data'=>$data]);
    }

    /**
     * Notes:某一个零部件操作出库
     * Author:sjzlai
     * Date:2018/08/07 14:33
     */
    public function outToInfo($part_id,$part_number)
    {
        $part_info = ShelfHasPart::where('part_id','=',$part_id)->first();
        $part = PartInfo::where('id','=',$part_id)->first();
        return view('lha.spareparts.part-out-info',['part'=>$part,'part_info'=>$part_info,'part_number'=>$part_number]);
    }
    /**
     * Notes: 零部件出库提交
     * Author:sjzlai
     * Date:2018/08/07 16:49
     */
    public function outAdd(Request $request)
    {
        $data = $request->except('_token');
        //dd($data);
        //查询数据库中该数据,并操作减库存
        $date = ShelfHasPart::fistInfo($data['id']);
        $date->part_number = intval($date->part_number) - intval($data['part_number']);
        $result = $date->save();
       // $result = ShelfHasPart::where('part_id','=',$data['part_id'])->update($date);
        if ($result):
            return redirect('ad/spare/out');
        else:
            return withInfoErr('出库失败');
        endif;
    }

    /**
     * Notes: 多个零部件操作出库视图
     * Author:sjzlai
     * Date:2018/08/07 14:46
     */
      public function outToAll($data)
      {
          $da =explode(',',$data);
          foreach ($da as $value):
          $res[] =ShelfHasPart::PartRecordMany($value);
          endforeach;
          foreach($res as $key=>$re):
              foreach ($re as $k=>$r):
                  $res[$key]=$re[$k];
              endforeach;
          endforeach;
          //dd($res);
          return view('lha.spareparts.part-out-many',['data'=>$res]);
      }

    /**
     * Notes:多个零部件出库操作提交
     * Author:sjzlai
     * @param Request $request
     * Date:2018/08/21 11:31
     */
      public function outMany(Request $request)
      {
          $data = $request->except('_token');
          //查询验证出库数量  开始
              for ($i=0;$i<count($data['id']);$i++):
                  $info[] = ShelfHasPart::PartRecordMany($data['id'][$i]);
              endfor;
          foreach($info as $key=>$re):
              foreach ($re as $k=>$r):
                  $info[$key]=$re[$k];
              endforeach;
          endforeach;
          for ($i=0;$i<count($data['id']);$i++):
                if ($data['id'][$i] == $info[$i]['id'] && $data['part_number'][$i]>$info[$i]['part_number']):
                    return withInfoErr($info[$i]['part_name'].'数量大于库存数量:'.$info[$i]['part_number'].',请重新填写');
                elseif ($data['id'][$i] == $info[$i]['id'] && $data['part_number'][$i]<=$info[$i]['part_number']):
                    $number[] = $info[$i]['part_number'] - $data['part_number'][$i];
                    $res = ShelfHasPart::where('id','=',$data['id'][$i])->update(['part_number'=>$number[$i]]);
                endif;
          endfor;
          if ($res):
                return redirect()->to('ad/spare/out')->with(['message'=>'出库成功']);
              else:
                return withInfoErr('出库失败,请重新操作');
          endif;

      }
}
