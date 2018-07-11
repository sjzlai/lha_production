@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productionOrder">生产订单</a> &raquo;生产记录登记
    </div>
    <!--面包屑导航 结束-->

    
    <div class="result_wrap">
        <form action="/ad/productionMakeRecord" method="post">
            {{csrf_field()}}
            <input type="hidden" name="order_no" value="{{$orderId}}">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>生产订单号：</th>
                        <td>{{$orderId}}</td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>完成生产量：</th>
                        <td><input type="number" class="lg" name="number"></td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>交货日期</th>
                        <td><input type="date" name="delivery_date"></td>
                    </tr>
                    <tr>
                        <th>零部件信息</th>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>吹嘴</th>
                        <td style="display: block">
                            <select name="part_id[]" id="">
                                @foreach($partInfosCZ as $partInfoCZ)
                                    <option value="{{$partInfoCZ->id}}">零部件名称：{{$partInfoCZ->part_name}} 生产商：{{$partInfoCZ->manufacturer}} 生产批号：{{$partInfoCZ->batch_number}} 型号：{{$partInfoCZ->model}}</option>
                                @endforeach
                            </select>
                            数量<input type="number" name="part_number[]" style="width: 40px">
                            <input type="button"   onclick="addRemove('add', this,1)" value="+">
                            <input type="button" onclick="addRemove('remove', this,1)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>笛管</th>
                        <td style="display: block"><select name="part_id[]" id="">
                                @foreach($partInfosDG as $partInfoDG)
                                    <option value="{{$partInfoDG->id}}">零部件名称：{{$partInfoDG->part_name}} 生产商：{{$partInfoDG->manufacturer}} 生产批号：{{$partInfoDG->batch_number}} 型号：{{$partInfoDG->model}}</option>
                                @endforeach
                            </select>
                            数量<input type="number" name="part_number[]" style="width: 40px">
                            <input type="button"   onclick="addRemove('add', this,2)" value="+">
                            <input type="button" onclick="addRemove('remove', this,2)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>哨片</th>
                        <td style="display: block"><select name="part_id[]" id="">
                                @foreach($partInfosSP as $partInfoSP)
                                    <option value="{{$partInfoSP->id}}">零部件名称：{{$partInfoSP->part_name}} 生产商：{{$partInfoSP->manufacturer}} 生产批号：{{$partInfoSP->batch_number}} 型号：{{$partInfoSP->model}}</option>
                                @endforeach
                            </select>
                            数量<input type="number" name="part_number[]" style="width: 40px">
                            <input type="button"   onclick="addRemove('add', this,3)" value="+">
                            <input type="button" onclick="addRemove('remove', this,3)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>垫片</th>
                        <td style="display: block"><select name="part_id[]" id="">
                                @foreach($partInfosDP as $partInfoDP)
                                    <option value="{{$partInfoDP->id}}">零部件名称：{{$partInfoDP->part_name}} 生产商：{{$partInfoDP->manufacturer}} 生产批号：{{$partInfoDP->batch_number}} 型号：{{$partInfoDP->model}}</option>
                                @endforeach
                            </select>数量<input type="number" name="part_number[]" style="width: 40px">
                            <input type="button"   onclick="addRemove('add', this,4)" value="+">
                            <input type="button" onclick="addRemove('remove', this,4)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>肺笛袋</th>
                        <td style="display: block"><select name="part_id[]"  id="">
                                @foreach($partInfosD as $partInfoD)
                                    <option value="{{$partInfoD->id}}">零部件名称：{{$partInfoD->part_name}} 生产商：{{$partInfoD->manufacturer}} 生产批号：{{$partInfoD->batch_number}} 型号：{{$partInfoD->model}}</option>
                                @endforeach
                            </select>数量<input type="number" name="part_number[]" style="width: 40px">
                            <input type="button"   onclick="addRemove('add', this,5)" value="+">
                            <input type="button" onclick="addRemove('remove', this,5)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>哨片袋</th>
                        <td style="display: block"><select name="part_id[]" id="">
                                @foreach($partInfosD as $partInfoD)
                                    <option value="{{$partInfoD->id}}">零部件名称：{{$partInfoD->part_name}} 生产商：{{$partInfoD->manufacturer}} 生产批号：{{$partInfoD->batch_number}} 型号：{{$partInfoD->model}}</option>
                                @endforeach
                            </select>数量<input type="number" name="part_number[]" style="width: 40px">
                            <input type="button"   onclick="addRemove('add', this,6)" value="+">
                            <input type="button" onclick="addRemove('remove', this,6)"  value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>皮筋</th>
                        <td style="display: block"><select name="part_id[]" id="">
                                @foreach($partInfosPJ as $partInfoPJ)
                                    <option value="{{$partInfoPJ->id}}">零部件名称：{{$partInfoPJ->part_name}} 生产商：{{$partInfoPJ->manufacturer}} 生产批号：{{$partInfoPJ->batch_number}} 型号：{{$partInfoPJ->model}}</option>
                                @endforeach
                            </select>数量<input type="number" name="part_number[]" style="width: 40px">
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
                $(ele).parent().parent().append(' <td style="display: block;" >\n' +
                    '<select name="part_id[]" id="">\n'+
                    '@foreach($partInfos as $partInfo)\n'+
                    '<option value="{{$partInfo->id}}">\n'+
                    "零部件名称：{{$partInfo->part_name}} 生产商：{{$partInfo->manufacturer}} 生产批号：{{$partInfo->batch_number}} 型号：{{$partInfo->model}}\n" +
                    '</option>\n'+
                    '@endforeach \n'+
                    '</select>\n' +
                    '数量\n'+
                    '<input type="number" name="part_number[]" style="width: 40px">\n' +
                    '                        </td>')
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