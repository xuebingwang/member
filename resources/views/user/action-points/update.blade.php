@extends('admin::layout')
@section('title')编辑行为 - 用户中心@endsection

@section('content')
<div class="page clearfix">
    <ol class="breadcrumb breadcrumb-small">
        <li>后台首页</li>
        <li>用户中心</li>
        <li><a href="{{ url('admin/user/action_points') }}">积分行为</a></li>
        <li>编辑行为：{{ $actionPoints->name }}</li>
    </ol>

    <div class="page-wrap">
        <div class="row">
            @include('admin::common.messages')
            <div class="col-md-12">
                <div class="panel panel-lined clearfix mb30">

                    <div class="panel-heading mb20"><i>编辑行为</i></div>

                    <form action="{{ url('admin/user/action_points/' . $actionPoints->id) }}" autocomplete="off" class="form-horizontal" method="post">
                        <input type="hidden" name="_method" value="PATCH">
                        @include('admin::user.action-points._form')
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
