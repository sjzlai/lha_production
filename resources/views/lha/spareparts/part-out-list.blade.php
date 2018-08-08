@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/production">零部件列表</a> &raquo;
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    {{--<div class="search_wrap">--}}
    {{--<form action="/ad/productionFuzzySearch" method="post">--}}
    {{--{{csrf_field()}}--}}
    {{--<table class="search_tab">--}}
    {{--<th width="70">关键字:</th>--}}
    {{--<td><input type="text" name="keyword" placeholder="输入订单号查询"></td>--}}
    {{--<td><input type="submit" name="sub" value="查询"></td>--}}
    {{--</tr>--}}
    {{--</table>--}}
    {{--</form>--}}
    {{--</div>--}}
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="#"><i class="fa fa-plus"></i>出库所有零部件</a>
                    {{--<a href="" id="delAll"><i class="fa fa-recycle"></i>批量删除</a>--}}
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            {{--已处理订单--}}
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name="id[]" ></th>
                        {{--<th class="tc">排序</th>--}}
                        <th class="tc">ID</th>
                        <th>零部件名称</th>
                        <th>数量</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $value)
                        <tr >
                            <td class="tc"><input type="checkbox" name="id[]" value="{{$value->part_id}}" ></td>
                            <td class="tc" id="did">{{$value->id}}</td>
                            <td>{{$value->part_name}}</td>
                            <td>{{$value->part_number}}</td>
                            <td>{{$value->updated_at}}</td>
                            <td>
                                <a href="{{url('ad/spare/outInfo/'.$value->part_id)}}">出库</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_nav">
                </div>

            </div>
            {{--已处理订单结束--}}



        </div>



    </form>
    <!--搜索结果页面 列表 结束-->
    <script>

        var url = '/ad/production/';
        var did = $('#did').html();
        var token = "{{csrf_token()}}";

        $('#del').click(function () {
            //询问框
            layer.confirm('您确认要删除此库房吗？', {
                btn: ['确认', '算了'] //按钮
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