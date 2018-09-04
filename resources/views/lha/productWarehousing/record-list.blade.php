@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/productWarehousingOrderList">成品入库</a> &raquo;入库记录列表
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
                        <th>入库数量</th>
                        <th>存放库房名</th>
                        <th>存放货架名</th>
                        <th>操作人姓名</th>
                        <th>操作人手机号</th>
                        <th>备注信息</th>
                        <th>创建时间</th>
                        <th>更新时间</th>
                    </tr>
                    @foreach($records as $record)
                        <tr >
                            <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                            {{--<td class="tc">--}}
                            {{--<input type="text" name="ord[]" value="0">--}}
                            {{--</td>--}}
                            <td class="tc" id="did">{{$record->id}}</td>
                            <td>{{$record->order_no}}</td>
                            <td>{{$record->number}}</td>
                            <td>{{$record->store_name}}</td>
                            <td>{{$record->shelf_name}}</td>
                            <td>{{$record->name}}</td>
                            <td>{{$record->phone}}</td>
                            <td>{{$record->remark}}</td>
                            <td>{{$record->created_at}}</td>
                            <td>{{$record->updated_at}}</td>

                        </tr>
                    @endforeach
                </table>


                <div class="page_nav">
                    {{$records->links()}}
                </div>


            </div>
        </div>


        </div>


    </div>



</form>
<!--搜索结果页面 列表 结束-->



@endsection