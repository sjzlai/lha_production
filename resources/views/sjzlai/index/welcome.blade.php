@extends('sjzlai.common.base')
@section('base')
        <div class="x-body">
            <blockquote class="layui-elem-quote">欢迎使用x-admin 后台模版！v2.0官方交流群： 519492808</blockquote>
            <fieldset class="layui-elem-field">
              <legend>信息统计</legend>
              <div class="layui-field-box">
                <table class="layui-table" lay-even>
                    <thead>
                        <tr>
                            <th>统计</th>
                            <th>资讯库</th>
                            <th>图片库</th>
                            <th>产品库</th>
                            <th>用户</th>
                            <th>管理员</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>总数</td>
                            <td>92</td>
                            <td>9</td>
                            <td>0</td>
                            <td>8</td>
                            <td>20</td>
                        </tr>
                        <tr>
                            <td>今日</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>昨日</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>本周</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>本月</td>
                            <td>2</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        </tr>
                    </tbody>
                </table>
                <table class="layui-table">
                <thead>
                    <tr>
                        <th colspan="2" scope="col">服务器信息</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($serverInfo as $item)
                    <tr>
                        <th width="30%">{{$item['name']}}</th>
                        <td><span id="lbServerName">{{$item['value']}}</span></td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
              </div>
            </fieldset>
            <blockquote class="layui-elem-quote layui-quote-nm">感谢layui,百度Echarts,jquery,本后台系统由X前端框架提供前端技术支持。</blockquote>
            
        </div>
        <script>
        var _hmt = _hmt || [];
        (function() {
          var hm = document.createElement("script");
          hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
          var s = document.getElementsByTagName("script")[0]; 
          s.parentNode.insertBefore(hm, s);
        })();
        </script>
@endsection