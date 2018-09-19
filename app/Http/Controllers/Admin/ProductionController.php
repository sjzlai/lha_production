<?php

namespace App\Http\Controllers\Admin;

use App\Model\NumberRecord;
use App\Model\OrdereNoLinkFactoryNo;
use App\Model\PartInfo;
use App\Model\PartProductionLists;
use App\Model\ProductInfo;
use App\Model\ProductionPlan;
use App\Model\ProductionRecord;
use App\Model\PurchasingOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//生产管理控制器
class ProductionController extends Controller
{
    public $model ;
    public $prModel ;
    public $pplModel;
    public $olfModel;
    public $excel;
    public function __construct
    (
        PurchasingOrder $purchasingOrder,
        ProductionRecord $productionRecord,
        PartProductionLists $partProductionLists,
        ProductInfo $productInfo,
        ProductionPlan $productionPlan,
        ExcelController $excelController,
        OrdereNoLinkFactoryNo $ordereNoLinkFactoryNo
    )
    {
        $this->model = $purchasingOrder;
        $this->prModel = $productionRecord;
        $this->pplModel = $partProductionLists;
        $this->piModel = $productInfo;
        $this->ppModel = $productionPlan;
        $this->olfModel = $ordereNoLinkFactoryNo;
        $this->excel = $excelController;
    }

    //生产订单查看
    public function orderList()
    {
        $ordersUn = $this->model->orderList(2);//未处理订单
        $ordersEn = $this->model->orderList(1,1);//已处理订单
return view('lha.production.production-order-list',['ordersUn'=>$ordersUn,'ordersEn'=>$ordersEn]);
    }

    /**
     * @param $orderId
     * @return \Illuminate\Http\RedirectResponse
     * @name:生产订单处理
     * @author: weikai
     * @date: 2018/6/29 10:49
     */
    public function productionHandle($orderId)
    {
        $order = PurchasingOrder::find($orderId);
        $order->status = 1;
        $res = $order->save();
        if (!$res) return withInfoErr('处理失败');
        return withInfoMsg('已处理');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:模糊搜索订单
     * @author: weikai
     * @date: 2018/6/29 11:05
     */
    public function fuzzySearch(Request $request)
    {
        //如果搜索值为空 重定向到双订单页面
        if(empty($request->input('keyword')))
          return  redirect('/ad/productionOrder');
        $key = 'order_no';
        $keyword = $request->input('keyword');
        $orderAll  = PurchasingOrder::orderFuzzySearch($key,$keyword);
        return view('lha.production.production-list',['orders'=>$orderAll]);
    }

    /**
     * @name:生产计划添加视图
     * @author: weikai
     * @date: 2018/6/29 14:48
     */
    public function productionPlanAddView($orderId)
    {
        $res = $this->ppModel->where('order_no',$orderId)->first();
        if ($res) return withInfoErr('已有生产计划');
        $partInfosCZ = PartInfo::fuzzySearch('吹嘴');
        $partInfosDG = PartInfo::fuzzySearch('笛管');
        $partInfosSP = PartInfo::fuzzySearch('哨片');
        $partInfosDP = PartInfo::fuzzySearch('垫片');
        $partInfosFDD = PartInfo::fuzzySearch('肺笛袋');
        $partInfosSPD = PartInfo::fuzzySearch('哨片袋');
        $partInfosPJ = PartInfo::fuzzySearch('皮筋');
//        $partInfos = PartInfo::all();
        return view('lha.production.production-add',[
            'orderId'=>$orderId,
//            'orderId'=>$orderId,
            'partInfosCZ'=>$partInfosCZ,
            'partInfosDG'=>$partInfosDG,
            'partInfosSP'=>$partInfosSP,
            'partInfosDP'=>$partInfosDP,
            'partInfosFDD'=>$partInfosFDD,
            'partInfosSPD'=>$partInfosSPD,
            'partInfosPJ'=>$partInfosPJ
//            'partInfos'=>$partInfos
        ]);
    }

    /**
     * @param Request $request
     * @name:生产计划添加
     * @author: weikai
     * @date: 2018/6/29 15:15
     */
    public function productionPlan(Request $request)
    {

        $datas = $request->except('_token','order_no','output','remark','production_plan_date','product_name','product_batch_number','product_spec','factory_no');
//        if (count($data)<8) return withInfoErr('请填写完整');
        $data = array();
        $data['order_no'] = $request->input('order_no');//生产订单号
        $data['output'] = $request->input('output');//生产量
        $data['remark'] = $request->input('remark');//备注
        $data['production_plan_date'] = $request->input('production_plan_date');//预计完工日期

//        $data['part_id'] = $request->input('part_id');//零部件id
//        $data['part_number'] = $request->input('part_number');//零部件数量

        $data['product_name'] = $request->input('product_name');//成品名称
        $data['product_batch_number'] = $request->input('product_batch_number');//成品批号
        $data['product_spec'] = $request->input('product_spec');//成品规格
        $data['factory_no'] = $request->input('factory_no');//工厂订单号

        //生产计划表写入
        $this->ppModel->production_plan_date = date('Y-m-d H:i:s',strtotime($data['production_plan_date']));//完工时间写入
        $this->ppModel->order_no =$data['order_no'];//订单号写入
        $this->ppModel->output =$data['output'];//生产量写入
        $this->ppModel->remark =$data['remark'];//备注写入
        $this->ppModel->user_id =session('user.id');//用户id写入
        $ppRes = $this->ppModel->save();

        //零部件清单表写入
//        for ($i = 0; $i < count($data['part_id']); $i++) {
//            $pplData['order_no'] = $data['order_no'];
//            $pplData['part_id'] = $data['part_id'][$i];
//            $pplData['part_number'] = $data['part_number'][$i];
//            $pplRes =  $this->pplModel->create($pplData);
//        }
//        dd($datas);
        //零部件清单表写入
        for ($i=1; $i <= count($datas); $i++):
            for ($j = 0; $j < count($datas[$i]['part_number']); $j++):
                //将零部件详细信息:数量,批号,型号存入表part_info_detailed
                $a['part_id'] = $i;
                $a['part_number'] = $datas[$i]['part_number'][$j];
                $a['order_no']=$data['order_no'];
//                dd($a);
                $pplRes = $this->pplModel->create($a);
            endfor;
        endfor;
//    dd($pplRes);
        //成品信息表写入
        for ($i=0;$i<$data['output'];$i++){
            $piData['product_name'] = $data['product_name'];
            $piData['product_batch_number'] = $data['product_batch_number'];
            $piData['product_spec'] = $data['product_spec'];
            $piData['order_no'] = $data['order_no'];
            $piData['product_code'] = $this->codeMake($data['order_no'],$data['product_batch_number']);//产品标识码
            $piRes = $this->piModel->create($piData);
        }


        //工厂单号与生产订单号关联表写入
        $this->olfModel->order_no =  $data['order_no'];
        $this->olfModel->factory_no =  $data['factory_no'];
        $olfRes = $this->olfModel->save();


        if (!$ppRes || !$pplRes || !$piRes || !$olfRes) return withInfoErr('添加失败');
        return redirect("/ad/productionPlanInfo/".$data['order_no']);
    }

    /**
     * @name:产品标识码生产
     * @author: weikai
     * @date: 2018/7/12 11:21
     */
    public function codeMake($orderId,$product_batch_number)
    {
        $province = PurchasingOrder::codeMake($orderId);//查询省份缩写
        $last_num = NumberRecord::where('product_batch_number',$product_batch_number)->pluck('last_num')->toArray();//查询最后一次的递增号
        //如果递增号没查到就初始值为10000 否则循环一次递增一次
        if (!$last_num) {
            $n = 10000;
        }else{
            $n = intval($last_num[0]);
            $n++;
        }

        $code = $province[0].$product_batch_number.mt_rand('10','99').$n;//拼接产品id
        //如果是这一批第一次生成就创建递增记录表否则就更新递增表递增数
        if ($n == 10000){
            $data['product_batch_number'] = $product_batch_number;
            $data['last_num'] = $n;
            NumberRecord::create($data);
        }
        $numberRecord = NumberRecord::where('product_batch_number',$product_batch_number)->first();
        $numberRecord->last_num = $n;
        $numberRecord->save();
        return $code;
    }
    /**
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:生产计划详情
     * @author: weikai
     * @date: 2018/6/29 16:26
     */
    public function productionPlanInfo($orderId)
    {
        $data = ProductionPlan::productionPlanInfo($orderId);
        return view('lha.production.productionPlan-info',['productionPlanInfo'=>$data]);
    }

    /**
     * @param $orderId
     * @name:成品信息excel导出
     * @author: weikai
     * @date: 2018/7/11 15:38
     */
    public function productExcelDown($orderId)
    {
        $data = ProductionPlan::productionPlanInfo($orderId);
        $a = [];
        $title = array('工厂订单号','成品名称','成品标识码','成品批号','成品规格','记录人姓名','记录人手机号','生产计划ID','生产订单号','预计完工日期','生产数量','备注信息','用户id','创建时间','修改时间');
        array_unshift($a,$title);
        $b=array_values($data['product']);
        array_push($a,$b);
        $this->excel->export('成品记录',$a);
    }

    /**
     * @param $orderId
     * @name:零部件清单Excel导出
     * @author: weikai
     * @date: 2018/7/11 16:41
     */
    public function partExcelDown($orderId)
    {
        $data = ProductionPlan::productionPlanInfo($orderId);
        $b = [];
        for ($i=0;$i<count($data['part']);$i++){
            array_push($b,array_values($data['part'][$i]));
        }
        $title1 = array('零部件ID','零部件数量','零部件名称','零部件生产商','零部件批号','零部件型号');
        array_unshift($b,$title1);
        $this->excel->export('零部件清单',$b);
    }

    /**
     * @name:生产记录登记视图
     * @author: weikai
     * @date: 2018/7/10 9:03
     */
    public function productionRecordView($orderId)
    {
        return view('lha.production.production-record-add',['orderId'=>$orderId]);
    }

    /**
     * @name:生产记录登记
     * @author: weikai
     * @date: 2018/7/10 9:35
     */
    public function productionMakeRecord(Request $request)
    {
        $data = $request->except('_token');

        $data['user_id'] = session('user.id');
        $data['product_date'] = date('Y-m-d h:i:s',strtotime($data['product_date']));
        $prRes = $this->prModel->create($data);
        if (!$prRes) return withInfoErr('添加失败');
//        $request->session()->all();
//        return redirect()->route("/ad/productionRecordList",[$data['order_no']=>1])->with(['message'=>'添加成功']);
        return redirect("/ad/productionRecordList/".$data['order_no'])->with(['message'=>'添加成功']);
       // return redirect()->route('ad/productionRecordList',['orderId'=>$data['order_no']])->with(['message'=>'添加成功']);

    }

    /**
     * @param $orderId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @name:生产记录列表
     * @author: weikai
     * @date: 2018/7/12 14:27
     */
    public function productionRecordList($orderId)
    {
        $recordLists = $this->prModel->recordList($orderId);
        return view('lha.production.production-record-list',['recordLists'=>$recordLists]);
    }

    public function test()
    {
        $str = 'asdaf12345678901235';
        $code = floatval(sprintf('%u', crc32($str)));

        $sstr = '';

        while($code){
            $mod = fmod($code, 62);
            if($mod>9 && $mod<=35){
                $mod = chr($mod + 55);
            }elseif($mod>35){
                $mod = chr($mod + 61);
            }
            $sstr .= $mod;
            $code = floor($code/62);
        }

        return $sstr;

    }


}
