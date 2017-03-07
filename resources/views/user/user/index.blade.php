@extends('admin::layout')
@section('title')用户列表 - 用户中心@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>用户中心</li>
            <li><a href="{{ url('admin/user/users') }}">用户列表</a></li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.messages')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20">
                            <i>数据管理</i>
                            <a href="{{ url('admin/user/users/create') }}"><i class="fa fa-plus"></i>添加</a>

                            {{--<form class="form-inline" action="{{ url('admin/user') }}" method="get">--}}
                                {{--<div class="form-group form-group-sm">--}}
                                    {{--<label class="control-label">开始时间</label>--}}
                                    {{--<input type="text" readonly id="start_time" class="form-control" name="start_time" value="{{ $startTime }}">--}}
                                {{--</div>--}}

                                {{--<div class="form-group form-group-sm">--}}
                                    {{--<label class="control-label">结束时间</label>--}}
                                    {{--<input type="text" readonly id="end_time" class="form-control" name="end_time" value="{{ $endTime }}">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label for="">账号</label>--}}
                                    {{--<input class="form-control input-sm" type="text" name="name" value="{{ $name }}">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label for="">昵称</label>--}}
                                    {{--<input class="form-control input-sm" type="text" name="nick_name" value="{{ $nick_name }}">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label for="">邮箱</label>--}}
                                    {{--<input class="form-control input-sm" type="text" name="email" value="{{ $email }}">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label for="">电话</label>--}}
                                    {{--<input class="form-control input-sm" type="text" name="phone" value="{{ $phone }}">--}}
                                {{--</div>--}}

                                {{--<div class="form-group">--}}
                                    {{--<label for="">姓名</label>--}}
                                    {{--<input class="form-control input-sm" type="text" name="real_name" value="{{ $real_name }}">--}}
                                {{--</div>--}}

                                {{--<button type="submit" name="do" value="query" class="btn btn-primary btn-xs">查询</button>--}}
                                {{--<button type="submit" name="do" value="export" class="btn btn-primary btn-xs">导出 Excel</button>--}}
                            {{--</form>--}}
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">用户名</th>
                                <th class="col-md-1">邮箱</th>
                                <th class="col-md-2">注册时间</th>
                                <th class="col-md-2">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lists as $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->email }}</td>
                                    <td>{{ $list->created_at }}</td>
                                    <td>
                                        <form action="{{ url('admin/user/users/' . $list->id) }}" method="post" style="display: inline;">
                                            <input name="_method" type="hidden" value="delete">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="btn-group">
                                                <a href="{{ url('admin/user/users/' . $list->id . '/edit') }}" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i>编辑</a>
                                                <button type="submit" class="btn btn-danger btn-xs" data-form-confirm="确定要删除吗？">
                                                    <i class="fa fa-trash-o"></i>删除
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="panel-footer clearfix">
                            <nav class="right">{!! $lists->links() !!}</nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection