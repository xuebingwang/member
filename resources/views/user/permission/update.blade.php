@extends('admin::layout')
@section('title')编辑角色权限 - 系统管理@endsection
@section('content')
<div class="page clearfix">
    <ol class="breadcrumb breadcrumb-small">
        <li>后台首页</li>
        <li>系统管理</li>
        <li><a href="{{ url('admin/user/permissions') }}">角色权限管理</a></li>
        <li>编辑角色权限：{{ $permission->display_name }}</li>
    </ol>

    <div class="page-wrap">
        <div class="row">
            @include('admin::common.messages')
            <div class="col-md-12">
                <div class="panel panel-lined clearfix mb30">

                    <div class="panel-heading mb20"><i>编辑角色权限</i></div>

                    <form action="{{ url('admin/user/permissions/' . $permission->id) }}" autocomplete="off" class="form-horizontal" method="post">
                        <input type="hidden" name="_method" value="PATCH">

                        @include('admin::user.permission._permission-form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection