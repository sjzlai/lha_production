@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/productionOrder">生产订单</a> &raquo;生产订单列表
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="/ad/productionFuzzySearch" method="post">
            {{csrf_field()}}
            <table class="search_tab">
                <th width="70">关键字:</th>
                <td><input type="text" name="keyword" placeholder="输入订单号查询"></td>
                <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
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
            <ul class="tab_title">
                <a href="{{url('ad/productionOrders')}}"> <li class="active">新订单</li></a>
                <a href="{{url('ad/productionOrder')}}"> <li>生产订单</li></a>
            </ul>
            {{--未处理订单--}}
            <div class="tab_content">
                <div class="result_content">
                    <table class="list_tab">
                        <tr>
                            <th class="tc" width="5%"><input type="checkbox" name="" ></th>
                            {{--<th class="tc">排序</th>--}}
                            <th class="tc">ID</th>
                            <th>订单号</th>
                            <th>采购申请成品数量</th>
                            <th>收货地址</th>
                            <th>收货人姓名</th>
                            <th>收货人电话</th>
                            <th>收货日期</th>
                            <th>备注信息</th>
                            <th>创建时间</th>
                            <th>更新时间</th>
                            <th>处理状态</th>
                            <th>操作</th>
                        </tr>
                        @foreach($ordersUn as $orderUn)
                            <tr >
                                <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                                {{--<td class="tc">--}}
                                {{--<input type="text" name="ord[]" value="0">--}}
                                {{--</td>--}}
                                <td class="tc" id="did">{{$orderUn->id}}</td>
                                <td>{{$orderUn->order_no}}</td>
                                <td>{{$orderUn->goods_number}}</td>
                                <td>{{$orderUn->address}}</td>
                                <td>{{$orderUn->consignee_name}}</td>
                                <td>{{$orderUn->phone}}</td>
                                <td>{{$orderUn->harvest_date}}</td>
                                <td>{{$orderUn->remark}}</td>
                                <td>{{$orderUn->created_at}}</td>
                                <td>{{$orderUn->updated_at}}</td>
                                <td>{{$orderUn->status==2 ? '未处理': '已处理'}}</td>
                                <td>
                                    <a id="one" href="/ad/productionHandle/{{$orderUn->id}}">处理此订单</a>
                                </td>
                            </tr>
                        @endforeach

                    </table>
                    <div class="page_nav result_content">
                        {{$ordersUn->links()}}
                    </div>


                </div>
            </div>
            {{--未处理订单结束--}}
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