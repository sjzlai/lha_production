@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productWarehousingOrderList">订单查看</a> &raquo;成品入库
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/productWarehousing" method="post" enctype="multipart/form-data">
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
                        <th><i class="require">*</i>存入库房</th>
                        <td style="display: block">
                            <select class="selects" name="storageRoom"  id="">
                                <option value="">选择库房</option>
                                @foreach($storageRooms as $storageRoom)
                                    <option class="options" value="{{$storageRoom->id}}">{{$storageRoom->store_name}}</option>
                                @endforeach
                            </select>
                            <select name="shelf" id="" class="shelf">
                            <option class="" value="">选择货架</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>入库数量：</th>
                        <td><input name="number" type="number" placeholder="请输入入库数量"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>备注</th>
                        <td><textarea name="remark" id="" cols="30" rows="10"></textarea></td>
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