<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use App\Model\PartInfo;
use App\Model\PartInfoDetailed;
use App\Model\PartOutStorageRecord;
use App\Model\PartProductionLists;
use App\Model\PartPutStorageRecord;
use App\Model\Purchase;
use App\Model\Purchase_lists;
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
        //$orderEn = Purchase_quality::QualityOk(1);
        $orderUn = Purchase_quality::QualityOk(0);
      /*  $purchase_order_no = PartInfoDetailed::where('purchase_order_no','=','1000010')
            ->select('part_info_detailed.*')
            ->groupBy('part_id')
            ->selectRaw('sum(part_number) as partnumbercount')
            ->get();
        dd($purchase_order_no);*/
        return view('lha.spareparts.list', ['orderUn' => $orderUn]);
    }

    public function indexs()
    {
        $orderEn = Purchase_quality::QualityOk(1);
       // $orderUn = Purchase_quality::QualityOk(0);
        /*  $purchase_order_no = PartInfoDetailed::where('purchase_order_no','=','1000010')
              ->select('part_info_detailed.*')
              ->groupBy('part_id')
              ->selectRaw('sum(part_number) as partnumbercount')
              ->get();
          dd($purchase_order_no);*/
        return view('lha.spareparts.lists', ['orderEn' => $orderEn]);
    }

    /**
     * Notes:添加入库内容页
     */
    public function addparts($order_number)
    {

        //入库前先判断各个零部件的数量是否对应
        $purchase_order_no = PartInfoDetailed::where('purchase_order_no','=',$order_number)
            ->select('part_info_detailed.*')
            ->groupBy('part_id')
            ->selectRaw('sum(part_number) as partnumbercount')
            ->get()->toArray();
        $oldpurchase = Purchase_lists::where('purchase_order_no','=',$order_number)->get()->toArray();
        //dd($purchase_order_no);
/*        if (!empty($purchase_order_no)){
            //判断已入库数量跟未入库数量的核对

            for ($i = 0; $i<count($purchase_order_no);$i++) {
                if (intval($purchase_order_no[$i]['partnumbercount']) < $oldpurchase[$i]['part_number'] ) {
                    $info = Purchase::where(['order_number' => $order_number])->get();
                    $room = StorageRoom::roomAll();
                    return view('lha.spareparts.parts-add', ['info' => $info, 'room' => $room]);
                } else {
                    //return withInfoErr('此订单已完成入库!请操作其他订单!');
                }

            }
        }*/
        $info = Purchase::where(['order_number' => $order_number])->get();
        $room = StorageRoom::roomAll();
        return view('lha.spareparts.parts-add', ['info' => $info, 'room' => $room]);

    }

    /**
     * Notes:依据库房ID查询其所有货架
     */
    public function shelveinfo(Request $request)
    {
        $id = $request->except('_token', 'random');
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
        $info['put_storage_no'] = $request->input('put_storage_no');
        //添加判断看是否已有入库编号
        $put_storage_no =PartInfoDetailed::where('put_storage_no','=', $info['put_storage_no'])->pluck('put_storage_no')->toArray();
        //dd($put_storage_no);
        if (!empty($put_storage_no)){
            return withInfoErr('入库编号已存在,请重新填写');
            exit();
        }
        $info['user_id'] = $request->input('user_id');

       //dd($oldpurchase);
        if ($data):
            $sum = '';
            //判断该订单已入库数量+现入库数量与 采购订单数量的对比
            //入库前先判断各个零部件的数量是否对应
            $purchase_order_no = PartInfoDetailed::where('purchase_order_no', '=', $info['purchase_order_no'])
                ->select('part_info_detailed.*')
                ->groupBy('part_id')
                ->selectRaw('sum(part_number) as partnumbercount')
                ->get()->toArray();
            $oldpurchase = Purchase_lists::where('purchase_order_no', '=', $info['purchase_order_no'])->get()->toArray();
//            echo '<pre>';
        //dd(count($data[1]['part_number']));
            for ($i = 1; $i <= count($data); $i++){
                for ($j = 0; $j < count($data[$i]['part_number']); $j++) {
                    //将零部件详细信息:数量,批号,型号存入表part_info_detailed
                    $a['part_id'] = $i;
                    $a['part_number'] = $data[$i]['part_number'][$j];
                    $a['batch_number'] = $data[$i]['batch_number'][$j];
                    $a['model'] = $data[$i]['model'][$j];
                    $a['status'] = 1;
                    $a['purchase_order_no'] = $info['purchase_order_no'];
                    $a['put_storage_no'] = $info['put_storage_no'];
                    if (count($data[$i]['part_number'][$j] <= 1)) {
                        $sum = $data[$i]['part_number'][$j];
                    } else {
                        $sum += $data[$i]['part_number'][$j];
                    }
                    if ($a['part_number'] != 0 ){
                        //已有入库记录的
                        if (isset($purchase_order_no) && isset($oldpurchase)){
                            for ($c=0;$c < count($purchase_order_no);$c++){
                                //dd($oldpurchase[$c]['part_number']- $purchase_order_no[$c]['partnumbercount'] - $sum );
                                if (($oldpurchase[$c]['part_number']- $purchase_order_no[$c]['partnumbercount'] - $sum ) < 0  &&  $oldpurchase[$c]['part_id'] == $purchase_order_no[$c]['part_id'] ) {
                                      return withInfoErr('请核对各个剩余零部件数量,再进行入库');
                                }
                            }
                        }
                        //无入库记录的
                        for ($s=0;$s<count($oldpurchase);$s++){
                            if ($oldpurchase[$s]['part_number']-$sum < 0  &&  $oldpurchase[$c]['part_id'] == $a['part_id']){
                                return withInfoErr('请核对各个剩余零部件数量,再进行入库');
                            }
                        }

                        if (!$a['put_storage_no']) {
                            return withInfoErr('请填写入库编号');
                            exit();
                        }
                        if ($a['part_number'] == '' && $a['batch_number'] == '' && $a['model'] == '') //
                        {
                            return withInfoErr('请将所有零部件信息填写完整,已无需入库的请将其他信息全部填写: 0');
                            exit();
                        }
                        if ($a['part_number'])
                           // dd($a);
                        if (empty($purchase_order_no)){
                            $re = PartInfoDetailed::create($a);//将零部件信息填入表part_info_detailed表中
                        }else{
                            $re = PartInfoDetailed::insert($a);
                        }
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
                    }
                }
            }




            $result = PartPutStorageRecord::create($info);      //将存库信息存入记录表
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
//        var_dump($put_storage_no);
//        dd($data);
        return jsonReturn(1, '返回结果', $data);
    }

    /**
     * Notes:零部件列表
     */
    public function outlist()
    {
        $data = ShelfHasPart::PartRecordInfo();
        return view('lha.spareparts.part-out-list', ['data' => $data]);
    }

    /**
     * Notes:某一个零部件操作出库
     */
    public function outToInfo($part_id, $part_number)
    {
        $part_info = ShelfHasPart::where('part_id', '=', $part_id)->first();
        $part = PartInfo::where('id', '=', $part_id)->first();
        return view('lha.spareparts.part-out-info', ['part' => $part, 'part_info' => $part_info, 'part_number' => $part_number]);
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
        if ($date->part_number < 0) return withInfoErr('库存不足,请重新输入出库数量');
        if (empty($spare_num)) return withInfoErr('请输入出库单号');
        $result = $date->save();
        if ($result):
            //出库成功后需将其做记录存入出库记录表中
            $out['outdate'] = time();
            $out['user_id'] = session('user.id');
            $out['out_storage_no'] = $spare_num;
            $out['shelf_has_part_id'] = $data['id'];
            $out['spare_number'] = $data['part_number'];
            PartOutStorageRecord::create($out);
            return redirect()->to('ad/spare/out')->with(['message' => '出库成功,并已做记录']);
        else:
            return withInfoErr('出库失败');
        endif;
    }


    /**
     * Notes: 多个零部件操作出库视图
     */
    public function outToAll($data)
    {
        $da = explode(',', $data);
        foreach ($da as $value):
            $res[] = ShelfHasPart::PartRecordMany($value);
        endforeach;
        foreach ($res as $key => $re):
            foreach ($re as $k => $r):
                $res[$key] = $re[$k];
            endforeach;
        endforeach;
        return view('lha.spareparts.part-out-many', ['data' => $res]);
    }

    /**
     * Notes:多个零部件出库操作提交
     */
    public function outMany(Request $request)
    {
        $data = $request->except('_token', 'spare_number');
        $spare_num = $request->input('spare_number');
        if (empty($spare_num)) return withInfoErr('请输入出库单号');
        //查询验证出库数量  开始
        for ($i = 0; $i < count($data['id']); $i++):
            $info[] = ShelfHasPart::PartRecordMany($data['id'][$i]);
        endfor;
        foreach ($info as $key => $re):
            foreach ($re as $k => $r):
                $info[$key] = $re[$k];
            endforeach;
        endforeach;
        for ($i = 0; $i < count($data['id']); $i++):
            if ($data['id'][$i] == $info[$i]['id'] && $data['part_number'][$i] > $info[$i]['part_number']):
                return withInfoErr($info[$i]['part_name'] . '数量大于库存数量:' . $info[$i]['part_number'] . ',请重新填写');
            elseif ($data['id'][$i] == $info[$i]['id'] && $data['part_number'][$i] <= $info[$i]['part_number']):
                $number[] = $info[$i]['part_number'] - $data['part_number'][$i];
                $res = ShelfHasPart::where('id', '=', $data['id'][$i])->update(['part_number' => $number[$i]]);
                //将出库记录存入记录表中
                $data['spare_number'][$i] = $spare_num;
                $time = time();
                $r = DB::table('part_out_storage_record')->insert(
                    ['out_storage_no' => $data['spare_number'][$i],
                        'shelf_has_part_id' => $data['id'][$i],
                        'spare_number' => $data['part_number'][$i],
                        'user_id' => session('user.id'),
                        'outdate' => $time
                    ]
                );
            endif;
        endfor;
        if ($res):

            return redirect()->to('ad/spare/out')->with(['message' => '出库成功']);
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
            ->groupBy('out_storage_no') ->get();
       // dd($data);
        return view('lha.spareparts.out-num-list', ['data' => $data]);
    }

    /**
     * Notes:出库单号详细内容
     * Author:sjzlai
     * Date:2018/09/25 10:19
     */
    public function outDetailed($OutStorageNo)
    {
        $data = PartOutStorageRecord::
        select('shp.*', 'pi.*', 'si.*', 'shelf_info.*', 'part_out_storage_record.updated_at as postr_updated_at', 'part_out_storage_record.*')
            ->join('shelf_has_part as shp', 'shp.id', '=', 'part_out_storage_record.shelf_has_part_id')
            ->join('part_info as pi', 'pi.id', '=', 'shp.part_id')
            ->join('storageroom_info as si', 'si.id', '=', 'shp.storageroom_id')
            ->join('shelf_info', 'shelf_info.id', '=', 'shp.shelf_id')
            ->where('out_storage_no', '=', $OutStorageNo)->get();
        return view('lha.spareparts.out-detailed', ['data' => $data]);
    }

    /**
     * Notes: 出库单修改
     * Author:sjzlai
     * @param $OutStorageNo
     * Date:2018/09/26 9:44
     */
    public function outEdit($OutStorageNo)
    {
        $data = PartOutStorageRecord::
        select('shp.*', 'pi.*', 'si.*', 'shelf_info.*', 'shp.id as shp_id', 'part_out_storage_record.updated_at as postr_updated_at', 'part_out_storage_record.*')
            ->join('shelf_has_part as shp', 'shp.id', '=', 'part_out_storage_record.shelf_has_part_id')
            ->join('part_info as pi', 'pi.id', '=', 'shp.part_id')
            ->join('storageroom_info as si', 'si.id', '=', 'shp.storageroom_id')
            ->join('shelf_info', 'shelf_info.id', '=', 'shp.shelf_id')
            ->where('out_storage_no', '=', $OutStorageNo)->get();
        return view('lha.spareparts.out-edit', ['data' => $data, 'outstorageno' => $OutStorageNo]);
    }

    /**
     * Notes:出库订单修改出库数量
     * Author:sjzlai
     * @param Request $request
     * Date:2018/09/26 16:16
     */
    public function outStore(Request $request)
    {
        $data = $request->except('_token', 'shp_id', 'outstorageno');
        $outstorageno = $request->input('outstorageno');
        //将已出库数量回增到原库存
        $old = PartOutStorageRecord::where('out_storage_no', '=', $outstorageno)->get();
        foreach ($old as $value) {
            ShelfHasPart::where('id', '=', $value->shelf_has_part_id)->increment('part_number', $value->spare_number);
        }
        //查询验证出库数量  开始
        for ($i = 0; $i < count($data['id']); $i++):
            $info[] = ShelfHasPart::PartRecordMany($data['id'][$i]);
        endfor;
        foreach ($info as $key => $re):
            foreach ($re as $k => $r):
                $info[$key] = $re[$k];
            endforeach;
        endforeach;

        //重新出库操作
        for ($i = 0; $i < count($data['id']); $i++):
            if ($data['id'][$i] == $info[$i]['id'] && $data['part_number'][$i] > $info[$i]['part_number']):
                return withInfoErr($info[$i]['part_name'] . '数量大于库存数量:' . $info[$i]['part_number'] . ',请重新填写');
            elseif ($data['id'][$i] == $info[$i]['id'] && $data['part_number'][$i] <= $info[$i]['part_number']):
                $number[] = $info[$i]['part_number'] - $data['part_number'][$i];
                $res = ShelfHasPart::where('id', '=', $data['id'][$i])->update(['part_number' => $number[$i]]);
                //将出库记录存入记录表中

                $data['spare_number'][$i] = $outstorageno;
                $time = time();
                $r = DB::table('part_out_storage_record')
                    ->where(['out_storage_no' => $outstorageno, 'shelf_has_part_id' => $info[$i]['id']])
                    ->update(
                        [
                            'spare_number' => $data['part_number'][$i],
                            'outdate' => $time
                        ]
                    );
            endif;
        endfor;
        if ($r) {
            return redirect()->to('ad/spare/outnum')->with('error', '修改完成');
        } else {
            return withInfoErr('修改失败,请重新操作');
        }
    }
}
