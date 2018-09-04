@extends('layouts.admin')
@section('content')
    @foreach($img as $i)
        <table>
            <tr>
                <td>
                    <img src="{{asset($i->img_path)}}" alt="" style="width: 800px;height: 600px;">
                </td>
            </tr>
            <tr align="center">
                <td>
                    <input type="button" class="back" onclick="history.go(-1)" value="返回">
                </td>
            </tr>
        </table>
    @endforeach
@endsection