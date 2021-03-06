@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productionOrder">生产订单</a> &raquo;生产记录登记
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/productionMakeRecord" method="post">
            {{csrf_field()}}
            <input type="hidden" name="order_no" value="{{$orderId}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>订单号：</th>
                        <td style="font-weight: bold">{{$orderId}}</td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>生产日期：</th>
                        <td><input type="text" class="lg" name="product_date" id="test" placeholder="请选择生产日期" style="width: 130px;"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>实际日生产量：</th>
                        <td><input type="number" class="lg" name="number" style="width: 140px;"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>成品批号</th>
                        <td><input type="text" name="product_batch_number"  onkeyup="value=value.replace(/[\W]/g,'') " style="width: 130px;" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))" placeholder="请输入成品批号"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>成品Id范围</th>
                        <td><input type="text" style="width: 50px;" name="product_code_range_up"> <i class="require">-</i><input type="text" style="width: 50px;" name="product_code_range_down"></td>

                    </tr>
                    <tr>
                        <th><i class="require">注意</i></th>
                        <td><i class="require">请输入完整的成品标识码范围</i></td>
                    </tr>

                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="reset" class="back"  style="background: #337ab7;color: #fff; height:26px; width: 82.67px
" value="重置">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        lay('#version').html('-v'+ laydate.v);

        //执行一个laydate实例
        laydate.render({
            elem: '#test' //指定元素
        });
    </script>

@endsection