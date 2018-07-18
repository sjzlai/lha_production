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
                <tr>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="请输入订单编号查询"></td>
                    <td><input type="submit" name="sub" value="查询" ></td>
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
                      <a href="{{asset('ad/purAdd')}}"><i class="fa fa-plus"></i>新增采购</a>
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
                        <th>库房</th>
                        <th>货架</th>
                        <th>订单详情查看</th>
                        <th>质检结果</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc">{{$v->put_storage_no}}</td>
                            <td>{{$v->purchase_order_no}}</td>
                            <td>{{$v->created_at}}</td>
                            <td style="color:red">{{$v->storageroom_id}}</td>
                            <td>{{$v->shelve_id}}</td>
                            <td>
                                <a  id="product_id" onclick="info({{$v->order_number}})">查看零件</a>
                            </td>
                            @if($v->status==1 ||$v->status==2)
                                <td>
                                    <a href="{{url('ad/quality/img/'.$v->order_number)}}" style="color: green" >查看质检结果</a>
                                </td>
                            @else
                                <td>
                                    <a href="{{url('ad/quality/show/'.$v->order_number)}}">上传质检结果</a>
                                </td>
                            @endif
                            <input type="hidden" name="order_number" id="order_number" value="{{$v->order_number}}">
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