
{{ csrf_field() }}
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">权限名称</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="display_name" value="{{ old('display_name', $permission->display_name) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">标识</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" value="{{ old('name', $permission->name) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">描述</label>
    <div class="col-md-4">
        <textarea class="form-control" name="description" cols="7" rows="5">{{ old('description', $permission->description) }}</textarea>
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
        <button class="btn btn-primary btn-sm" type="submit" style="width: 100%;">提交</button>
    </div>
</div>
