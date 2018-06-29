<?php

namespace App\Http\Controllers\Admin;

use App\Model\Purchase;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SparePartsController extends Controller
{
    /**
     * 零部件仓库
     */


    public function index()
    {
        return view('lha.spareparts.list');
    }

    public function addparts()
    {
        $info = Purchase::where(['warehousing'=>'0'])->get();
        return view('lha.spareparts.parts-add',['info'=>$info]);
    }
}
