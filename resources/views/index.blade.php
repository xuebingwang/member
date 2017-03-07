@extends('admin::layout')

@section('title')首页@endsection

@section('admin-css')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/index.css') }}">
@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li><a href="{{ url('admin') }}">仪表盘</a></li>
        </ol>

        <div class="page-wrap">

        </div>
    </div>
@endsection