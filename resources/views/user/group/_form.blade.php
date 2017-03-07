{{ csrf_field() }}
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">显示名称</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="display_name" value="{{ old('display_name', $group->display_name) }}">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">标识</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" value="{{ old('name', $group->name) }}">
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">描述</label>
    <div class="col-md-4">
        <textarea class="form-control" name="description" cols="7" rows="5">{{ old('description', $group->description) }}</textarea>
    </div>
</div>
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">权限</label>
    <div class="col-md-4">
        <select class="permission-multiple form-control" name="permissions[]" multiple="multiple">
            @foreach($permissions as $permission)
                <option value="{{ $permission['id'] }}" @if(! $group->cachedPermissions()->where('id', $permission['id'])->isEmpty()))) selected="selected"@endif>{{ $permission['display_name'] }}</option>
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