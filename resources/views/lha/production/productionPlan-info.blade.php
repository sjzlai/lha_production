@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo;  <a href="/ad/productionOrder">生产订单</a> &raquo;生产计划详情
</div>
<!--面包屑导航 结束-->

<!--结果页快捷搜索框 开始-->
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
        <div class="result_title">
            <h3>成品相关信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>Id</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['id']}}</span>
                </li>
                <li>
                    <label>成品名称</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['product_name']}}</span>
                </li>
                <li>
{{--                    <label>成品标识码范围</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['product_code']}} 后五位至 {{(substr($productionPlanInfo['product']['product_code'],'-5')+$productionPlanInfo['product']['output']-1)}}</span>--}}
                </li>
                <li>
                    <label>成品批号</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['product_batch_number']}}</span>
                </li>
                <li>
                    <label>成品规格</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['product_spec']}}</span>
                </li>
                <li>
                    <label>记录人姓名</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['name']}}</span>
                </li>
                <li>
                    <label>记录人手机号</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['phone']}}</span>
                </li>
                <li>
                    <label>生产订单号</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['order_no']}}</span>
                </li>
                <li>
                    <label>工厂订单号</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['factory_no']}}</span>
                </li>
                <li>
                    <label>预计完工日期</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['production_plan_date']}}</span>
                </li>
                <li>
                    <label>生产数量</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['output']}}</span>
                </li>
                <li>
                    <label>备注信息</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['remark']}}</span>
                </li>
                <li>
                    <label>创建时间</label><span  style="font-weight:bold ">{{$productionPlanInfo['product']['created_at']}}</span>
                </li>
                <li>
                    <label>修改时间</label><span style="font-weight:bold ">{{$productionPlanInfo['product']['updated_at']}}</span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>零部件清单</h3>
        </div>
        <div class="result_content">
            <ul>
                @foreach($productionPlanInfo['part'] as $partInfo)
                <li>
                    <label >零部件名称：</label><span style="font-weight:bold ">{{$partInfo['part_name']}}</span> <label>零部件生产商：</label><span  style="font-weight:bold ">{{$partInfo['manufacturer']}}</span>  <label>零部件批号：</label><span  style="font-weight:bold ">{{$partInfo['batch_number']}}</span>  <label>零部件型号：</label><span  style="font-weight:bold ">{{$partInfo['model']}}</span>
                </li>
                <li>
                    <label>零部件数量：</label><span  style="font-weight:bold ">{{$partInfo['part_number']}}</span>
                </li>

                <li>
                    <label for=""></label>
                </li>

            @endforeach
            </ul>
            <ul>
                {{--<p>{{$productionPlanInfo['product']}}</p>--}}
                <li style="padding-left: 150px"><input type="button" id="url" value="打印"> <input type="button" onclick="window.location.href = '/ad/productExcelDown/{{$productionPlanInfo['product']['order_no']}}'" value="导出成品记录Excel"> <input type="button" onclick="window.location.href = '/ad/partExcelDown/{{$productionPlanInfo['product']['order_no']}}'" value="导出零部件清单Excel"></li>
            </ul>

        </div>
    </div>


            </div>



    </div>



</form>
<!--搜索结果页面 列表 结束-->
<script>
    var url = '/ad/production/';
    var did = $('#did').html();
    var token = "{{csrf_token()}}";
    $('#url').click(function () {
       window.print();
    });
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