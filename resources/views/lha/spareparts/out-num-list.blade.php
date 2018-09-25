@extends('layouts.admin')
@section('content')
    <div class="result_content">
        <div class="short_wrap">
            <button id="b1" style="background:aquamarine">返回零部件出库仓</button>
        </div>
    </div>
    <script>
        $('#b1').click(function () {
            window.location.href="/ad/spare/out"
        })
    </script>
    <table class="list_tab">
        <tr>
            {{--<th class="tc" width="5%"></th>--}}
            {{--<th class="tc">排序</th>--}}
            <th class="tc">出库单号</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        @foreach($data as $key=>$value)

                <tr>
                    {{--<td class="tc"><input type="checkbox" name="ckb" class="part" value="{{$value->out_storage_no}}" ></td>--}}
                    <td class="tc" >{{$value->out_storage_no}}</td>
                    <td>{{$value->updated_at}}</td>
                    <td>
                        {{--<a href="{{url('ad/spare/outInfo/'.$value->part_id.'/'.$value->part_number)}}">出库</a>--}}
                        <a href="{{url('ad/spare/outdetaild/'.$value->out_storage_no)}}">查看订单详细</a>
                    </td>
                </tr>
        @endforeach
    </table>
@endsection