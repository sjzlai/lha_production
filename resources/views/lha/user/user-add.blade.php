@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/user">用户管理</a> &raquo;用户添加
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/user" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>用户名：</th>
                        <td>
                            <input type="text" class="sg" name="user_name">
                            <p>请填写用户名 注：全英文</p>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>用户密码：</th>
                        <td>
                            <input type="password" class="lg" name="password">
                            <p>请填写用户密码 注：全英文 6-16位</p>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>姓名：</th>
                        <td>
                            <input type="text" class="sg" name="name">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>手机号：</th>
                        <td>
                            <input type="number" class="lg" name="phone">
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