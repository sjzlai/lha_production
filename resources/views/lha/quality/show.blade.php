@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 质检操作
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        <form action="{{url('ad/quality/store')}}" method="post" enctype="multipart/form-data">
            <table class="add_tab">
                {{csrf_field()}}
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>采购订单号：</th>

                        <td>
                            <select name="purchase_order_no">
                                <option value="{{$order_number}}">{{$order_number}}</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>库房：</th>
                        <td>
                            <input type="file" class="lg" name="picture">
                        </td>
                    </tr>
                    <tr>
                        <th>检验结果：</th>
                        <td>
                            <label for=""><input type="radio" checked="checked" name="status" value="1">合格</label>
                            <label for=""><input type="radio" name="status" value="2">不合格</label>
                        </td>
                    </tr>
                    <tr>
                        <th>操作人:</th>
                        <td>
                            <select name="user_id" id="">
                                <option value="{{session('user.id')}}">{{session('user.name')}}</option>
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
@endsection