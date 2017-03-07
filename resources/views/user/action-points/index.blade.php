@extends('admin::layout')
@section('title')行为积分 - 用户中心@endsection
@section('content')
    <div class="page clearfix">
        <ol class="breadcrumb breadcrumb-small">
            <li>后台首页</li>
            <li>用户中心</li>
            <li class="active">行为积分</li>
        </ol>
        <div class="page-wrap">
            <div class="row">
                @include('admin::common.messages')
                <div class="col-md-12">
                    <div class="panel panel-lined clearfix mb30">
                        <div class="panel-heading mb20">
                            <i>数据管理</i>
                            <a href="{{ url('admin/user/action_points/create') }}"><i class="fa fa-plus"></i>添加</a>
                        </div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th class="col-md-1">ID</th>
                                <th class="col-md-1">名称</th>
                                <th class="col-md-1">标识</th>
                                <th class="col-md-2">积分</th>
                                <th class="col-md-2">创建时间</th>
                                <th class="col-md-2">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($lists as $list)
                                <tr>
                                    <td>{{ $list->id }}</td>
                                    <td>{{ $list->display_name }}</td>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->points }}</td>
                                    <td>{{ $list->created_at }}</td>
                                    <td>
                                        <form action="{{ url('admin/user/action_points/' . $list->id) }}" method="post" style="display: inline;">
                                            <input name="_method" type="hidden" value="delete">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <div class="btn-group">
                                                <a href="{{ url('admin/user/action_points/' . $list->id . '/edit') }}" class="btn btn-primary btn-xs"><i class="fa fa-search-plus"></i>编辑</a>
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