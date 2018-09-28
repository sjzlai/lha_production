@extends('layouts.admin')
@section('content')

    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="/ad/index">首页</a> &raquo; <a href="/ad/productWarehousingOrderList">订单查看</a> &raquo;成品入库
    </div>
    <!--面包屑导航 结束-->


    <div class="result_wrap">
        <form action="/ad/productWarehousingRecordStore" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <input type="hidden" name="production_order_no" value="{{$data[0]->order_no}}">
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>订单号：</th>
                    <td style="font-weight: bold">{{$data[0]->order_no}}</td>
                    <input type="hidden" name="id" value="{{$data[0]->ppsr_id}}">
                </tr>
               {{-- <tr>
                    <th><i class="require">*</i>工厂订单号：</th>
                    <td style="font-weight: bold"></td>
                </tr>--}}
                <tr>
                    <th><i class="require">*</i>存入库房</th>
                    <td style="display: block">
                        <select class="" name="storageRoom"  id="" onchange="info(this.value,'two',this)">
                            <option value="">选择库房</option>
                            {{--<option class="" value="{{$data[0]->room_id}}" selected="selected">{{$data[0]->store_name}}</option>--}}
                            @foreach($storageRooms as $storageRoom)
                                @if($storageRoom->id == $data[0]->room_id)
                                    <option class="options" value="{{$storageRoom->id}}"  selected="selected">{{$storageRoom->store_name}}</option>
                                @else
                                    <option class="options" value="{{$storageRoom->id}}">{{$storageRoom->store_name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <select name="shelf" id="" class="shelf">
                            <option class="" value="">选择货架</option>
                            @foreach($shelf as $value)
                                @if($value->id == $data[0]->shelf_id)
                                    <option class="" value="{{$data[0]->shelf_id}}" selected="selected">{{$value->shelf_name}}</option>
                                @else
                                    <option class="" value="{{$data[0]->shelf_id}}" >{{$value->shelf_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>入库数量：</th>
                    <td><input name="number" type="number" placeholder="请输入入库数量" value="{{$data[0]->number}}"></td>
                </tr>
                <tr>
                    <th><i class="require">*</i>备注</th>
                    <td><textarea name="remark" id="" cols="30" rows="10" >{{$data[0]->remark}}</textarea></td>
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

        function info(id,twoid,obj) {
            //console.log(id)
            var objs =$(obj).parent().children().next();
           // console.log(objs);
            $.get("{{url('ad/spare/shelve/info')}}",{
                'id':id,
                '_token':'{{csrf_token()}}'
            },function (data) {
                //console.log(data)
                objs.children('[value!=""]').remove();
                var info =data.data;
                //console.log(info)
                info.forEach(function (item,index) {
                    if (item)
                        objs.append(`<option  value=${info[index].id}>${info[index].shelf_name}</option>`);
                })
            });
        }
    </script>
@endsection