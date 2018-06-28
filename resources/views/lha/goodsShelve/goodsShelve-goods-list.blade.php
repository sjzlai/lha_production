@extends('layouts.admin')
@section('content')
<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/storageRoom">库房管理</a> &raquo; <a href="/ad/storageRoom">库管列表</a> &raquo;  <a href="#">货架列表</a>  &raquo;  <a href="#">货物列表</a>
</div>

<!--面包屑导航 结束-->

<!--结果页快捷搜索框 开始-->
<div class="search_wrap">
    <form action="/ad/goodsList/goodsFuzzySearch" method="post">
        {{csrf_field()}}
        <input type="hidden" name="goodsShelveId" value="{{$goodsShelveName->id}}">
        <table class="search_tab">
                <th width="70">关键字:</th>
                <td><input type="text" name="keyword" placeholder="输入货物名称查询"></td>
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
                {{--<a href="/ad/storageRoom/create"><i class="fa fa-plus"></i>新增货架</a>--}}
                {{--<a href="" id="delAll"><i class="fa fa-recycle"></i>批量删除</a>--}}
                <p>货架名称：{{$goodsShelveName->shelf_name}}</p>
            </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                    <th class="tc" width="5%"><input type="checkbox" name="" ></th>
                    {{--<th class="tc">排序</th>--}}
                    <th class="tc">ID</th>
                    <th>零部件名称</th>
                    <th>零部件数量</th>
                    <th>创建时间</th>
                    <th>更新时间</th>
                    {{--<th>操作</th>--}}
                </tr>
                @foreach($goodsLists as $goodsList)
                <tr >
                    <td class="tc" id="aa"><input type="checkbox" name="id[]"  ></td>
                    {{--<td class="tc">--}}
                        {{--<input type="text" name="ord[]" value="0">--}}
                    {{--</td>--}}
                    <td class="tc" id="did">{{$goodsList->id}}</td>
                    <td>
                        {{--{{$goodsList->part_name}}--}}
                        @if($goodsList->part_name == 1)
                            成品
                        @elseif($goodsList->part_name == 2)
                            笛管
                        @elseif($goodsList->part_name == 3)
                            哨片
                        @endif
                    </td>
                    <td>{{$goodsList->part_number}}</td>
                    <td>{{$goodsList->created_at}}</td>
                    <td>{{$goodsList->updated_at}}</td>
                    {{--<td>--}}
                        {{--<a href="/ad/goodsShelve/{{$goodsList->id}}/edit">货物列表</a>--}}
                        {{--<a href="/ad/goodsShelve/{{$goodsList->id}}/edit">修改</a>--}}
                        {{--<a href="#" id="del">删除</a>--}}
                    {{--</td>--}}
                </tr>
            @endforeach
            </table>


            <div class="page_nav">
                {{$goodsLists->links()}}
            </div>


        </div>
    </div>
</form>
<!--搜索结果页面 列表 结束-->
<script>

    var url = '/ad/goodsShelve/';
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