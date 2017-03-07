<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title', 'Notadd') - 后台 - 内容管理系统</title>
    <meta name="author" content="iBenchu, TwilRoad">
    <meta name="keywords" content="Notadd">
    <meta name="description" content="A CMS System Base On Laravel 5.2">
    <link rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    @yield('admin-css')
    <link rel="stylesheet" href="/assets/admin/css/main.css">
    {{--省市联动--}}
    {{--时间样式--}}
    {{--    <link href="/assets/admin/datetimepicker/sample in bootstrap v2/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="/assets/admin/datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">--}}
</head>

<body class="app">
<header class="site-head clearfix" id="site-head">
    <div class="nav-head">
        <a href="{{ url('admin') }}" class="site-logo"><span></span>&nbsp;内容管理系统</a>
        <span class="nav-trigger fa fa-outdent hidden-xs" data-toggle="nav-min"></span>
        <span class="nav-trigger fa fa-navicon visible-xs" data-toggle="off-canvas"></span>
    </div>
    <div class="head-wrap clearfix">
        <ul class="list-unstyled navbar-right">
            {{--<li>--}}
            {{--<a href="{{ url('') }}" target="_blank"><i class="fa fa-external-link"></i></a>--}}
            {{--</li>--}}
            <li class="dropdown">
                <a href class="user-profile" data-toggle="dropdown">
                    <img src="/assets/admin/images/avatar.jpg" alt="N">
                </a>
                <div class="panel panel-default dropdown-menu">
                    <div class="panel-footer clearfix">
                        <a href="{{ url('admin/register') }}" class="btn btn-warning btn-sm left">重置密码</a>
                        <a href="{{ url('admin/logout') }}" class="btn btn-danger btn-sm right">退出登陆</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
<div class="main-container clearfix">
    <aside class="nav-wrap" id="site-nav" data-toggle="scrollbar">
        <nav class="site-nav clearfix" role="navigation" data-toggle="nav-accordion">
            @foreach(config('admin') as $top)
                <div class="nav-title panel-heading"><i>{{ $top['title'] }}</i></div>
                @if ($top['sub'])
                    <ul class="list-unstyled nav-list">
                        @foreach ($top['sub'] as $one)
                            @if (isset($one['sub']))
                                <li class="{{ $one['active'] }}">
                                    <a href="javascript:;"><i class="fa {{ $one['icon'] }} icon"></i><span
                                                class="text">{{ $one['title'] }}</span><i
                                                class="arrow fa fa-angle-right right"></i></a>
                                    <ul class="inner-drop list-unstyled">
                                        @foreach($one['sub'] as $two)
                                            <li class="{{ $two['active'] ? 'active' : '' }}"><a
                                                        href="{{ url($two['url']) }}">{{ $two['title'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="{{ $one['active'] }}">
                                    <a href="{{ url($one['url']) }}"><i class="fa {{ $one['icon'] }} icon"></i><span
                                                class="text">{{ $one['title'] }}</span></a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            @endforeach
        </nav>

        <div class="theme-settings clearfix">
            <div class="panel-heading"><i>主题切换</i></div>
            <ul class="list-unstyled clearfix">
                @if($admin_theme == 'theme-zero')
                    <li class="active"><a href="javascript:;" data-toggle="theme" data-theme="theme-zero"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @else
                    <li><a href="javascript:;" data-toggle="theme" data-theme="theme-zero"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @endif
                @if($admin_theme == 'theme-one')
                    <li class="active"><a href="javascript:;" data-toggle="theme" data-theme="theme-one"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @else
                    <li><a href="javascript:;" data-toggle="theme" data-theme="theme-one"><span class="side-top"></span><span
                                    class="header"></span><span class="side-rest"></span></a></li>
                @endif
                @if($admin_theme == 'theme-two')
                    <li class="active"><a href="javascript:;" data-toggle="theme" data-theme="theme-two"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @else
                    <li><a href="javascript:;" data-toggle="theme" data-theme="theme-two"><span class="side-top"></span><span
                                    class="header"></span><span class="side-rest"></span></a></li>
                @endif
                @if($admin_theme == 'theme-three')
                    <li class="active"><a href="javascript:;" data-toggle="theme" data-theme="theme-three"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @else
                    <li><a href="javascript:;" data-toggle="theme" data-theme="theme-three"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @endif
                @if($admin_theme == 'theme-four')
                    <li class="active"><a href="javascript:;" data-toggle="theme" data-theme="theme-four"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @else
                    <li><a href="javascript:;" data-toggle="theme" data-theme="theme-four"><span
                                    class="side-top"></span><span class="header"></span><span class="side-rest"></span></a>
                    </li>
                @endif
            </ul>
        </div>
    </aside>

    <div class="content-container" id="content">
        @yield('content')
    </div>

    <footer id="site-foot" class="site-foot clearfix">
        <p class="left">&copy; Copyright 2015 - {{ date('Y') }} <strong>iBenchu.org</strong>, All rights reserved.</p>
        <p class="right">{{ config('app.version') }}</p>
    </footer>
</div>
<script src="/assets/admin/js/jquery-2.1.3.min.js"></script>
<script type="text/javascript" src="//statics.iewar.com/iewar.min.js"></script>
<script>
    function addLoadEvent(func) {
        var oldonload = window.onload;
        if (typeof window.onload != 'function') {
            window.onload = func;
        } else {
            window.onload = function () {
                if (oldonload) {
                    oldonload();
                }
                func();
            }
        }
    }
    addLoadEvent(function () {
        outdatedBrowser({
            bgColor: '#f25648',
            color: '#ffffff',
            lowerThan: 'transform',
            languagePath: '//statics.iewar.com/lang/zh-cn.html'
        })
    });
</script>
<script src="/assets/admin/js/bootstrap.min.js"></script>
<script src="/assets/admin/js/perfect-scrollbar.jquery.min.js"></script>
<script src="/assets/admin/js/app.js"></script>
<script src="/assets/admin/js/form-submit-confirm.js"></script>
@yield('admin-js')
</body>
</html>