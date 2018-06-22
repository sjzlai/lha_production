{{--模板继承父模板--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('style/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('style/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('layer/layer.js')}}"></script>
</head>
<body>

{{--提示消息--}}
@if(session('error'))

    <script>
        var session = "{{session('error')}}";
        layer.msg(session);
    </script>
@endif
@if(session('message'))
    <script>
        var session = "{{session('message')}}";
        layer.msg(session);
    </script>

@endif
@yield('content')
</body>
</html>