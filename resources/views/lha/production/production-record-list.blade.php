@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/productionOrder">生产订单</a> &raquo;生产计划列表
</div>
<!--面包屑导航 结束-->

{{--<!--结果页快捷搜索框 开始-->--}}
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
{{--<!--结果页快捷搜索框 结束-->--}}

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_content">
            <div class="short_wrap">
                {{--<a href="/ad/production/create"><i class="fa fa-plus"></i>新增库房</a>--}}
                {{--<a href="" id="delAll"><i class="fa fa-recycle"></i>批量删除</a>--}}
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>
        <div class="tab_content">
                <div class="result_content">
                    <table class="list_tab">
                        <tr>
                            <th class="tc" width="5%"><input type="checkbox" name="" ></th>
                            {{--<th class="tc">排序</th>--}}
                            <th class="tc">ID</th>
                            <th>订单号</th>
                            <th>完成生产量</th>
                            <th>成品批号</th>
                            <th>成品id范围</th>
                            <th>成品id范围</th>
                            <th>员工姓名</th>
                            <th>员工手机号</th>
                            <th>生产日期</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                        </tr>
                        @foreach($recordLists as $recordList)
                            <tr >
                                <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                                {{--<td class="tc">--}}
                                {{--<input type="text" name="ord[]" value="0">--}}
                                {{--</td>--}}
                                <td class="tc" id="did">{{$recordList->id}}</td>
                                <td>{{$recordList->order_no}}</td>
                                <td>{{$recordList->number}}</td>
                                <td>{{$recordList->product_batch_number}}</td>
                                <td>{{$recordList->product_code_range_up}}</td>
                                <td>{{$recordList->product_code_range_down}}</td>
                                <td>{{$recordList->name}}</td>
                                <td>{{$recordList->phone}}</td>
                                <td>{{$recordList->product_date}}</td>
                                <td>{{$recordList->created_at}}</td>
                                <td>{{$recordList->updated_at}}</td>

                            </tr>
                        @endforeach
                    </table>


                    <div class="page_nav">
                        {{$recordLists->links()}}
                    </div>


                </div>
        </div>


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