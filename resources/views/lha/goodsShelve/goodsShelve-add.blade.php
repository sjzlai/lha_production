@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/storageRoom">库房管理</a> &raquo; <a href="/ad/storageRoom">库房列表</a>&raquo; 新增货架
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/goodsShelve" method="post">
            {{csrf_field()}}
            <input type="hidden" name="id" value="{{$id}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>货架名称：</th>
                        <td>
                            <input type="text" class="lg" name="storage_name">
                            <p>请填写货架名称 </p>
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