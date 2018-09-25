@extends('layouts.admin')
@section('content')
    <div class="result_content">
        <div class="short_wrap">
            <button id="b1" style="background:aquamarine">返回所有出库单号</button>
        </div>
    </div>
    <script>
        $('#b1').click(function () {
            window.location.href="/ad/spare/outnum"
        })
    </script>
    <table class="list_tab">
        <tr>
            {{--<th class="tc" width="5%"></th>--}}
            {{--<th class="tc">排序</th>--}}
            <th class="tc">部件名称</th>
            <th>数量</th>
            <th>出库单号</th>
            <th>库房</th>
            <th>货架</th>
            <th>更新时间</th>
        </tr>
        @foreach($data as $key=>$value)
            <tr>
                {{--<td class="tc"><input type="checkbox" name="ckb" class="part" value="{{$value->out_storage_no}}" ></td>--}}
                <td class="tc" >{{$value->part_name}}</td>
                <td>{{$value->spare_number}}</td>
                <td>{{$value->out_storage_no}}</td>
                <td>{{$value->store_name}}</td>
                <td>{{$value->shelf_name}}</td>
                <td>{{$value->updated_at}}</td>
            </tr>
        @endforeach
    </table>
@endsection