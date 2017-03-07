{{ csrf_field() }}
<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">名称</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="name" value="{{ old('name', $actionPoints->name) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">显示名称</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="display_name" value="{{ old('display_name', $actionPoints->display_name) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">积分</label>
    <div class="col-md-4">
        <input type="text" class="form-control" name="points" value="{{ old('points', $actionPoints->points) }}">
    </div>
</div>

<div class="form-group form-group-sm">
    <label class="col-md-4 control-label">描述</label>
    <div class="col-md-4">
        <textarea name="description" class="form-control" id="" cols="30" rows="4">{{ old('description', $actionPoints->description) }}</textarea>
    </div>
</div>


<div class="form-group form-group-sm">
    <label class="col-md-4 control-label"></label>
    <div class="col-md-4">
        <button class="btn btn-primary btn-sm" type="submit" style="width: 100%;">提交</button>
    </div>
</div>
