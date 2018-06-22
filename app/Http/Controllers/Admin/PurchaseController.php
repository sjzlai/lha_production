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
        return view('lha.purchase.list');
    }

    public function PurToAdd(Request $request)
    {
        $date = $request->except(['_token','order_number','user_id']);
        $data['order_number']=$request->input('order_number');
        $data['user_id'] = $request->input('user_id');
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
}
