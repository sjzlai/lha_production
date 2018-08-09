@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 入库操作
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        <form action="{{url('ad/spare/addSpare')}}" method="post">
            <table class="add_tab">
                {{csrf_field()}}
                <tbody>
                    <tr>
                        <th width="120"><i class="require">*</i>入库编号：</th>
                        <td>
                            <input type="text" name="put_storage_no" placeholder="请输入入库编号">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>采购订单号：</th>
                        <td>
                            <select name="purchase_order_no">
                                @foreach($info as $v)
                                <option value="{{$v->order_number}}">{{$v->order_number}}</option>
                                @endforeach
                            </select>
                        </td>

                    </tr>
                    <tr style="background: #6dbfff">
                        <th><i class="require">*</i>吹嘴：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="1[store_room][]" id="one" onchange="info(this.value,'two')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="1[shelve][]" id="two">
                                <option value="">请选择货架</option>
                                {{--@foreach($room as $sh)
                                    <option value="{{$sh->id}}">{{$sh->shelf_name}}</option>
                                @endforeach--}}
                            </select>
                            <input type="text" class="" name="1[part_number][]" placeholder="请输入吹嘴数量">
                            <input type="text" name="1[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="1[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,1)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,1)" name="" value="-">
                        </td>
                    </tr>
                    <tr style="background: #e4b9b9">
                        <th><i class="require">*</i>笛管：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="2[store_room][]" id="one" onchange="info(this.value,'dgtwo')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="2[shelve][]" id="dgtwo">
                                <option value="">请选择货架</option>
                            </select>
                            <input type="text" class="" name="2[part_number][]" placeholder="请输入笛管数量">
                            <input type="text" name="2[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="2[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,2)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,2)" name="" value="-">
                        </td>
                    </tr>
                    <tr style="background: #5bc0de">
                        <th><i class="require">*</i>哨片：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="3[store_room][]" id="one" onchange="info(this.value,'sptwo')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="3[shelve][]" id="sptwo">
                                <option value="">请选择货架</option>
                            </select>
                            <input type="text" class="" name="3[part_number][]" placeholder="请输入哨片数量">
                            <input type="text" name="3[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="3[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,3)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,3)" name="" value="-">
                        </td>
                    </tr>
                    <tr style="background: #FFF0F5">
                        <th><i class="require">*</i>垫片：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="4[store_room][]" id="one" onchange="info(this.value,'dptwo')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="4[shelve][]" id="dptwo">
                                <option value="">请选择货架</option>
                            </select>
                            <input type="text" class="" name="4[part_number][]" placeholder="请输入垫片数量">
                            <input type="text" name="4[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="4[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,4)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,4)" name="" value="-">
                        </td>
                    </tr>
                    <tr style="background: #E6E6FA">
                        <th><i class="require">*</i>肺笛袋：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="5[store_room][]" id="one" onchange="info(this.value,'fdtwo')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="5[shelve][]" id="fdtwo">
                                <option value="">请选择货架</option>
                            </select>
                            <input type="text" class="" name="5[part_number][]" placeholder="请输入肺笛袋数量">
                            <input type="text" name="5[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="5[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,5)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,5)" name="" value="-">
                        </td>
                    </tr>
                    <tr style="background: #FFFFF0">
                        <th><i class="require">*</i>哨片袋：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="6[store_room][]" id="one" onchange="info(this.value,'spdtwo')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="6[shelve][]" id="spdtwo">
                                <option value="">请选择货架</option>
                            </select>
                            <input type="text" class="" name="6[part_number][]" placeholder="请输入哨片袋数量">
                            <input type="text" name="6[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="6[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,6)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,6)" name="" value="-">
                        </td>
                    </tr>
                    <tr style="background: #BAC498">
                        <th><i class="require">*</i>皮筋：</th>
                        <td style="display: block;" >
                            库房:
                            <select name="7[store_room][]" id="one" onchange="info(this.value,'pjtwo')">
                                <option value="">请选择库房</option>
                                @foreach($room as $ro)
                                    <option value="{{$ro->id}}" >{{$ro->store_name}}</option>
                                @endforeach
                            </select>
                            货架:
                            <select name="7[shelve][]" id="pjtwo">
                                <option value="">请选择货架</option>
                            </select>
                            <input type="text" class="" name="7[part_number][]" placeholder="请输入皮筋数量">
                            <input type="text" name="7[batch_number][]" placeholder="请输入批号">
                            <input type="text" name="7[model][]" placeholder="请输入型号">
                            <input type="button" onclick="addRemove('add', this,7)" name="" value="+">
                            <input type="button" onclick="addRemove('remove', this,7)" name="" value="-">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>操作人:</th>
                        <td>
                            <select name="user_id">
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
        //增加与减少零部件信息填写内容
        var addRemove = function (params, ele,number) {
            if (params == 'add') {
                    $(ele).parent().parent().append( '<td style="display: block;" >\n' +
                        '库房: <select name="'+number+'[store_room][]"  onchange=info(this.value,"'+number+'two")>' +
                        ' <option value="" select="select">请选择库房</option>' +
                        '@foreach($room as $ro)<option value="{{$ro->id}}" >{{$ro->store_name}}</option>@endforeach</select>\n' +
                        '货架: <select name="'+number+'[shelve][]" id="'+number+'two"><option value="">请选择货架</option></select>\n'+
                        '<input type="text" class="" name="'+number+'[part_number][]" placeholder="请输入吹嘴数量"/>\n' +
                        '<input type="text" name="'+number+'[batch_number][]" placeholder="请输入批号"/>\n' +
                        '<input type="text" name="'+number+'[model][]" placeholder="请输入型号"/>\n' +
                        '</td>')
            } else if (params == 'remove') {
                var len = $(ele).parent().parent().children().length;
                if (len <= 2) return;
                $(ele).parent().parent().children('td:last-child').remove();
            }else {
                return;
            }
        };

        //选择库房查询货架
        function info(id,twoid) {
            console.log(id)
            $.get("{{url('ad/spare/shelve/info')}}",{
                'id':id,
                '_token':'{{csrf_token()}}'
            },function (data) {
                //console.log(data)
                $('#'+twoid).children('[value!=""]').remove();
                var info =data.data;
               // console.log(info)
                info.forEach(function (item,index) {
                    if (item)
                    $('#'+twoid).append(`<option  value=${info[index].id}>  ${info[index].shelf_name} </option>`);
                })
            });
        }
    </script>
@endsection