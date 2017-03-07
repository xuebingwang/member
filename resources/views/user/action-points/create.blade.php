@extends('admin::layout')
@section('title')添加行为 - 用户中心@endsection

@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>用户中心</li>
            <li class="active"><a href="{{ url('admin/user/action_points')}}">行为积分</a></li>
            <li class="active">添加行为</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.messages')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20"><i>添加行为</i></div>

                        <form action="{{ url('admin/user/action_points') }}" autocomplete="off" class="form-horizontal col-md-12" method="post">

                            @include('admin::user.action-points._form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection