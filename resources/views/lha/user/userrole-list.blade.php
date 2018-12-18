@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/user">用户管理</a> &raquo;用户角色列表
</div>
<!--面包屑导航 结束-->

{{--<!--结果页快捷搜索框 开始-->--}}
{{--<div class="search_wrap">--}}
    {{--<form action="/ad/user/fuzzySearch" method="post">--}}
        {{--{{csrf_field()}}--}}
        {{--<table class="search_tab">--}}
                {{--<th width="70">关键字:</th>--}}
                {{--<td><input type="text" name="keyword" placeholder="输入用户名称查询"></td>--}}
                {{--<td><input type="submit" name="sub" value="查询"></td>--}}
            {{--</tr>--}}
        {{--</table>--}}
    {{--</form>--}}
{{--</div>--}}
{{--<!--结果页快捷搜索框 结束-->--}}

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                <!--<a href="/ad/addRole/{{$userid}}" ><i class="fa fa-plus"></i>给此用户新增角色</a>-->
                <a href="/ad/roleListInAddView/{{$userid}}" ><i class="fa fa-plus"></i>给此用户分配已有角色</a>
                {{--<a href="" id="delAll"><i class="fa fa-recycle"></i>批量删除</a>--}}
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%"><input type="checkbox" name="" ></th>
                    {{--<th class="tc">排序</th>--}}
                    {{--<th class="tc">ID</th>--}}
                    <th>角色名称</th>
                    <th>操作</th>
                </tr>

                @for($i=0;$i<count($roles);$i++)
                <tr >
                    <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                    {{--<td class="tc">--}}
                        {{--<input type="text" name="ord[]" value="0">--}}
                    {{--</td>--}}
                    <td>
                        {{$roles[$i]}}
                    </td>
                    <td>
                        <a href="/ad/removeRole/{{$userid}}/{{$roles[$i]}}" id="del">撤销此用户的角色</a>
                    </td>
                </tr>
                 @endfor
            </table>


            <div class="page_nav">
                {{--{{$users->links()}}--}}
            </div>

        </div>
    </div>
</form>
<iframe src="addRole/" frameborder="0" hidden>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo;  <a href="#">用户管理</a> &raquo;用户添加
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
</iframe>
<!--搜索结果页面 列表 结束-->
<script>

    var url = '/ad/user/';
    var did = $('#did').html();
    var token = "{{csrf_token()}}";

    $('#del').click(function () {
        //询问框
        layer.confirm('您确认要删除此用户吗？', {
            btn: ['确认'] //按钮
        }, function () {
            $.ajax({
                url :url+did,
                type:"DELETE",
                dataType:"json",
                data:{"_token":token},
                success:function (data) {
                    layer.msg(data.message);
                   window.location.reload();
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