<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use App\Model\Purchase;
use App\Model\Purchase_quality;
use App\Model\StorageRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        return view('lha.spareparts.list',compact('data'));
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
        $info = Purchase::where(['warehousing'=>'0','order_number'=>$order_number])->get();
        $room = StorageRoom::roomAll();
        return view('lha.spareparts.parts-add',['info'=>$info,'room'=>$room]);
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
        $shelve =GoodsShelve::RoomShelveList($id);
        return jsonReturn('1','货架列表',$shelve);
    }
}
