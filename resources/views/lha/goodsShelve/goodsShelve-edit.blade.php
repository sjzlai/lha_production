@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/storageRoom">库房管理</a> &raquo; <a href="/ad/storageRoom">库房列表</a>&raquo; 修改货架
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="" method="">
            <table class="add_tab">
                <tbody>
                <input type="hidden" id="did" value="{{$goodsShelve->id}}">
                <input type="hidden" id="storeId" value="{{$goodsShelve->storageroom_id}}">
                    <tr>
                        <th><i class="require">*</i>货架名称：</th>
                        <td>
                            <input type="text" id="name" class="lg" name="shelf_name" value="{{$goodsShelve->shelf_name}}">
                            <p>请填写货架名称</p>
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

        var url = '/ad/goodsShelve/';
        var did = $('#did').val();
        var token = "{{csrf_token()}}";
        var shelfId = $('#storeId').val();
        $('#edit').click(function () {
            //询问框
            var name = $('#name').val();

            layer.confirm('您确认要修改此货架名称吗？', {
                btn: ['确认', '算了'] //按钮
            }, function () {
                $.ajax({
                    url :url+did,
                    type:"put",
                    dataType:"json",
                    data:{"_token":token,"shelf_name":name},
                    success:function (data) {
//                        console.log(data);
                        layer.msg(data.message);
                        console.log("/ad/goodsShelve/"+shelfId);
                        window.location.href='/ad/goodsShelve/'+shelfId;
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