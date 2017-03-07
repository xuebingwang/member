
{{ csrf_field() }}
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">用户名</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">密码</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="password" value="">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">邮箱</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="email" value="{{ old('email', $user->email) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">用户组</label>
    <div class="col-md-4">
        <select class="groups-multiple form-control" name="groups[]" multiple="multiple">
            @foreach($groups as $group)
                <option value="{{ $group['id'] }}"@if(!$user->groups->where('id', $group['id'])->isEmpty()) selected="selected"@endif>{{ $group['display_name'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">用户权限</label>
    <div class="col-md-4">
        <select class="permissions-multiple form-control" name="permissions[]" multiple="multiple">
            @foreach($permissions as $permission)
                @if($user->cachedPermissions()->where('id', $permission['id'])->isEmpty())
                    <option value="{{ $permission['id'] }}">{{ $permission['display_name'] }}</option>
                @else
                    <option value="{{ $permission['id'] }}" selected="selected">{{ $permission['display_name'] }}</option>
                @endif
            @endforeach
        </select>
    </div>
</div>


<div class="form-group form-group-sm">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
        <button class="btn btn-primary btn-sm" type="submit" style="width: 100%;">提交</button>
    </div>
</div>

@section('admin-css')
    <link href="//cdn.bootcss.com/select2/4.0.3/css/select2.min.css" rel="stylesheet">
@endsection

@section('admin-js')
    <script src="//cdn.bootcss.com/select2/4.0.3/js/select2.min.js"></script>

    <script>
      $(document).ready(function () {
        $('.groups-multiple').select2({
          placeholder: "选择一些选项",
          tags: true
        });

        $('.permissions-multiple').select2({
          placeholder: "选择一些选项",
          tags: true
        });
      });
    </script>
@endsection
