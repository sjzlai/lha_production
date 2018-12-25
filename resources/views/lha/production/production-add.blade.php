@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productionOrder">生产订单</a> &raquo;生产计划添加
    </div>
    <!--面包屑导航 结束-->
    <div class="result_wrap">
        <form action="/ad/productionPlan" method="post">
            {{csrf_field()}}

            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>订单号：</th>
                        <input type="hidden" name="order_no" value="{{$orderId}}">
                        <td>{{$orderId}}</td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>工厂订单号</th>
                        <td>
                            <input type="text" name="factory_no"   placeholder="请输入工厂单号" style="width: 210px;">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>每日生产量：</th>
                        <td><input type="number" class="lg" name="output" style="width: 220px;height: 25px;"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>该生产量预计完工时间</th>
                        <td><input type="date" name="production_plan_date" style="width: 220px;"></td>
                    </tr>
                   <tr>
                       <th><i class="require">*</i>备注：</th>
                       <td><textarea name="remark" id="" cols="30" rows="10"></textarea></td>
                   </tr>
                    <tr>
                        <th>零部件信息</th>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>吹嘴</th>
                        <td style="display: block">
                            <select name="1[part_id][]" id="">
                                @foreach($partInfosCZ as $partInfoCZ)
                                    <option value="{{$partInfoCZ->id}}">零部件名称：{{$partInfoCZ->part_name}} 生产商：{{$partInfoCZ->manufacturer}} 生产批号：{{$partInfoCZ->batch_number}} 型号：{{$partInfoCZ->model}}数量:{{$partInfoCZ->part_number}}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;&nbsp;数量<input type="number" name="1[part_number][]" style="width: 80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,1)" value="+">
                            <input type="button" onclick="addRemove('remove', this,1)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>笛管</th>
                        <td style="display: block"><select name="2[part_id][]" id="">
                                @foreach($partInfosDG as $partInfoDG)
                                    <option value="{{$partInfoDG->id}}">零部件名称：{{$partInfoDG->part_name}} 生产商：{{$partInfoDG->manufacturer}} 生产批号：{{$partInfoDG->batch_number}} 型号：{{$partInfoDG->model}}数量:{{$partInfoDG->part_number}}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;&nbsp;数量<input type="number" name="2[part_number][]" style="width: 80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,2)" value="+">
                            <input type="button" onclick="addRemove('remove', this,2)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>哨片</th>
                        <td style="display: block"><select name="3[part_id][]" id="">
                                @foreach($partInfosSP as $partInfoSP)
                                    <option value="{{$partInfoSP->id}}">零部件名称：{{$partInfoSP->part_name}} 生产商：{{$partInfoSP->manufacturer}} 生产批号：{{$partInfoSP->batch_number}} 型号：{{$partInfoSP->model}}数量:{{$partInfoSP->part_number}}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;&nbsp;数量<input type="number" name="3[part_number][]" style="width:80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,3)" value="+">
                            <input type="button" onclick="addRemove('remove', this,3)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>垫片</th>
                        <td style="display: block"><select name="4[part_id][]" id="">
                                @foreach($partInfosDP as $partInfoDP)
                                    <option value="{{$partInfoDP->id}}">零部件名称：{{$partInfoDP->part_name}} 生产商：{{$partInfoDP->manufacturer}} 生产批号：{{$partInfoDP->batch_number}} 型号：{{$partInfoDP->model}}数量:{{$partInfoDP->part_number}}</option>
                                @endforeach
                            </select>&nbsp;&nbsp;&nbsp;数量<input type="number" name="4[part_number][]" style="width: 80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,4)" value="+">
                            <input type="button" onclick="addRemove('remove', this,4)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>肺笛袋</th>
                        <td style="display: block"><select name="5[part_id][]"  id="">
                                @foreach($partInfosFDD as $partInfoFDD)
                                    <option value="{{$partInfoFDD->id}}">零部件名称：{{$partInfoFDD->part_name}} 生产商：{{$partInfoFDD->manufacturer}} 生产批号：{{$partInfoFDD->batch_number}} 型号：{{$partInfoFDD->model}}数量:{{$partInfoFDD->part_number}}</option>
                                @endforeach
                            </select>&nbsp;&nbsp;&nbsp;数量<input type="number" name="5[part_number][]" style="width:80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,5)" value="+">
                            <input type="button" onclick="addRemove('remove', this,5)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>哨片袋</th>
                        <td style="display: block"><select name="6[part_id][]" id="">
                                @foreach($partInfosSPD as $partInfoSPD)
                                    <option value="{{$partInfoSPD->id}}">零部件名称：{{$partInfoSPD->part_name}} 生产商：{{$partInfoSPD->manufacturer}} 生产批号：{{$partInfoSPD->batch_number}} 型号：{{$partInfoSPD->model}}数量:{{$partInfoSPD->part_number}}</option>
                                @endforeach
                            </select>&nbsp;&nbsp;&nbsp;数量<input type="number" name="6[part_number][]" style="width:80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,6)" value="+">
                            <input type="button" onclick="addRemove('remove', this,6)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>皮筋</th>
                        <td style="display: block"><select name="7[part_id][]" id="">
                                @foreach($partInfosPJ as $partInfoPJ)
                                    <option value="{{$partInfoPJ->id}}">零部件名称：{{$partInfoPJ->part_name}} 生产商：{{$partInfoPJ->manufacturer}} 生产批号：{{$partInfoPJ->batch_number}} 型号：{{$partInfoPJ->model}}数量:{{$partInfoPJ->part_number}}</option>
                                @endforeach
                            </select>
                            &nbsp;&nbsp;&nbsp;数量<input type="number" name="7[part_number][]" style="width: 80px;height: 25px;">
                            <input type="button"   onclick="addRemove('add', this,7)" value="+">
                            <input type="button" onclick="addRemove('remove', this,7)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th>成品信息</th>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>成品名称</th>
                        <td>
                            <input type="text" name="product_name" placeholder="请输入成品名称">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>成品批号</th>
                        <td>
                            <input type="text" name="product_batch_number" placeholder="请输入成品批号">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>成品规格</th>
                        <td>
                            <input type="text" name="product_spec" placeholder="请输入成品规格">
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
        //增加零部件信息填写内容
        var addRemove = function (params, ele,number) {
            if (params == 'add') {
                switch (number) {
                    case 1:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="1[part_id][]" id="">\n'+
                            '@foreach($partInfosCZ as $partInfoCZ)\n'+
                            '<option value="{{$partInfoCZ->id}}">\n'+
                            "零部件名称：{{$partInfoCZ->part_name}} 生产商：{{$partInfoCZ->manufacturer}} 生产批号：{{$partInfoCZ->batch_number}} 型号：{{$partInfoCZ->model}}数量:{{$partInfoCZ->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="1[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    case 2:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="2[part_id][]" id="">\n'+
                            '@foreach($partInfosDG as $partInfoDG)\n'+
                            '<option value="{{$partInfoDG->id}}">\n'+
                            "零部件名称：{{$partInfoDG->part_name}} 生产商：{{$partInfoDG->manufacturer}} 生产批号：{{$partInfoDG->batch_number}} 型号：{{$partInfoDG->model}}数量:{{$partInfoDG->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="2[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    case 3:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="3[part_id][]" id="">\n'+
                            '@foreach($partInfosSP as $partInfoSP)\n'+
                            '<option value="{{$partInfoSP->id}}">\n'+
                            "零部件名称：{{$partInfoSP->part_name}} 生产商：{{$partInfoSP->manufacturer}} 生产批号：{{$partInfoSP->batch_number}} 型号：{{$partInfoDG->model}}数量:{{$partInfoDG->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="3[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    case 4:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="4[part_id][]" id="">\n'+
                            '@foreach($partInfosDP as $partInfoDP)\n'+
                            '<option value="{{$partInfoDP->id}}">\n'+
                            "零部件名称：{{$partInfoDP->part_name}} 生产商：{{$partInfoDP->manufacturer}} 生产批号：{{$partInfoDP->batch_number}} 型号：{{$partInfoDP->model}}数量:{{$partInfoDP->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="4[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    case 5:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="5[part_id][]" id="">\n'+
                            '@foreach($partInfosFDD as $partInfoFDD)\n'+
                            '<option value="{{$partInfoFDD->id}}">\n'+
                            "零部件名称：{{$partInfoFDD->part_name}} 生产商：{{$partInfoFDD->manufacturer}} 生产批号：{{$partInfoFDD->batch_number}} 型号：{{$partInfoFDD->model}}数量:{{$partInfoFDD->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="5[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    case 6:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="6[part_id][]" id="">\n'+
                            '@foreach($partInfosSPD as $partInfoSPD)\n'+
                            '<option value="{{$partInfoSPD->id}}">\n'+
                            "零部件名称：{{$partInfoSPD->part_name}} 生产商：{{$partInfoSPD->manufacturer}} 生产批号：{{$partInfoSPD->batch_number}} 型号：{{$partInfoSPD->model}}数量:{{$partInfoSPD->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="6[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    case 7:
                        $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                            '<select name="7[part_id][]" id="">\n'+
                            '@foreach($partInfosPJ as $partInfoPJ)\n'+
                            '<option value="{{$partInfoPJ->id}}">\n'+
                            "零部件名称：{{$partInfoPJ->part_name}} 生产商：{{$partInfoPJ->manufacturer}} 生产批号：{{$partInfoPJ->batch_number}} 型号：{{$partInfoPJ->model}}数量:{{$partInfoPJ->part_number}}\n" +
                            '</option>\n'+
                            '@endforeach \n'+
                            '</select>\n' +
                            '数量\n'+
                            '<input type="number" name="7[part_number][]" style="width: 80px;height: 25px;">\n' +
                            '                        </td>');
                        break;
                    default:'不存在的';break;
                }

            } else if (params == 'remove') {
                var len = $(ele).parent().parent().children().length;
                if (len <= 2) return;
                $(ele).parent().parent().children('td:last-child').remove();
            }else {
                return;
            }
        }

    </script>
@endsection