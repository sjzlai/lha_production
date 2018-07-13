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
 * @author: weikai
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
     * @author: weikai
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
     * @author: weikai
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
        $res = ProductionQualityTest::create($datas);
        if (!$res) return withInfoErr('添加失败');
        return withInfoErr('添加成功');

    }

    /**
     * @name:生产订单
     * @author: weikai
     * @date: 2018/7/9 10:33
     */
    public function orderList()
    {
        $ordersEn = $this->productOrder->orderList(1,5);//已处理订单
        return view('lha.productQuality.production-order-list',['ordersEn'=>$ordersEn]);
    }
}
