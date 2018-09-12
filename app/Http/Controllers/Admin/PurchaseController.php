<?php

namespace App\Http\Controllers\Admin;

use App\Model\PartInfo;
use App\Model\Purchase;
use App\Model\Purchase_lists;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    //
    /**
     * Notes: 采购申请页
     * Author:sjzlai
     */
    public function PurAdd()
    {
        return view('lha.purchase.add');
    }

    /**
     * Notes:关键字模糊搜索订单
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Date:2018/7/2 11:37
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keywords');
        $data = Purchase::searchList($keyword);
        return view('lha.purchase.list', ['data' => $data]);
    }
    /**
     * Notes: 采购列表页
     * Author:sjzlai
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PurList()
    {
        $data = Purchase::DateList();
        return view('lha.purchase.list', ['data' => $data]);
    }

    /**
     * Notes:查看采购零件数量
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * Date:2018/7/2 9:55
     */
    public function info(Request $request)
    {
        $id = $request->except('_token');
        $data = Purchase::PartInfo($id);
        return jsonReturn(1, '成功', $data);
    }

    /**
     * Notes: 添加采购
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function PurToAdd(Request $request)
    {
        //1.先将肺笛信息存入part_info表中
        $date = $request->except(['_token', 'order_number', 'user_id', 'product', 'delivery_time']);
        $data['order_number'] = $request->input('order_number');
        $data['user_id'] = $request->input('user_id');
        $data['delivery_time'] = $request->input('delivery_time');
        $data['status'] = 0;
        $data['warehousing'] = 0;
        if (empty($data['order_number']))return withInfoErr('订单号未输入!请输入');
        //先查询订单号是否存在
        $order_no = Purchase::select('part_purchase.order_number')->where('order_number', '=', $data['order_number'])->get();
        if (!$order_no->isEmpty() && $data['order_number'] !=''):
            return withInfoErr('订单号已存在!请重新输入');
        else:
            //part_info 将采购信息存表
            $res = '';
            foreach ($date as $value):
                $va = array_slice($value, 1, 2);
                if ($va['manufacturer'] == 1):
                    $va['manufacturer'] = '美国医学声学公司';
                endif;
                $va['status'] = 0;
                $re = PartInfo::create($va);
                $v = array_slice($value, 0, 1);
                $v['part_id'] = $re->id;
                $v['purchase_order_no'] = $data['order_number'];
                $v['status'] = 0;
                $res = Purchase_lists::create($v);
            endforeach;
            $re = Purchase::create($data);
            if ($re):
                return redirect()->to('ad/purchase/pur');
            else:
                return withInfoErr('添加失败');
            endif;
        endif;
    }

    /**
     * Notes: 订单修改页
     * Author:sjzlai
     * @param $id 订单号
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {

        $data = Purchase::EditOrder($id);
        return view('lha.purchase.edit', ['data' => $data]);
    }

    /**
     * Notes:修改采购订单提交
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token', 'order_number', 'delivery_time', 'manufacturer', 'user_id']);
        $order_number = $request->input('order_number');
        $da['delivery_time'] = $request->input('delivery_time');
        $da['status'] = 0;
        $re = DB::table('part_purchase')
            ->where(['order_number' => $order_number])
            ->update($da);
        $res = '';
        foreach ($data as $v) {
            $info = array_slice($v, 0, 1);
            $part_name = array_slice($v, 2, 1);
            $info['updated_at'] = date('Y-m-d H:i:s');
            $res = DB::table('part_purchase_lists')
                ->where(['part_id' => $part_name['part_id']])
                ->update($info);
        }
        if ($res):
            return redirect('ad/purchase/pur')->with('message', '修改成功');
        else:
            return withInfoErr('修改失败');
        endif;
    }

    /**
     * Notes: 删除采购订单
     * Author:sjzlai
     * @param $no
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete($no)
    {
        $date = Purchase::where(['order_number' => $no])->update(['status' => 1]);
        if ($date):
            $result = Purchase_lists::where(['purchase_order_no' => $no])->update(['status' => 1]);
            if ($result)
                $ru = Purchase_lists::where(['purchase_order_no' => $no])->select('part_id')->get();
            foreach ($ru as $v)
                $re = PartInfo::where(['id' => $v->part_id])->update(['status' => 1]);
            if ($re):
                return redirect('ad/purchase/pur');
            else:
                return withInfoErr('删除失败');
            endif;
        endif;
    }
}
