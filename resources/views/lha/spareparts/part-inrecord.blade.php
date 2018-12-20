@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="#">零部件入库列表</a> &raquo;
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="{{url('ad/quality/search')}}" method="post">
            <table class="search_tab">
                {{csrf_field()}}
               {{-- <tr>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="请输入订单编号查询"></td>
                    <td><input type="submit" name="sub" value="查询" ></td>
                </tr>--}}
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
                      <a href="{{asset('ad/spare')}}"><i class="fa ">&raquo; </i>返回入库列表</a>
                  </div>
              </div>

              <!--快捷导航 结束-->
          </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">入库编号</th>
                        <th>采购订单号</th>
                        <th>入库时间</th>
                        {{--<th>库房</th>--}}
                        {{--<th>货架</th>--}}
                        <th>入库详情查看</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">{{$v->put_storage_no}}</td>
                            <td>{{$v->purchase_order_no}}</td>
                            <td>{{$v->created_at}}</td>
                            {{--<td style="color:red">{{$v->storageroom_id}}</td>--}}
                            {{--<td>{{$v->shelve_id}}</td>--}}
                            <td>
                                <a  class="product_id" onclick="info({{$v->put_storage_no}})">查看零件</a>
                            </td>
                            <input type="hidden" name="order_number" id="order_number" value="">
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
            $.post("{{url('ad/spare/WarehousingRecord')}}",{
                'id':id,
                '_token':'{{csrf_token()}}'
            },function (data) {
                var da =data.data;
                console.log(data.data);
                var tr = '';
                da.forEach(function (value) {
                    tr += '<tr xmlns="http://www.w3.org/1999/html"><td>' + value.part_name + '</td><td>'+value.part_number+'</td><td>'+value.batch_number+'</td><td>'+value.model+'</td></tr>';
                })
                var content = "<table class='list_tab'><thead><th>零部件名称</th><th>数量</th><th>生产批号</th><th>型号</th></thead><tbody>" + tr + "</tbody> </table>"
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