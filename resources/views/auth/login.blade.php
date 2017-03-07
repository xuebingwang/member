{{--
@extends('admin::auth')
@section('title')后台管理系统@endsection
@section('content')
    <div class="page page-auth clearfix" >
        <div class="auth-container" >
            <div class="auth-container-wrap" >
                <h1 class="site-logo h2 mb15"><a href="{{ url('/') }}"><span></span>&nbsp;内容管理系统</a></h1>
                <h3 class="text-normal h4 text-center">欢迎登陆后台管理系统</h3>
                <div class="form-container">
                    <form action="{{ url('admin/loginto') }}" class="form-horizontal" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group form-group-lg">
                            <input type="text" class="form-control" name="name" required>
                            <label alt="请输入账户" placeholder="账号"></label>
                        </div>
                        <div class="form-group form-group-lg">
                            <input type="password" class="form-control" name="password" required>
                            <label alt="请输入密码" placeholder="密码"></label>
                        </div>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p><strong>{{ $error }}</strong></p>
                                </div>
                            @endforeach
                        @endif
                        <div class="clearfix text-center">
                            <button type="submit" class="btn btn-lg btn-w120 btn-primary text-uppercase">登录</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection--}}
        <!DOCTYPE html>
<html>
<title>登录</title>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>@yield('title') - 后台 - 内容管理系统</title>
    <meta name="author" content="iBenchu, TwilRoad">
    <meta name="keywords" content="Notadd">
    <meta name="description" content="A CMS System Base On Laravel 5.2">
    <link rel="stylesheet" href="/assets/admin/css/font-awesome.min.css">
    <link rel="stylesheet" href="/assets/admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/admin/slide/slide-unlock.css">
    {{--<style>--}}
    {{--html, body, h1 {--}}
    {{--margin: 0;--}}
    {{--padding: 0;--}}
    {{--}--}}

    {{--body {--}}
    {{--background-color: #393939;--}}
    {{--color: #d5d4ff;--}}
    {{--overflow: hidden--}}
    {{--}--}}

    {{--#demo {--}}
    {{--width: 600px;--}}
    {{--margin: 150px auto;--}}
    {{--padding: 10px;--}}
    {{--border: 1px dashed #d5d4ff;--}}
    {{--border-radius: 10px;--}}
    {{---moz-border-radius: 10px;--}}
    {{---webkit-border-radius: 10px;--}}
    {{--text-align: left;--}}
    {{--}--}}
    {{--</style>--}}
</head>
<body>
<div class="page page-auth clearfix">
    <div class="auth-container">
        <div class="auth-container-wrap">
            <h1 class="site-logo h2 mb15"><a href="{{ url('/') }}"><span></span>&nbsp;内容管理系统</a></h1>
            <h3 class="text-normal h4 text-center">欢迎登陆后台管理系统</h3>
            <div class="form-container">
                <form action="{{ url('admin/loginto') }}" class="form-horizontal" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="form-group form-group-lg">
                        <input type="text" class="form-control" name="name" required>
                        <label alt="请输入账户" placeholder="账号"></label>
                    </div>
                    <div class="form-group form-group-lg">
                        <input type="password" class="form-control" name="password" required>
                        <label alt="请输入密码" placeholder="密码"></label>
                    </div>
                    <div class="form-group form-group-lg">
                        <div id="slider">
                            <div id="slider_bg"></div>
                            <span id="label">>></span> <span id="labelTip">拖动滑块验证</span>
                        </div>
                    </div>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <p><strong>{{ $error }}</strong></p>
                                </div>
                            @endforeach
                        @endif
                        <div class="clearfix text-center" id="login">

                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/assets/admin/slide/jquery-1.12.1.min.js"></script>
<script src="/assets/admin/slide/jquery.slideunlock.js"></script>
<script>
    $(function () {
        var slider = new SliderUnlock("#slider", {
            successLabelTip: "欢迎访问滴呀后台"
        }, function () {
            $('#login').append('<button type="submit" class="btn btn-lg btn-w120 btn-primary text-uppercase">登录</button>');
        });
        slider.init();
    })
</script>
</html>