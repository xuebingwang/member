@extends('admin::layout')
@section('title')编辑会员 - 会员管理@endsection

@section('content')
<div class="page clearfix">
    <ol class="breadcrumb breadcrumb-small">
        <li>后台首页</li>
        <li><a href="{{ url('admin/user/users') }}">会员管理</a></li>
        <li>编辑会员：{{ $user->name }}</li>
    </ol>

    <div class="page-wrap">
        <div class="row">
            @include('admin::common.messages')
            <div class="col-md-12">
                <div class="panel panel-lined clearfix mb30">

                    <div class="panel-heading mb20"><i>编辑会员</i></div>

                    <form action="{{ url('admin/user/users/' . $user->id) }}" autocomplete="off" class="form-horizontal" method="post">
                        <input type="hidden" name="_method" value="PATCH">
                        @include('admin::user.user._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
