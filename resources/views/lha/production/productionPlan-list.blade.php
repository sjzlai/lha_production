@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/production">生产订单</a> &raquo;生产计划列表
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
                {{--<a href="/ad/production/create"><i class="fa fa-plus"></i>新增库房</a>--}}
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
                        <th class="tc" width="5%"><input type="checkbox" name="" ></th>
                        {{--<th class="tc">排序</th>--}}
                        <th class="tc">ID</th>
                        <th>生产订单号</th>
                        <th>该生产量预计完工时间</th>
                        <th>生产量</th>
                        <th>是否完成计划</th>
                        <th>备注</th>
                        <th>记录人姓名</th>
                        <th>记录人手机号</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($productionPlans as $productionPlan)
                        <tr >
                            <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                            {{--<td class="tc">--}}
                            {{--<input type="text" name="ord[]" value="0">--}}
                            {{--</td>--}}
                            <td class="tc" id="did">{{$productionPlan->id}}</td>
                            <td>{{$productionPlan->order_no}}</td>
                            <td>{{$productionPlan->production_plan_date}}</td>
                            <td>{{$productionPlan->output}}</td>
                            <td>{{$productionPlan->is_finish ==1 ? '已完成':'未完成'}}</td>
                            <td>{{$productionPlan->remark}}</td>
                            <td>{{$productionPlan->name}}</td>
                            <td>{{$productionPlan->phone}}</td>
                            <td>{{$productionPlan->created_at}}</td>
                            <td>{{$productionPlan->updated_at}}</td>
                            <td>
                                @if($productionPlan->is_finish ==2)
                                <a  href="/ad/productionPlanFinish/{{$productionPlan->order_no}}">已完成该计划</a>
                                @else
                                计划已完成
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_nav">
                    {{$productionPlans->links()}}
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