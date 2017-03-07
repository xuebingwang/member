@extends('admin::layout')
@section('title')编辑用户组 - 系统管理@endsection
@section('content')
<div class="page clearfix">
    <ol class="breadcrumb breadcrumb-small">
        <li>后台首页</li>
        <li><a href="{{ url('admin/user/groups') }}">用户组管理</a></li>
        <li>编辑用户组：{{ $group->display_name }}</li>
    </ol>
    <div class="page-wrap">
        <div class="row">
            @include('admin::common.messages')
            <div class="col-md-12">
                <div class="panel panel-lined clearfix mb30">

                    <div class="panel-heading mb20"><i>编辑用户组</i></div>

                    <form action="{{ url('admin/user/groups/' . $group->id) }}" autocomplete="off" class="form-horizontal" method="post">
                        <input type="hidden" name="_method" value="PATCH">

                        @include('admin::user.group._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@include('admin::user.group._select2-permission')