<?php

namespace App\Http\Controllers\Admin;

use App\Model\Purchase;
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
        $number=$request->input('order_number');
        foreach ($date as $value):
            $value['purchase_order_no'] = $number;
        dump($value);
           $res = Purchase::create($value);
        endforeach;
        if ($res):
            return "采购成功";
        else:
            return "采购失败";
        endif;
    }
}
