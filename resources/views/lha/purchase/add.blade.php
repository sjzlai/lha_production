@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{asset('ad/pur')}}">采购列表</a> &raquo; 新增采购
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
{{--	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>--}}
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('ad/purchase/purtoadd')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>材料名称：</th>
                    <td>
                        <p>填写采购数量</p>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>订单号：</th>
                    <td>
                        <input type="text" class="" placeholder="订单号大于等于1开头" value="{{old('order_number')}}" name="order_number">
                    </td>
                </tr>
                    <tr>
                        <th><i class="require">*</i>吹嘴：</th>
                        <td>
                            <input type="text" class="" name="1[part_number]" value="{{old('1[part_number]')}}">个&nbsp;&nbsp;&nbsp;
                            生产商:
                            <select name="1[manufacturer]" id="">
                                <option value="1">美国医学声学公司</option>
                            </select>
                            <input type="hidden" name="1[part_name]" value="吹嘴">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>笛管：</th>
                        <td>
                            <input type="text" class="" name="2[part_number]">个&nbsp;&nbsp;&nbsp;
                            生产商:
                            <select name="2[manufacturer]" id="">
                                <option value="1">美国医学声学公司</option>
                            </select>
                            <input type="hidden" name="2[part_name]" value="笛管">
                        </td>
                    </tr>
                <tr>
                    <th><i class="require">*</i>哨片：</th>
                    <td>
                        <input type="text" class="" name="3[part_number]">片&nbsp;&nbsp;&nbsp;
                        生产商:
                        <select name="3[manufacturer]" id="">
                            <option value="1">美国医学声学公司</option>
                        </select>
                        <input type="hidden" name="3[part_name]" value="哨片">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>垫片：</th>
                    <td>
                        <input type="text" class="" name="4[part_number]">片&nbsp;&nbsp;&nbsp;
                        生产商:
                        <select name="4[manufacturer]" id="">
                            <option value="1">美国医学声学公司</option>
                        </select>
                        <input type="hidden" name="4[part_name]" value="垫片">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>肺笛袋：</th>
                    <td>
                        <input type="text" class="" name="5[part_number]">个&nbsp;&nbsp;&nbsp;
                        生产商:
                        <select name="5[manufacturer]" id="">
                            <option value="1">美国医学声学公司</option>
                        </select>
                        <input type="hidden" name="5[part_name]" value="肺笛袋">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>哨片袋：</th>
                    <td>
                        <input type="text" class="" name="6[part_number]">个&nbsp;&nbsp;&nbsp;
                        生产商:
                        <select name="6[manufacturer]" id="">
                            <option value="1">美国医学声学公司</option>
                        </select>
                        <input type="hidden" name="6[part_name]" value="哨片袋">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>皮筋：</th>
                    <td>
                        <input type="text" class="" name="7[part_number]">个&nbsp;&nbsp;&nbsp;
                        生产商:
                        <select name="7[manufacturer]" id="">
                            <option value="1">美国医学声学公司</option>
                        </select>
                        <input type="hidden" name="7[part_name]" value="皮筋">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>预期到货时间：</th>
                    <td>
                        <input type="text" name="delivery_time" class="demo-input" placeholder="请选择日期" id="test1">
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>申请人：</th>
                    <td>
                        <select name="user_id" id="">
                            <option value="{{session('user.id')}}">{{session('user.name')}}</option>
                        </select>
                    </td>
                </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
    <script>
        lay('#version').html('-v'+ laydate.v);
        //执行一个laydate实例
        laydate.render({
            elem: '#test1' //指定元素
        });
    </script>
@endsection