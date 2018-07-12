<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use App\Model\PartInfoDetailed;
use App\Model\PartPutStorageRecord;
use App\Model\Purchase;
use App\Model\Purchase_quality;
use App\Model\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SparePartsController extends Controller
{
    /**
     * 零部件仓库
     */

    /**
     * Notes:列表页
     * Author:sjzlai
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Date:2018/7/3 10:51
     */
    public function index()
    {
        $data = Purchase_quality::QualityOk();
        return view('lha.spareparts.list', compact('data'));
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

    public function store(Request $request)
    {
        $data = $request->except('_token', 'purchase_order_no', 'store_room', 'put_storage_no', 'shelve','user_id');
        //dd($data);
        $info['purchase_order_no'] = $request->input('purchase_order_no');
        $info['room_id'] = $request->input('store_room');
        $info['put_storage_no'] = $request->input('put_storage_no');
        $info['shelve_id'] = $request->input('shelve');
        $info['user_id'] = $request->input('user_id');
        $result = PartPutStorageRecord::create($info);
        if ($result):
            //将零部件信息:数量,批号,型号存入表part_info_detailed
            for ($i = 1; $i < count($data); $i++):
                for ($j = 0; $j < count($data[$i]['part_number']); $j++):
                    $a['part_id'] = $i;
                    $a['part_number'] = $data[$i]['part_number'][$j];
                    $a['batch_number'] = $data[$i]['batch_number'][$j];
                    $a['model'] = $data[$i]['model'][$j];
                    $a['status'] = 1;
                    $re = PartInfoDetailed::create($a);
                endfor;
            endfor;
            if ($re):
                back()->withInfoMsg('入库成功');
                return redirect('ad/spare');
            else:
                return back()->withInfoErr('入库失败');
            endif;
        endif;
    }
}
