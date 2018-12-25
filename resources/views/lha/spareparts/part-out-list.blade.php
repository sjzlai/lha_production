@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="{{url('/ad/spare/out')}}">零部件列表</a> &raquo;
    </div>
    <!--面包屑导航 结束-->
    <!--快捷导航 开始-->
    <div class="result_content">
        <div class="short_wrap">
            <button id="b1" class="">出库所选零部件</button>
            <button id="b2" class="">查看所有出库单号</button>
        </div>
    </div>
    <script>
        $("#b1").click(function(){
            var number ='';
            
            $.each($('input:checkbox:checked'),function(k){
                //arr.push($(this).val());
                if(k== 0){
                    number = $(this).val();
                }else{
                    number += ','+$(this).val();
                }
            });
            if(number === ''){
                alert("请至少勾选一项");
            }else{
                window.location.href = "/ad/spare/outAll/" + number;
            }

        });
        $('#b2').click(function () {
            window.location.href="/ad/spare/outnum";
        })
    </script>
    <!--快捷导航 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
        </div>
        <div class="result_wrap">
            {{--已处理订单--}}
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%"></th>
                        {{--<th class="tc">排序</th>--}}
                        <th class="tc">ID</th>
                        <th>零部件名称</th>
                        <th>所在仓库</th>
                        <th>所在货架</th>
                        <th>数量</th>
                        <th>更新时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $value)
                        @if($value->part_number > 0)
                        <tr>
                            <td class="tc"><input type="checkbox" name="ckb" class="part" value="{{$value->id}}" ></td>
                            <td class="tc" >{{$value->id}}</td>
                            <td>{{$value->part_name}}</td>
                            <td>{{$value->store_name}}</td>
                            <td>{{$value->shelf_name}}</td>
                            <td>{{$value->part_number}}</td>
                            <td>{{$value->updated_at}}</td>
                            <td>
                                <a href="{{url('/ad/spare/outAll/'.$value->id)}}">出库</a>
                            </td>
                        </tr>
                        @endif
                    @endforeach
                </table>
                <div class="page_nav">
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

        //选择框
        $(function(){
            $('#check').click(function(){
                $('.list_tab').find('td').find('[type=checkbox]').prop('checked',$(this).prop('checked'));
            });
        })

    </script>



@endsection