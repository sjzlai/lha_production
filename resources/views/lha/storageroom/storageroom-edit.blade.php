@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/storageRoom">角色管理</a> &raquo;角色编辑
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="" method="">
            <table class="add_tab">
                <tbody>
                <input type="hidden" id="did" value="{{$storageroom->id}}">
                    <tr>
                        <th><i class="require">*</i>库房名称：</th>
                        <td>
                            <input type="text" id="name" class="lg" name="store_name" value="{{$storageroom->store_name}}">
                            <p>请填写库房名称</p>
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

        var url = '/ad/storageRoom/';
        var did = $('#did').val();
        var token = "{{csrf_token()}}";

        $('#edit').click(function () {
            //询问框
            var name = $('#name').val();
            layer.confirm('您确认要修改此库房信息吗？', {
                btn: ['确认', '算了'] //按钮
            }, function () {
                $.ajax({
                    url :url+did,
                    type:"put",
                    dataType:"json",
                    data:{"_token":token,"store_name":name},
                    success:function (data) {
//                        console.log(data);
                        layer.msg(data.message);
                        window.location.href='/ad/storageRoom';
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