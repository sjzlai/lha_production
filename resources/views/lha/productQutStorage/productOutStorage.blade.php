@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productWarehousingOrderList">订单查看</a> &raquo;成品出库
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/productOutStorage" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="production_order_no" value="{{$orderId}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>订单号：</th>
                        <td style="font-weight: bold">{{$orderId}}</td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>工厂订单号：</th>
                        <td style="font-weight: bold">{{$factoryNO}}</td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>选择出库</th>
                        <td style="display: block">
                            <select class="" name="shelf_id"  id="">
                                <option value="">选择库房</option>
                                @foreach($storageRooms as $storageRoom)
                                    <option class="options" value="{{$storageRoom->shelf_id}}" style="font-weight: bold; font-size: 14px">库房名：{{$storageRoom->store_name}}&nbsp;&nbsp;
                                        货架名:{{ $storageRoom->shelf_name}}&nbsp;&nbsp;
                                        产品名：@if($storageRoom->part_name ==1) 成品&nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==2) 吹嘴 &nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==3) 笛管 &nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==4) 哨片 &nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==5) 垫片 &nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==6) 肺笛袋  &nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==7) 哨片袋  &nbsp;&nbsp;
                                               @elseif($storageRoom->part_name ==8) 皮筋   &nbsp;&nbsp;
                                               @endif
                                        库存量：{{$storageRoom->part_number}}
                                        创建时间：{{$storageRoom->created_at}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>出库数量：</th>
                        <td><input name="number" type="number" placeholder="请输入出库数量"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>发货地址：</th>
                        <td><input name="shipping_address" type="text" placeholder="请输入发货地址"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>收货人选择：</th>
                        <td>
                            <select class="" name="consignee"  id="">
                                <option value="">选择收货人</option>
                                @foreach($consignees as $consignee)
                                    <option class="options" value="{{$consignee->id}}" style="font-weight: bold; font-size: 14px">
                                        收货人姓名：{{$consignee->consignee_name}}&nbsp;&nbsp;
                                        电话：{{$consignee->phone}}&nbsp;&nbsp;
                                        地址：{{$consignee->address}}&nbsp;&nbsp;
                                    </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>物流方式：</th>
                        <td>
                            <select class="selects" name="logistics_mode"  id="">
                                <option value="">物流方式</option>
                                    <option class="options" value="1" style="font-weight: bold; font-size: 14px">快递 &nbsp;&nbsp;</option>
                                    <option class="options" value="2" style="font-weight: bold; font-size: 14px">自提 &nbsp;&nbsp;</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>物流公司：</th>
                        <td>
                            <select class="selects" name="logistics_company"  id="">
                                <option value="">物流公司</option>
                                    <option class="options" value="1" style="font-weight: bold; font-size: 14px">顺丰 &nbsp;&nbsp;</option>
                                    <option class="options" value="2" style="font-weight: bold; font-size: 14px">申通 &nbsp;&nbsp;</option>
                                    <option class="options" value="3" style="font-weight: bold; font-size: 14px">中通 &nbsp;&nbsp;</option>
                                    <option class="options" value="4" style="font-weight: bold; font-size: 14px">圆通 &nbsp;&nbsp;</option>
                                    <option class="options" value="5" style="font-weight: bold; font-size: 14px">EMS &nbsp;&nbsp;</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>

        $(".selects").change(function () {
            $(".n").remove()
            var options=$(this).children("option:selected").val();
           $.get('/ad/shelfInfo/'+options,function (data,status) {
            if (data.status ==1){
                var i =0;
                for(i = 0; i<data.data.length;i++){
                    var html = '   <option class="n" value='+data.data[i].id+ '>'+data.data[i].shelf_name+'</option>';
                    $(".shelf").append(html)
                }

            }
           })
        });
    </script>
@endsection