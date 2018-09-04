<?php

namespace App\Http\Controllers\Admin;

use App\Model\GoodsShelve;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class GoodsShelveController
 * @package App\Http\Controllers\Admin
 * @name:货架资源控制器
 * @author: weikai
 * @date: 2018/6/26 15:51
 */
class GoodsShelveController extends Controller
{
    public $goodsShelve;//货架类实例
    public function __construct(GoodsShelve $goodsShelve)
    {
        $this->goodsShelve = $goodsShelve;
    }


    public function index()
    {

    }


    public function create()
    {


    }

    /**
     * @param Request $request
     * @name:执行货架添加
     * @author: weikai
     * @date: 2018/6/27 15:31
     */
    public function store(Request $request)
    {
        if (!$request->input('storage_name') || !$request->input('id')) return withInfoErr('缺少参数');
        $data['shelf_name'] = $request->input('storage_name');
        $data['storageroom_id'] = $request->input('id');
        $res = $this->goodsShelve->insert($data);
        if (!$res) return withInfoErr('添加失败');
        return redirect("/ad/goodsShelve/".$data['storageroom_id'])->withInfoMsg('添加成功');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     * @name:库房内货架列表
     * @author: weikai
     * @date: 2018/6/27 15:13
     */
    public function show($id)
    {
        if (!$id) return withInfoErr('没有仓库id');
        $goodsShelves = $this->goodsShelve->goodsShelveAll($id);
        return view('lha.goodsShelve.goodsShelve-list',['goodsShelves'=>$goodsShelves,'id'=>$id]);
    }

    /**
     * @param $id
     * @name:返回修改视图
     * @author: weikai
     * @date: 2018/6/27 15:44
     */
    public function edit($id)
    {
        $goodsShelve = $this->goodsShelve->find($id);
        return view('lha.goodsShelve.goodsShelve-edit',['goodsShelve'=>$goodsShelve]);
    }

    /**
     * @param Request $request
     * @param $id
     * @name:执行修改操作
     * @author: weikai
     * @date: 2018/6/27 15:50
     */
    public function update(Request $request, $id)
    {
        if (!$request->input('shelf_name')) return jsonReturn('0','没有货架名');
        $goodsShelve = $this->goodsShelve->find($id);
        $goodsShelve->shelf_name = $request->input('shelf_name');
        $res = $goodsShelve->save();
        if  (!$res) return jsonReturn('0','修改失败');
        return jsonReturn('1','修改成功');
    }

    /**
     * @param $id
     * @name:删除货架
     * @author: weikai
     * @date: 2018/6/27 16:26
     */
    public function destroy($id)
    {
        $goodsShelve = DB::table('shelf_has_part')->where('shelf_id',$id)->first();
        if (!empty($goodsShelve->part_id)) return jsonReturn('0','此货架内还有物品不能删除',$id);
        $res = GoodsShelve::destroy($id);
        if (!$res) return jsonReturn('0','删除失败');
        return jsonReturn('1','删除成功');
    }

    /**
     * @name:货架内货物列表
     * @author: weikai
     * @date: 2018/6/27 9:43
     */
    public function goodsList($goodsShelveId)
    {
        $goodsLists = $this->goodsShelve->goodsList($goodsShelveId);//货物信息
        //dd($goodsLists);
        $goodsShelveName = $this->goodsShelve->find($goodsShelveId);//货架名称
        return view('lha.goodsShelve.goodsShelve-goods-list',['goodsLists'=>$goodsLists,'goodsShelveName'=>$goodsShelveName]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:模糊搜索物品
     * @author: weikai
     * @date: 2018/6/27 15:13
     */
    public function goodsFuzzySearch(Request $request)
    {
        $goodsShelveId = $request->input('goodsShelveId');
        $keyword = $request->input('keyword');
        $goodsLists = $this->goodsShelve->goodsFuzzySearch($goodsShelveId,$keyword);
        $goodsShelveName = $this->goodsShelve->find($goodsShelveId);//货架名称
        return view('lha.goodsShelve.goodsShelve-goods-list',['goodsLists'=>$goodsLists,'goodsShelveName'=>$goodsShelveName]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:货架模糊搜索
     * @author: weikai
     * @date: 2018/6/28 9:28
     */

    public function fuzzySearch(Request $request)
    {
        $storageRoomId  = $request->input('storageRoomId');
        $shelfName = 'shelf_name';
        $keyword = $request->input('keyword');
        $goodsShelves =$this->goodsShelve->goodsShelveFuzzySearch($storageRoomId,$shelfName,$keyword);
        return view('lha.goodsShelve.goodsShelve-list',['goodsShelves'=>$goodsShelves,'id'=>$storageRoomId]);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:返回添加货架的视图
     * @author: weikai
     * @date: 2018/6/27 15:27
     */
    public function goodsShelveAdd($id)
    {
        return view('lha.goodsShelve.goodsShelve-add',['id'=>$id]);
    }
}
