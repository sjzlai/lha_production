<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>生产管理系统</title>
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
                main:'{{asset('img/wallpapers/main.jpg')}}',
                mobile:'{{asset('img/wallpapers/mobile.jpg')}}',
            });

            Win10.setAnimated([
                'animated flip',
                'animated bounceIn',
            ], 0.01);

           /* setTimeout(function () {
                Win10.newMsg('官方交流一群', '欢迎各位大侠加入讨论：<a target="_blank" href="https://jq.qq.com/?_wv=1027&k=4Er0u8i">[点击加入]205546163</a>')
            }, 2500);

            setTimeout(function () {
                Win10.openUrl('//win10ui.yuri2.cn/src/broadcast.html','<i class="fa fa-newspaper-o icon red"></i>最新资讯',[['300px', '380px'],'rt'])
            },2000);*/


        });

    </script>
</head>
<body>
<div id="win10">
    <div id="win10-shortcuts">
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>文章管理')">
            <div class="icon">检</div>
            <div class="title">质检记录</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <div class="icon">仓</div>
            <div class="title">成品仓库</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <div class="icon">零</div>
            <div class="title">零件仓库</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <div class="icon">计</div>
            <div class="title">生产计划</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <div class="icon">录</div>
            <div class="title">生产记录</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/articleList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>仓库管理')">
            <i class="icon fa fa-fw fa-area-chart black" ></i>
            <div class="title">图表</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/role')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>权限管理')">
            <div class="icon">权</div>
            <div class="title">权限管理</div>
        </div>
    </div>
    <div id="win10-menu" class="hidden">
        <div class="list win10-menu-hidden animated animated-slideOutLeft">
            <div class="item"><i class="red icon fa fa-wrench fa-fw"></i><span>API测试</span></div>
            <div class="sub-item" onclick="Win10.commandCenterOpen()">打开消息中心</div>
            <div class="sub-item" onclick="Win10.newMsg('API测试','通过API可以发送消息至消息中心，自定义标题与内容(点击我试试)',function() {alert('click')})">发送带回调的消息</div>
            <div class="sub-item" onclick="Win10.menuClose()">关闭菜单</div>
            <div class="item" ><i class="blue icon fa fa-gavel fa-fw"></i>辅助工具</div>
            <div class="sub-item" onclick="Win10.openUrl('win10ui.yuri2.cn/src/tools/builder-shortcut.html','图标代码生成器')">桌面图标代码生成器</div>
            <div class="sub-item" onclick="Win10.openUrl('win10ui.yuri2.cn/src/tools/builder-tile.html','磁贴代码生成器')">磁贴代码生成器</div>
            <div class="sub-item" onclick="Win10.openUrl('win10ui.yuri2.cn/src/tools/builder-menu.html','菜单代码生成器')">菜单代码生成器</div>
            <div class="item" onclick="Win10.aboutUs()"><i class="purple icon fa fa-info-circle fa-fw"></i>关于</div>
            <div class="item" onclick=" Win10.exit();"><i class="black icon fa fa-power-off fa-fw"></i>关闭</div>
        </div>
        <div class="blocks">
            <div class="menu_group">
                <div class="title">
                    应用示例
                </div>
                <div loc="1,1" size="4,4" class="block">
                    <div class="content blue cover" style="font-size: 30px;line-height: 176px;text-align: center">
                        <i class="fa fa-cloud fa-fw"></i> 天气
                    </div>
                    <div class="content detail" style="background-color: rgb(46,147,217)">
                        <iframe src="//www.seniverse.com/weather/weather.aspx?uid=U43DF172E7&cid=CHBJ000000&l=&p=SMART&a=1&u=C&s=13&m=2&x=1&d=1&fc=&bgc=2E93D9&bc=&ti=0&in=0&li=" frameborder="0" scrolling="no" width="200" height="300" allowTransparency="true"></iframe>
                    </div>
                </div>
            </div>
            <div class="menu_group">
                <div class="title">
                    常用场景
                </div>
                <div loc="1,1" size="2,1" class="block">
                    <div class="content" style="background-color: grey" onclick="Win10.openUrl('https://www.baidu.com')">
                        <div class="win10-block-content-text">内部链接</div>
                    </div>
                </div>
                <div loc="3,1" size="2,1" class="block">
                    <div class="content" style="background-color: blue" onclick="window.open('https://www.baidu.com')">
                        <div class="win10-block-content-text">外部链接</div>
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
            <div class="btn" id="win10_btn_time">
                <!--0:00<br/>-->
                <!--1993/8/13-->
            </div>
            <div class="btn" id="win10_btn_command"><span id="win10-msg-nof" class="fa fa-comment-o"></span></div>
            <div class="btn" id="win10_btn_show_desktop"></div>
        </div>
    </div>
</div>
</body>
</html>