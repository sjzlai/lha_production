@extends('layouts.admin')
@section('content')
    <table class="list_tab">
        <tr>
            {{--<th class="tc" width="5%"></th>--}}
            {{--<th class="tc">排序</th>--}}
            <th class="tc">出库单号</th>
            <th>数量</th>
            <th>更新时间</th>
            <th>操作</th>
        </tr>
        @foreach($data as $key=>$value)

                <tr>
                    {{--<td class="tc"><input type="checkbox" name="ckb" class="part" value="{{$value->out_storage_no}}" ></td>--}}
                    <td class="tc" >{{$value->out_storage_no}}</td>
                    <td>{{$value->spare_number}}</td>
                    <td></td>
                    <td>
                        {{--<a href="{{url('ad/spare/outInfo/'.$value->part_id.'/'.$value->part_number)}}">出库</a>--}}
                    </td>
                </tr>

        @endforeach
    </table>
@endsection