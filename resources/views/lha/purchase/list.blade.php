@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 添加商品
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    {{--<th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>--}}
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
                    <a href="{{asset('ad/purAdd')}}"><i class="fa fa-plus"></i>新增采购</a>
                    <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
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
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                        <tr>
                            <td class="tc"><input type="checkbox" name="id[]" value="59"></td>
                            <td class="tc">{{$v->order_number}}</td>
                            <td>{{$v->user_id}}</td>
                            <td>{{$v->created_at}}</td>
                            <td>{{$v->updated_at}}</td>
                            <input type="hidden" name="order_number" id="order_number" value="{{$v->order_number}}">
                            <td>
                                <a href="#">修改</a>
                                <a href="#">删除</a>
                                <a  id="product_id" onclick="info()">查看零件</a>
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
        function info() {
            var id = document.getElementById("order_number").value;
           $.post("{{url('ad/info')}}",{
               'id':id,
               '_token':'{{csrf_token()}}'
           },function (data) {
               var da =data.data;
               var tr = '';
               da.forEach(function (value) {
                   if(value.part_id=='1')
                       value.part_id="吹嘴";
                   if(value.part_id=='2')
                       value.part_id="笛管";
                   if(value.part_id=='3')
                       value.part_id="哨片";
                   if(value.part_id=='4')
                       value.part_id="垫片";
                   if(value.part_id=='5')
                       value.part_id="肺笛袋";
                   if(value.part_id=='6')
                       value.part_id="哨片袋";
                   if(value.part_id=='7')
                       value.part_id="皮筋";
                   if(value.product=='1')
                       value.product="美国医学声学公司";
                   tr += '<tr><td>' + value.part_id + '</td><td>'+value.part_number+'</td><td>'+value.product+'</td></tr>';

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