@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productionOrder">生产订单</a> &raquo;生产计划添加
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/productionPlan" method="post">
            {{csrf_field()}}
            <input type="hidden" name="order_no" value="{{$orderId}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>生产订单号：</th>
                        <td>{{$orderId}}</td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>生产量：</th>
                        <td><input type="number" class="lg" name="output"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>该生产量预计完工时间</th>
                        <td><input type="date" name="production_plan_date"></td>
                    </tr>
                   <tr>
                       <th><i class="require">*</i>备注：</th>
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

@endsection