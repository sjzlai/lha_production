@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/ProductOutStorageRecordOrderList">成品出库</a> &raquo;出库记录列表
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
                        {{--<th class="tc" width="5%"><input type="checkbox" name="" ></th>--}}
                        {{--<th class="tc">排序</th>--}}
                        <th class="tc">ID</th>
                        <th>订单号</th>
                        <th>出库数量</th>
                        <th>出库库房名</th>
                        <th>出库货架名</th>
                        <th>操作人姓名</th>
                        <th>操作人手机号</th>
                        {{--<th>快递方式</th>--}}
                        <th>快递单号</th>
                        <th>收货人姓名</th>
                        <th>收货人地址</th>
                        <th>收货人电话</th>
                        <th>发货地址</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>
                    @foreach($recordlists as $recordlist)
                        <tr >
                            {{--<td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>--}}
                            {{--<td class="tc">--}}
                            {{--<input type="text" name="ord[]" value="0">--}}
                            {{--</td>--}}
                            <td class="tc" id="did">{{$recordlist->id}}</td>
                            <td>{{$recordlist->order_no}}</td>
                            <td>{{$recordlist->number}}</td>
                            <td>{{$recordlist->store_name}}</td>
                            <td>{{$recordlist->shelf_name}}</td>
                            <td>{{$recordlist->name}}</td>
                            <td>{{$recordlist->phone}}</td>
                            <td>
                               {{-- @if($recordlist->logistics_mode ==1) 快递
                            @elseif($recordlist->logistics_mode ==2) 自提
                                @endif--}}
                                {{$recordlist->logistics_company}}
                            </td>
                            {{--<td>--}}
                            {{--@if($recordlist->logistics_company==1) 顺丰
                            @elseif($recordlist->logistics_company==2) 申通>
                            @elseif($recordlist->logistics_company==3) 中通
                            @elseif($recordlist->logistics_company==4) 圆通
                            @elseif($recordlist->logistics_company==5) EMS
                                @endif--}}
                            {{--</td>--}}
                            <td>{{$recordlist->consignee_name}}</td>
                            <td>{{$recordlist->hi_address}}</td>
                            <td>{{$recordlist->hi_phone}}</td>
                            <td>{{$recordlist->shipping_address}}</td>
                            <td>{{$recordlist->created_at}}</td>
                            <td>{{$recordlist->updated_at}}</td>

                        </tr>
                    @endforeach
                </table>


                <div class="page_nav">
                    {{$recordlists->links()}}
                </div>


            </div>
        </div>


        </div>


    </div>



</form>
<!--搜索结果页面 列表 结束-->



@endsection