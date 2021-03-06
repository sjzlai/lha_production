@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="">首页</a> &raquo;  <a href="">零部件列表</a> &raquo;
    </div>

    <div class="result_wrap">
        <form action="{{url('ad/spare/outStore')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                <tr>
                    <th><i class="require">*</i>出库单号</th>
                    <td>
                        <input type="text"  readonly =" readonly " name="outstorageno" value="{{$outstorageno}}" placeholder="请输入出库单号">
                    </td>
                </tr>
                @foreach($data as $value)
                    <tr>
                        <th><i class="require">*</i>{{$value['part_name']}}：</th>
                        <td>
                            <input type="hidden" name="shp_id[]" value="{{$value['shp_id']}}">
                            <input type="hidden" name="id[]" value="{{$value['id']}}">
                            <input type="text" class="lg" name="part_number[]"  value="{{$value->spare_number}}" placeholder="请填写出库数量">
                        </td>
                    </tr>
                @endforeach
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

@endsection