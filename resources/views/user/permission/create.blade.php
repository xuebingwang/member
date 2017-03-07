@extends('admin::layout')
@section('title')添加角色权限@endsection

@section('content')
<div class="page clearfix">
    <ol class="breadcrumb breadcrumb-small">
        <li>后台首页</li>
        <li class="active"><a href="{{ url('admin/user/permissions')}}">角色权限管理</a></li>
        <li class="active">添加角色权限</li>
    </ol>
    <div class="page-wrap">
        <div class="row">
            @include('admin::common.messages')
            <div class="col-md-12">
                <div class="panel panel-lined clearfix mb30">
                    <div class="panel-heading mb20"><i>添加角色</i></div>

                    <form action="{{ url('admin/user/permissions') }}" autocomplete="off" class="form-horizontal col-md-12" method="post">

                        @include('admin::user.permission._permission-form')

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection