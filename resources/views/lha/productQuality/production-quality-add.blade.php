@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productionOrder">成品质检</a> &raquo;质检添加
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/qualityAdd" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="production_order_no" value="{{$orderId}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>生产订单号：</th>
                        <td>{{$orderId}}</td>
                    </tr>
                    {{--<tr id="">--}}
                        {{--<th><i class="require">*</i>是否合格：</th>--}}
                        {{--<td><input type="radio" class="" name="status" value="1">合格 <input type="radio" class="" name="status" value="2" onchange="unqualified(this)">不合格</td>--}}
                    {{--</tr>--}}
                    <tr>
                        <th><i class="require">*</i>质检图片</th>
                        <td><input type="file" name="img"></td>
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