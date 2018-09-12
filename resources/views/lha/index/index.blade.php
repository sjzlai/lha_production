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
        @hasanyrole('采购|admin')
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/purchase/pur')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>采购申请')">
            <div class="icon">采</div>
            <div class="title">采购申请</div>
        </div>
        @endhasanyrole
        @hasanyrole('质检|admin')
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/quality')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>质检管理')">
            <div class="icon"><i class="icon fa fa-spin fa-spinner"></i></div>
            <div class="title">零部件质检</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/qualityProductionOrder')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>成品质检')">
            <div class="icon"><i class="icon fa fa-spin fa-refresh"></i></div>
            <div class="title">成品质检</div>
        </div>
        @endhasanyrole
        @hasanyrole('库管|admin')
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/spare')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>零部件仓库')">
            <div class="icon"><i class="icon fa fa-fw fa-truck"></i></div>
            <div class="title">零部件入库</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/spare/out')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>零部件仓库')">
            <div class="icon"><i class="icon fa fa-fw fa-bus"></i></div>
            <div class="title">零部件出库</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/storageRoom')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>库房管理')">
            <div class="icon">库</div>
            <div class="title">库房管理</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/productWarehousingOrderList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>成品入库')">
            <div class="icon">入</div>
            <div class="title">成品入库</div>
        </div>
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/ProductOutStorageRecordOrderList')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>成品出库')">
            <div class="icon">出</div>
            <div class="title">成品出库</div>
        </div>
        @endhasallroles
        @hasanyrole('生产|admin')
        <div class="shortcut" onclick="Win10.openUrl('{{url('ad/productionOrder')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>生产订单')">
            <div class="icon">生</div>
            <div class="title">生产订单</div>
        </div>
        @endhasanyrole
        @hasanyrole('admin')
        <div class="shortcut"  onclick="Win10.openUrl('{{url('ad/role')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>权限角色管理')">
            <div class="icon">权</div>
            <div class="title">权限角色管理</div>
        </div>
        <div class="shortcut"  onclick="Win10.openUrl('{{url('ad/user')}}','<img class=\'icon\' src=\'{{asset('img/icon/doc.png')}}\'/>用户管理')">
            <div class="icon">用</div>
            <div class="title">用户管理</div>
        </div>
        @endhasanyrole

    </div>
    <div id="win10-menu" class="hidden">
        <div class="list win10-menu-hidden animated animated-slideOutLeft">
            <div class="item" onclick=" Win10.exit();"><i class="black icon fa fa-power-off fa-fw"></i>退出登录</div>
            {{--<div class="sub-item" onclick="Win10.exit();">退出登录</div>--}}
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
            <div id="win10_btn_win" class="btn "><span class="black icon fa fa-power-off fa-fw"></span></div>
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