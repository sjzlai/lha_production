<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use App\Model\PartInfoDetailed;
use App\Model\PartPutStorageRecord;
use App\Model\Purchase;
use App\Model\Purchase_quality;
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
        $orderEn= Purchase_quality::QualityOk(1);
        $orderUn= Purchase_quality::QualityOk(0);
        return view('lha.spareparts.list', ['orderEn'=>$orderEn,'orderUn'=>$orderUn]);
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
        $info = Purchase::where(['warehousing' => '0', 'order_number' => $order_number])->get();
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
        $id = $request->except('_token');
        $shelve = GoodsShelve::RoomShelveList($id);
        return jsonReturn('1', '货架列表', $shelve);
    }

    /**
     * Notes:订单入库操作
     * explain: 将所有零部件入库做记录,并验证入库数量=订单数量-不合格数量
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * Date:2018/07/13 10:06
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'purchase_order_no', 'store_room', 'put_storage_no', 'shelve','user_id');
        $info['purchase_order_no'] = $request->input('purchase_order_no');
        $info['storageroom_id'] = $request->input('store_room');
        $info['put_storage_no'] = $request->input('put_storage_no');
        $info['shelve_id'] = $request->input('shelve');
        $info['user_id'] = $request->input('user_id');
        $result = PartPutStorageRecord::create($info);      //将存库信息存入记录表
        if ($result):
            //将零部件详细信息:数量,批号,型号存入表part_info_detailed
            for ($i = 1; $i < count($data); $i++):
                for ($j = 0; $j < count($data[$i]['part_number']); $j++):
                    $a['part_id'] = $i;
                    $a['part_number'] = $data[$i]['part_number'][$j];
                    $a['batch_number'] = $data[$i]['batch_number'][$j];
                    $a['model'] = $data[$i]['model'][$j];
                    $a['status'] = 1;
                    $a['purchase_order_no'] = $info['purcjase_order_no'];
                    $re = PartInfoDetailed::create($a);
                endfor;
            endfor;
            if ($re):       //更改订单入库状态
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
        dd($record);
        return view('lha.spareparts.part-inrecord',['data'=>$record]);
    }
}
