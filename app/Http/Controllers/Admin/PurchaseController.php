<?php

namespace App\Http\Controllers\Admin;

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
            ->leftjoin('user','part_purchase.user_id','=','user.id')
            ->paginate('5');
        return view('lha.purchase.list',['data'=>$data]);
    }

    public function info(Request $request)
    {
        $id = $request->except('_token');
        $res = Purchase_lists::where(['purchase_order_no'=>$id['id']])->get();
        return jsonReturn(1,'成功',$res);
    }
    /**
     * Notes: 添加采购
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function PurToAdd(Request $request)
    {
        $date = $request->except(['_token','order_number','user_id','delivery_time']);
        $data['order_number']=$request->input('order_number');
        $data['user_id'] = $request->input('user_id');
        $data['delivery_time'] = $request->input('delivery_time');
        foreach ($date as $value):
            $value['purchase_order_no'] = $data['order_number'];
           $res = Purchase_lists::create($value);
        endforeach;
        $re = Purchase::create($data);
        if ( $re):
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
                    ->leftjoin('part_purchase_lists','part_purchase.order_number','=','part_purchase_lists.purchase_order_no')
                    ->where('part_purchase.order_number','=',$id)
                    ->get();
        return view('lha.purchase.edit',['data'=>$data]);
    }

    /**
     * Notes:修改采购订单提交
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $data = $request->except(['_token','order_number','delivery_time','user_id']);
        $order_number = $request->input('order_number');
        $da['delivery_time'] = $request->input('delivery_time');
        //dd($da);
        //dd($order_number);
        foreach($data as $v)
        $res = DB::table('part_purchase_lists')
            ->where(['part_id'=>$v['part_id']])
            ->update($v);
        if ($res):
            $re = DB::table('part_purchase')
                ->where(['order_number'=>$order_number])
                ->update($da);
        if ($re):
            return redirect('ad/pur');
        else:
            return redirect('ad/pur');
        endif;
        endif;
        }
}
