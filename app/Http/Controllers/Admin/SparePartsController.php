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
 */
class SparePartsController extends Controller
{
    /**
     * 零部件仓库
     */
    /**
     * Notes:列表页
     * explain: 分别查询已有入库记录和未有入库记录的订单信息
     */
    public function index()
    {
        $orderEn = Purchase_quality::QualityOk(1);
        $orderUn = Purchase_quality::QualityOk(0);
        return view('lha.spareparts.list', ['orderEn' => $orderEn, 'orderUn' => $orderUn]);
    }

    /**
     * Notes:添加入库内容页
     */
    public function addparts($order_number)
    {
        $info = Purchase::where(['order_number' => $order_number])->get();
        $room = StorageRoom::roomAll();
        return view('lha.spareparts.parts-add', ['info' => $info, 'room' => $room]);
    }

    /**
     * Notes:依据库房ID查询其所有货架
     */
    public function shelveinfo(Request $request)
    {
        $id = $request->except('_token','random');
        $shelve = GoodsShelve::RoomShelveList($id);
        return jsonReturn('1', '货架列表', $shelve);
    }

    /**
     * Notes:订单入库操作
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'purchase_order_no', 'put_storage_no', 'user_id');
        $info['purchase_order_no'] = $request->input('purchase_order_no');
        //$info['storageroom_id'] = $request->input('store_room');
        $info['put_storage_no'] = $request->input('put_storage_no');
        //$info['shelve_id'] = $request->input('shelve');
        $info['user_id'] = $request->input('user_id');
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
     */
    public function record($order_no)
    {
        $record = PartPutStorageRecord::InRecord($order_no);
        return view('lha.spareparts.part-inrecord', ['data' => $record]);
    }


    /**
     * Notes:根据入库编号查看相应零部件入库数量
     */
    public function WarehousingRecord(Request $request)
    {
        $put_storage_no = $request->except('_token');
        $data = PartInfoDetailed::SpareWarehousingRecord($put_storage_no);
        return jsonReturn(1, '返回结果', $data);
    }

    /**
     * Notes:零部件列表
     */
    public function outlist()
    {
        $data = ShelfHasPart::PartRecordInfo();
        return view('lha.spareparts.part-out-list',['data'=>$data]);
    }

    /**
     * Notes:某一个零部件操作出库
     */
    public function outToInfo($part_id,$part_number)
    {
        $part_info = ShelfHasPart::where('part_id','=',$part_id)->first();
        $part = PartInfo::where('id','=',$part_id)->first();
        return view('lha.spareparts.part-out-info',['part'=>$part,'part_info'=>$part_info,'part_number'=>$part_number]);
    }
    /**
     * Notes: 单一零部件出库提交
     */
    public function outAdd(Request $request)
    {
        $data = $request->except('_token');
        $spare_num = $request->input('spare_number');
        //查询数据库中该数据,并操作减库存
        $date = ShelfHasPart::fistInfo($data['id']);
        $date->part_number = intval($date->part_number) - intval($data['part_number']);
        if ($date->part_number < 0)return withInfoErr('库存不足,请重新输入出库数量');
        if (empty($spare_num))return withInfoErr('请输入出库单号');
        $result = $date->save();
        if ($result):
            //出库成功后需将其做记录存入出库记录表中
            $out['outdate'] = time();
            $out['user_id'] =session('user.id');
            $out['out_storage_no'] = $spare_num;
            $out['shelf_has_part_id'] = $data['id'];
            $out['spare_number'] = $data['part_number'];
            DB::table('part_out_storage_record')->insert($out);
            return redirect()->to('ad/spare/out')->with(['message'=>'出库成功,并已做记录']);
        else:
            return withInfoErr('出库失败');
        endif;
    }



    /**
     * Notes: 多个零部件操作出库视图
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
          return view('lha.spareparts.part-out-many',['data'=>$res]);
      }

    /**
     * Notes:多个零部件出库操作提交
     */
      public function outMany(Request $request)
      {
          $data = $request->except('_token','spare_number');
          $spare_num = $request->input('spare_number');
          if (empty($spare_num))return withInfoErr('请输入出库单号');
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
                    //将出库记录存入记录表中
                    $data['spare_number'][$i]= $spare_num;
                    $time = time();
                    $r = DB::table('part_out_storage_record')->insert(
                        ['out_storage_no'=>$data['spare_number'][$i],
                            'shelf_has_part_id'=>$data['id'][$i],
                            'spare_number'=>$data['part_number'][$i],
                            'user_id'=>session('user.id'),
                            'outdate'=>$time
                        ]
                    );
                endif;
          endfor;
          if ($res):

                return redirect()->to('ad/spare/out')->with(['message'=>'出库成功']);
              else:
                return withInfoErr('出库失败,请重新操作');
          endif;

      }

    /**
     * Notes:查看所有出库单号列表
     * Author:sjzlai
     * Date:2018/09/21 9:45
     */
      public function outNum()
      {
          $data = DB::table('part_out_storage_record')
              ->distinct('out_storage_no')
              ->get();
         // dd($data);
          return view('lha.spareparts.out-num-list',['data'=>$data]);
      }
}
