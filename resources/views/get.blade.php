<form action="{{ route('excel.post') }}" method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-sm-3 control-label">文件域：</label>
            <div class="col-sm-9">
                <input type="file" name="bbb" class="form-control">
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="col-sm-3 control-label"></label>
            <div class="col-sm-9">
                <button class="badge-dark" type="submit">提交</button>
            </div>
        </div>
    </div>
</form>

