<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>后台管理系统</title>
    <link rel='Shortcut Icon' type='image/x-icon' href='{{asset('img/windows.ico')}}'>
    <script type="text/javascript" src="{{asset('js/jquery-2.2.4.min.js')}}"></script>
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('component/layer-v3.0.3/layer/layer.js')}}"></script>
    <link rel="stylesheet" href="{{asset('component/font-awesome-4.7.0/css/font-awesome.min.css')}}">
    <link href="{{asset('css/default.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{asset('js/win10.js')}}"></script>
    <style>
        * {
            font-family: "Microsoft YaHei", 微软雅黑, "MicrosoftJhengHei", 华文细黑, STHeiti, MingLiu
        }

        /*磁贴自定义样式*/
         .win10-block-content-text {
             line-height: 44px;
             text-align: center;
             font-size: 16px;
         }
    </style>
    <script>
        Win10.onReady(function () {

            //设置壁纸
            Win10.setBgUrl({
                main: '{{asset("img/wallpapers/main.jpg")}}',
                mobile: '{{asset("img/wallpapers/mobile.jpg")}}',
            });

            Win10.setAnimated([
                'animated flip',
                'animated bounceIn',
            ], 0.01);

          /*  setTimeout(function () {
                Win10.newMsg('官方交流一群', '欢迎各位大侠加入讨论：<a target="_blank" href="https://jq.qq.com/?_wv=1027&k=4Er0u8i">[点击加入]205546163</a>')
            }, 2500);

            setTimeout(function () {
                Win10.openUrl('//win10ui.yuri2.cn/src/broadcast.html','<i class="fa fa-newspaper-o icon red"></i>最新资讯',[['300px', '380px'],'rt'])
            },2000);*/
            //典型用法(桌面菜单)
        });
        Win10.setContextMenu('#win10>.desktop',[
            '菜单标题', //单字符串，不带回调
            ['进入全屏',function () {Win10.enableFullScreen()}], //菜单项+点击回调
            ['退出全屏',function () {Win10.disableFullScreen()}],
            '|', //分隔符
            ['关于',function () {Win10.aboutUs()}],
        ]);

        //设置menu为true会起到禁用系统默认菜单的作用
        Win10.setContextMenu('#win10',true);

    </script>
</head>
<body>
<div id="win10">
    <div id="win10-shortcuts">
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>文章管理')">
            <div class="icon">文</div>
            <div class="title">文章管理</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <div class="icon">仓</div>
            <div class="title">仓库管理</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <i class="icon fa fa-fw fa-area-chart black" ></i>
            <div class="title">图表</div>
        </div>
    </div>
    <div id="win10-menu" class="hidden">
        <div class="list win10-menu-hidden animated animated-slideOutLeft">
            <div class="item" ><i class="blue icon fa fa-gavel fa-fw"></i>辅助工具</div>
            <div class="sub-item" onclick="Win10.openUrl('win10ui.yuri2.cn/src/tools/builder-shortcut.html','图标代码生成器')">桌面图标代码生成器</div>
            <div class="sub-item" onclick="Win10.openUrl('win10ui.yuri2.cn/src/tools/builder-tile.html','磁贴代码生成器')">磁贴代码生成器</div>
            <div class="sub-item" onclick="Win10.openUrl('win10ui.yuri2.cn/src/tools/builder-menu.html','菜单代码生成器')">菜单代码生成器</div>
            <div class="item"
                 onclick="Win10.exit()">
                <i class="black icon fa fa-power-off fa-fw"></i><span class="title">关闭</span>
            </div>
        </div>
        <div class="blocks">
            <div class="menu_group">
                <div class="title">Welcome</div>
                <div class="block" loc="1,1" size="6,4">
                    <div class="content">
                        <div style="font-size:100px;line-height: 132px;margin: 0 auto ;display: block"
                             class="fa fa-fw fa-windows win10-block-content-text"></div>
                        <div class="win10-block-content-text" style="font-size: 22px">欢迎使用 Win10-UI</div>
                    </div>
                </div>
            </div>
        </div>
        <div id="win10-menu-switcher"></div>
    </div>
    <div id="win10_command_center" class="hidden_right">
        <div class="title">
            <h4 style="float: left">消息中心 </h4>
            <span id="win10_btn_command_center_clean_all">全部清除</span>
        </div>
        <div class="msgs"></div>
    </div>
    <div id="win10_task_bar">
        <div id="win10_btn_group_left" class="btn_group">
            <div id="win10_btn_win" class="btn"><span class="fa fa-windows"></span></div>
            <div class="btn" id="win10-btn-browser"><span class="fa fa-internet-explorer"></span></div>
        </div>
        <div id="win10_btn_group_middle" class="btn_group"></div>
        <div id="win10_btn_group_right" class="btn_group">
            <div class="btn" id="win10_btn_time"></div>
            <div class="btn" id="win10_btn_command"><span id="win10-msg-nof" class="fa fa-comment-o"></span></div>
            <div class="btn" id="win10_btn_show_desktop"></div>
        </div>
    </div>
</div>
</body>
</html>