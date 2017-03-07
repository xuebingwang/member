@extends('admin::layout')
@section('title')添加用户@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li class="active"><a href="{{ url('admin/users/user')}}">会员管理</a></li>
            <li class="active">添加用户</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.messages')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20"><i>添加用户</i></div>

                        <form action="{{ url('admin/user/users') }}" autocomplete="off" class="form-horizontal col-md-12" method="post">

                            @include('admin::user.user._form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection