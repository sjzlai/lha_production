@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/user">用户管理</a> &raquo; <a
                href="#">用户角色列表</a>&raquo;  <a href="#">为用户新增角色</a>
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/allotRole" method="post">
            {{csrf_field()}}
            <input type="hidden"  name="userid" value="{{$userid}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>角色名：</th>
                        <td>
                            <input type="text" class="sg" name="roleName">
                            <p>请填写角色名 如角色不存在会自动创建 </p>
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