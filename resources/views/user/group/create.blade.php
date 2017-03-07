@extends('admin::layout')
@section('title')添加用户组@endsection
@include('admin::user.group._select2-permission')
@section('content')
<div class="page clearfix">
    <ol class="breadcrumb breadcrumb-small">
        <li>后台首页</li>
        <li class="active"><a href="{{ url('admin/user/groups')}}">用户组管理</a></li>
        <li class="active">添加用户组</li>
    </ol>
    <div class="page-wrap">
        <div class="row">
            @include('admin::common.messages')
            <div class="col-md-12">
                <div class="panel panel-lined clearfix mb30">
                    <div class="panel-heading mb20"><i>添加用户组</i></div>
                    <form action="{{ url('admin/user/groups') }}" autocomplete="off" class="form-horizontal col-md-12" method="post">
                        @include('admin::user.group._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection