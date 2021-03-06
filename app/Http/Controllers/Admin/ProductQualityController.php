<?php

namespace App\Http\Controllers\Admin;

use App\Model\ProductionQualityTest;
use App\Model\PurchasingOrder;
use Faker\Provider\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProductQualityController
 * @package App\Http\Controllers\Admin
 * @name:成品质检控制器
 * @author: 
 * @date: 2018/7/9 10:24
 */
class ProductQualityController extends Controller
{
   public $productOrder;

    public function __construct(PurchasingOrder $model)
    {
        $this->productOrder = $model;
    }


    /**
     * @name:为生产订单添加质检视图
     * @author: 
     * @date: 2018/7/9 10:26
     */
    public function qualityAddView($orderId)
    {
//        dd($orderId);
        return view('lha.productQuality.production-quality-add',['orderId'=>$orderId]);
    }

    /**
     * @param Request $request
     * @name:为生产订单添加质检
     * @author: 
     * @date: 2018/7/9 11:27
     */
    public function qualityAdd(Request $request)
    {
//        dd($request);
        $datas = $request->except('_token','img');//获取数据
        if (!$request->file('img')->isValid()) return withInfoErr('上次失败');
        $file = $request->file('img');
        // 获取文件相关信息
        $originalName = $file->getClientOriginalName(); // 文件原名
        $ext = $file->getClientOriginalExtension();     // 扩展名
        $realPath = $file->getRealPath();   //临时文件的绝对路径
        $type = $file->getClientMimeType();     // image/jpe
        // 上传文件
        $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
        // 使用我们新建的uploads本地存储空间（目录）
        $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
        $filedir = "public/upload/productQuality/"; //定义图片上传路径
        $file->move($filedir, $filename);
        $datas['img_path'] = $filedir . $filename;
        $datas['user_id'] = session('user.id');
        $datas['status'] = 1;
        $res = ProductionQualityTest::create($datas);
        if (!$res) return withInfoErr('添加失败');
       return  redirect("/ad/qualityProductionOrder")->withInfoErr('添加成功');
//        return  withInfoErr('添加成功');


    }

    /**
     * @name:订单质检视图
     * @author: 
     * @date: 2018/7/9 10:33
     */
    public function orderList()
    {
        $ordersEn = $this->productOrder->orderListno(1,5);//已处理订单
        //查询已处理订单中已做质检的
        //dd($ordersEn);
        if ($ordersEn->isEmpty())    return view('lha.productWarehousing.black');
        return view('lha.productQuality.production-order-list',['ordersEn'=>$ordersEn]);
    }

    /**
     * Notes: 模糊搜索订单质检
     * Author:sjzlai
     * @param Request $request
     */
    public function fuzzySearch(Request $request)
    {
        //如果搜索值为空 重定向到双订单页面
        if(empty($request->input('keyword')))
            return  redirect('/ad/qualityProductionOrder');
        $key = 'order_no';
        $keyword = $request->input('keyword');
        $orderAll  = PurchasingOrder::orderFuzzySearch($key,$keyword);
        return view('lha.productQuality.production-order-list',['ordersEn'=>$orderAll]);
    }

    /**
     * Notes:查看质检结果
     */
    public function img($order_number)
    {
        $img = ProductionQualityTest::where(['production_order_no' => $order_number])->get();
        return view('lha.quality.img', ['img' => $img]);
    }
}
