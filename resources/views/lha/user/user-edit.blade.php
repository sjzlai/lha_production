@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/user">用户管理</a> &raquo;用户编辑
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="" method="">
            <table class="add_tab">
                <tbody>
                <input type="hidden" id="did" value="{{$user->id}}">
                    <tr>
                        <th><i class="require">*</i>用户名：</th>
                        <td>
                            <input type="text" id="username" class="lg" name="user_name" value="{{$user->user_name}}">
                            <p>请填写用户名 注意：英文</p>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>用户密码：</th>
                        <td>
                            <input type="password" id="password" class="lg" name="password" >
                            <p>请填写用户密码 注：全英文 6-16位</p>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>姓名：</th>
                        <td>
                            <input type="text" class="sg"  id="name" name="name" value="{{$user->name}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>手机号：</th>
                        <td>
                            <input type="number" class="lg" id="phone" name="phone" value="{{$user->phone}}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="button" id="edit" value="修改">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>

        var url = '/ad/user/';
        var did = $('#did').val();
        var token = "{{csrf_token()}}";

        $('#edit').click(function () {
            //询问框
            var username = $('#username').val();
            var password = $('#password').val();
            var name = $('#name').val();
            var phone = $('#phone').val();
            layer.confirm('您确认要修改此用户信息吗？', {
                btn: ['确认', '算了'] //按钮
            }, function () {
                $.ajax({
                    url :url+did,
                    type:"put",
                    dataType:"json",
                    data:{"_token":token,"user_name":username,"password":password,"name":name,"phone":phone},
                    success:function (data) {
                        console.log(data);
                        layer.msg(data.message);
                        window.location.href='/ad/user/';
                    },
                    error:function (data) {
                        layer.msg(data.message);
                    }
                })
            }, function () {
            });
        });

    </script>
@endsection