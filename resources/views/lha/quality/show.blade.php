@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 质检操作
    </div>
    <!--面包屑导航 结束-->
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        <form action="{{url('ad/quality/store')}}" method="post" enctype="multipart/form-data">
            <table class="add_tab">
                {{csrf_field()}}
                <tbody>
                <tr>
                    <th width="120"><i class="require">*</i>采购订单号：</th>

                    <td>
                        <select name="purchase_order_no">
                            <option value="{{$order_number}}">{{$order_number}}</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>质检结果：</th>
                    <td>
                        <input type="file" class="lg" name="picture">
                    </td>
                </tr>
                <tr id="info">
                    <th><i class="require">*</i>检验结果：</th>
                    <td>
                        <label for=""><input type="radio" checked="checked" name="status" value="1"
                                             onchange="qualified(this)">全部合格</label>
                        <label for=""><input type="radio" name="status" value="2"
                                             onchange="unqualified(this)">不合格商品信息</label>

                    </td>
                </tr>

                <tr>
                    <th>操作人:</th>
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
        function unqualified() {
            $("#info").after('<tr class="hidden">' +
                '<th><i class="require">*</i>吹嘴：</th>' +
                '<td style="display: block;" ><input type="text" name="1[part_number][]" placeholder="请输入数量"><input type="text" name="1[batch_number][]" placeholder="请输入批号">\n' +
                '<input type="button" onclick=addRemove("add",this,1) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,1) name="" value="-">\n'+
                '</td></tr>' +
                '<tr class="hidden">' +
                '<th><i class="require">*</i>笛管：</th>' +
                '<td  style="display: block;"><input type="text" name="2[part_number][]"  placeholder="请输入数量"><input type="text" name="2[batch_number][]" placeholder="请输入批号">' +
                '<input type="button" onclick=addRemove("add",this,2) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,2) name="" value="-">\n'+
                '</td></tr>' +
                '<tr class="hidden">' +
                '<th><i class="require">*</i>哨片：</th>' +
                '<td><input type="text" name="3[part_number][]" placeholder="请输入数量"><input type="text" name="3[batch_number][]" placeholder="请输入批号">' +
                '<input type="button" onclick=addRemove("add",this,3) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,3) name="" value="-">\n'+
                '</td></tr>' +
                '<tr class="hidden">' +
                '<th><i class="require">*</i>垫片：</th>' +
                '<td><input type="text" name="4[part_number][]" placeholder="请输入数量"><input type="text" name="4[batch_number][]" placeholder="请输入批号">' +
                '<input type="button" onclick=addRemove("add",this,4) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,4) name="" value="-">\n'+
                '</td></tr>' +
                '<tr class="hidden">' +
                '<th><i class="require">*</i>肺笛袋：</th>' +
                '<td><input type="text" name="5[part_number][]" placeholder="请输入数量"><input type="text" name="5[batch_number][]" placeholder="请输入批号">' +
                '<input type="button" onclick=addRemove("add",this,5) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,5) name="" value="-">\n'+
                '</td></tr>' +
                '<tr class="hidden">' +
                '<th><i class="require">*</i>哨片袋：</th>' +
                '<td><input type="text" name="6[part_number][]" placeholder="请输入数量"><input type="text" name="6[batch_number][]" placeholder="请输入批号">' +
                '<input type="button" onclick=addRemove("add",this,6) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,6) name="" value="-">\n'+
                '</td></tr>' +
                '<tr class="hidden">' +
                '<th><i class="require">*</i>皮筋：</th>'+
                '<td><input type="text" name="7[part_number][]" placeholder="请输入数量"><input type="text" name="7[batch_number][]" placeholder="请输入批号">' +
                '<input type="button" onclick=addRemove("add",this,7) name="" value="+">\n'+
                '<input type="button" onclick=addRemove("remove",this,7) name="" value="-">\n'+
                '</td></tr>');
        };

        function qualified() {
            $(".hidden").hide();
        }

        //增加与减少零部件信息填写内容
        var addRemove = function (params, ele,number) {
            if (params == 'add') {
                $(ele).parent().parent().append('<td style="display: block;" >\n' +
                    '<input type="text" class="" name="'+number+'[part_number][]" placeholder="请输入吹嘴数量">\n' +
                    '<input type="text" name="'+number+'[batch_number][]" placeholder="请输入批号">\n' +
                    '</td>');
            } else if (params == 'remove') {
                var len = $(ele).parent().parent().children().length;
                if (len <= 2) return;
                $(ele).parent().parent().children('td:last-child').remove();
            }else {
                return;
            }
        };
    </script>
@endsection