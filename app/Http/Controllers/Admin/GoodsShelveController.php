<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class GoodsShelveController
 * @package App\Http\Controllers\Admin
 * @name:货架资源控制器
 * @author: weikai
 * @date: 2018/6/26 15:51
 */
class GoodsShelveController extends Controller
{
    public $goodsShelve;
    public function __construct(GoodsShelve $goodsShelve)
    {
        $this->goodsShelve = $goodsShelve;
    }


    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$id) return withInfoErr('没有仓库id');
        $goodsShelves = $this->goodsShelve->goodsShelveAll($id);
        return view('lha.goodsShelve.goodsShelve-list',['goodsShelves'=>$goodsShelves]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
