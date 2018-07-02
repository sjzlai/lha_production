<?php

namespace App\Http\Controllers\Admin;

use App\Model\Pruchase_quality;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class QualityController extends Controller
{
    //零部件质检
    /**
     * Notes:质检列表页
     * Author:sjzlai
     */
    public function index()
    {
        $data = Pruchase_quality::QualityList();
        return view('lha.quality.list', ['data' => $data]);
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keywords');
        $data = Pruchase_quality::QualitySearch($keyword);
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
            $info = $request->except('_token', 'picture');
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
            $res = Pruchase_quality::create($info);
            if ($res):
                return redirect('ad/quality');
            else:
                return "采购失败";
            endif;
        }
    }

    /**
     * Notes:查看质检结果
     * Author:sjzlai
     */
    public function img($order_number)
    {
        $img = Pruchase_quality::where(['purchase_order_no'=>$order_number])->get();
        return view('lha.quality.img',['img'=>$img]);
    }
}
