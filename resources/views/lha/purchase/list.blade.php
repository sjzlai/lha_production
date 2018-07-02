@extends('layouts.admin')
@section('content')
    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="{{url('ad/purchase/search')}}" method="post">
            <table class="search_tab">
                {{csrf_field()}}
                <tr>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
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
                    <a href="{{asset('ad/purchase/purAdd')}}"><i class="fa fa-plus"></i>新增采购</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"><input type="checkbox" name=""></th>
                        <th class="tc">订单编号</th>
                        <th>采购申请人</th>
                        <th>申请时间</th>
                        <th>到货时间</th>
                        <th>仓库状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                            <td class="tc">{{$v->order_number}}</td>
                            <td>{{$v->name}}</td>
                            <td>{{$v->created_at}}</td>
                            <td style="color:red">{{$v->delivery_time}}</td>
                            @if($v->warehousing == 0)
                            <td>未入库</td>
                            @elseif($v->warehousing ==1)
                                <td>已入库</td>
                            @endif
                            <input type="hidden" name="order_number" id="order_number" value="{{$v->order_number}}">
                            <td>
                                <a href="{{asset('ad/purchase/edit/'.$v->order_number)}}">修改</a>
                                <a href="{{asset('ad/purchase/delete/'.$v->order_number)}}">删除</a>
                                <a  id="product_id" onclick="info({{$v->order_number}})">查看零件</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <div class="page_nav">
                    <div class="page_list">
                        <ul>
                            {!! $data->links() !!}
                        </ul>
                    </div>
                </div>
            </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function info(id) {
           $.post("{{url('ad/purchase/info')}}",{
               'id':id,
               '_token':'{{csrf_token()}}'
           },function (data) {

               var da =data.data;
               var tr = '';
               da.forEach(function (value) {
                   tr += '<tr><td>' + value.part_name + '</td><td>'+value.part_number+'</td><td>'+value.manufacturer+'</td></tr>';

               })
               var content = "<table class='list_tab'><thead><th>零部件名称</th><th>数量</th><th>生产厂商</th></thead><tbody>" + tr + "</tbody> </table>"
               layer.open({
                   title: '零部件信息',
                    maxmin:true,
                   area:['800px,500px'],
                   content
               });
           })
        }
    </script>
@endsection