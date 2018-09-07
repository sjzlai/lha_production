@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="#">成品入库</a> &raquo;生产订单列表
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
        {{--已处理订单--}}
        <div class="tab_content">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name="" ></th>
                        {{--<th class="tc">排序</th>--}}
                        <th class="tc">ID</th>
                        <th>订单号</th>
                        <th>已生产成品数量</th>
                        {{--<th>收货地址</th>--}}
                        {{--<th>收货人姓名</th>--}}
                        {{--<th>收货人电话</th>--}}
                        {{--<th>收货日期</th>--}}
                        <th>备注信息</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                        {{--<th>已入库数量</th>--}}
                        <th>操作</th>
                    </tr>
                    @foreach($ordersEn as $orderEn)
                        <tr >
                            <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                            {{--<td class="tc">--}}
                            {{--<input type="text" name="ord[]" value="0">--}}
                            {{--</td>--}}
                            <td class="tc" id="did">{{$orderEn->id}}</td>
                            <td>{{$orderEn->order_no}}</td>
                            <td>{{$orderEn->goods_number}}</td>
                            {{--<td>{{$orderEn->address}}</td>--}}
                            {{--<td>{{$orderEn->consignee_name}}</td>--}}
                            {{--<td>{{$orderEn->phone}}</td>--}}
                            {{--<td>{{$orderEn->harvest_date}}</td>--}}
                            <td>{{$orderEn->remark}}</td>
                            <td>{{$orderEn->created_at}}</td>
                            <td>{{$orderEn->updated_at}}</td>
                            {{--<td><a class="num" >点击查看</a></td>--}}
                            <td>
                                <a href="/ad/productWarehousingView/{{$orderEn->order_no}}">入库</a>
                                <a href="/ad/productWarehousingRecord/{{$orderEn->order_no}}">入库记录查看</a>
                            </td>
                        </tr>
                    @endforeach
                </table>


                <div class="page_nav">
                    {{$ordersEn->links()}}
                </div>


            </div>
        </div>
        {{--已处理订单结束--}}

        </div>


    </div>



</form>
<!--搜索结果页面 列表 结束-->
<script>

   {{--var url = "/ad/warehousingNumber/{{$orderEn->order_no}}";--}}
   {{--var countNum = "{{$orderEn->goods_number}}";--}}
    {{--$('.num').click(function () {--}}
        {{--$.get(url,function (data) {--}}
            {{--// console.log(data);--}}
           {{--if (data.data){--}}
               {{--$(".num").html(data.data+'/'+countNum);--}}
           {{--}--}}
        {{--})--}}
    {{--})--}}
</script>



@endsection