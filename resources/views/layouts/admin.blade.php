{{--模板继承父模板--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('style/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('style/js/ch-ui.admin.js')}}"></script>
</head>
<body>
@if(session('error'))
    <p>{{session('error')}}</p>

@endif
@if(session('message'))
    <p>{{session('message')}}</p>

@endif
@yield('content')
</body>
</html>