<?php

namespace App\Http\Controllers\Admin;

use App\Model\Purchase_quality;
use App\Model\Purchase_lists;
use App\Model\Unqualified;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Notes:零部件质检
 * Class QualityController
 * @package App\Http\Controllers\Admin
 * Author:sjzlai
 * Date:2018/07/17 11:07
 */
class QualityController extends Controller
{
    //零部件质检
    /**
     * Notes:质检列表页
     * Author:sjzlai
     */
    public function index()
    {
        $data = Purchase_quality::QualityList($page=10);
        return view('lha.quality.list', ['data' => $data]);
    }

    /**
     * Notes:关键词搜索
     * Author:sjzlai
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * Date:2018/07/06 10:04
     */
    public function search(Request $request)
    {
        $keyword = $request->input('keywords');
        $data = Purchase_quality::QualitySearch($keyword);
        return view('lha.quality.list', ['data' => $data]);
    }

    /**
     * Notes:质检详情页面
     * Author:sjzlai
     */
    public function show($order_number)
    {
        return view('lha.quality.show', compact('order_number'));
    }

    /**
     * Notes:质检提交
     * Author:sjzlai
     */
    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->except('_token', 'picture','purchase_order_no','status','user_id');
            $info['purchase_order_no'] = $request->input('purchase_order_no');
            $info['status'] = $request->input('status');
            $info['user_id'] = $request->input('user_id');
            $file = $request->file('picture');
            // 文件是否上传成功
            if ($file->isValid()) {
                // 获取文件相关信息
                $originalName = $file->getClientOriginalName(); // 文件原名
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                $type = $file->getClientMimeType();     // image/jpe
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用我们新建的uploads本地存储空间（目录）
                $bool = Storage::disk('public')->put($filename, file_get_contents($realPath));
                $filedir = "upload/parts-img/"; //定义图片上传路径
                $file->move($filedir, $filename);
            }
            $info['img_path'] = $filedir . $filename;
            //判断订单是否已经上传过质检结果
            $result = Purchase_quality::where(['purchase_order_no'=>$info['purchase_order_no']])->get();
            if (!$result->isEmpty()):
                return withInfoErr('订单号已存在!请重新输入');
            else:
            $res = Purchase_quality::create($info);
            if ($res):
                //将不合格零部件数量及批号存入到表part_info_unqualified
//              dump($data);
                for($j=1; $j<count($data);$j++):
                    for ($i=0; $i<count($data[$j]['part_number']);$i++):
                        $a['purchase_order_no'] = $info['purchase_order_no'];
                        $a['part_id']= "$j";
                        $a['part_number'] = $data[$j]['part_number'][$i];
                        $a['batch_number'] =$data[$j]['batch_number'][$i];
                        $re= Unqualified::create($a);
                    endfor;
                endfor;
                if ($re):
                        return redirect('ad/quality');
                    else:
                        return "采购失败";
                    endif;
            endif;
            endif;
        }
    }

    /**
     * Notes:查看质检结果
     * Author:sjzlai
     */
    public function img($order_number)
    {
        $img = Purchase_quality::where(['purchase_order_no'=>$order_number])->get();
        return view('lha.quality.img',['img'=>$img]);
    }
}
