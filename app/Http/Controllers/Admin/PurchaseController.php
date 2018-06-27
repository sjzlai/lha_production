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
     * Notes: 采购列表页
     * Author:sjzlai
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function PurList()
    {
        $data = DB::table('part_purchase')
            ->leftjoin('user', 'part_purchase.user_id', '=', 'user.id')
            ->where('status', '=', '0')
            ->paginate('5');
        return view('lha.purchase.list', ['data' => $data]);
    }

    public function info(Request $request)
    {
        $id = $request->except('_token');
        $data = DB::table('part_purchase')
            ->join('part_purchase_lists', 'part_purchase.order_number', '=', 'part_purchase_lists.purchase_order_no')
            ->join('part_info','part_purchase_lists.part_id','=','part_info.id')
            ->where('part_purchase.order_number', '=', $id)
            ->get();
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
        //part_info 将采购信息存表
        foreach ($date as $value):
            $va = array_slice($value, 1, 2);
            if ($va['manufacturer']==1):
                $va['manufacturer'] ='美国医学声学公司';
            endif;
            $re =PartInfo::create($va);
            $v = array_slice($value, 0, 1);
            $v['part_id'] =$re->id;
            $v['purchase_order_no'] = $data['order_number'];
            $v['status'] = 0;
            $res = Purchase_lists::create($v);
        endforeach;
        $re = Purchase::create($data);
        if ($re):
            return redirect('ad/pur');
        else:
            return "采购失败";
        endif;
    }

    /**
     * Notes: 文章修改页
     * Author:sjzlai
     * @param $id 订单号
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $data = DB::table('part_purchase')
            ->join('part_purchase_lists', 'part_purchase.order_number', '=', 'part_purchase_lists.purchase_order_no')
            ->join('part_info','part_purchase_lists.part_id','=','part_info.id')
            ->where('part_purchase.order_number', '=', $id)
            ->get();
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
        $data = $request->except(['_token', 'order_number', 'delivery_time','manufacturer', 'user_id']);
        $order_number = $request->input('order_number');
        $da['delivery_time'] = $request->input('delivery_time');
        $da['status'] = 0;
        foreach ($data as $v):
            $info = array_slice($v, 0, 1);
            $part_name = array_slice($v, 2, 1);
            $res = DB::table('part_purchase_lists')
                ->where(['part_id' => $part_name['part_id']])
                ->update($info);
            endforeach;
        if ($res):
            $re = DB::table('part_purchase')
                ->where(['order_number' => $order_number])
                ->update($da);
            if ($re):
                return redirect('ad/pur');
            else:
                return redirect('ad/pur');
            endif;
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
                   $re = PartInfo::where(['id'=>$v->part_id])->update(['status'=>1]);
            if ($re):
                return redirect('ad/pur');
            else:
                return redirect('ad/pur');
            endif;
        endif;
    }
}
