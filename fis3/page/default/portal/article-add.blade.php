@extends('widget.layout.usercenter-default') @section('title') 添加 @endsection @section('content')
@require('/static/css/simditor.css')
<div>

</div>
<div class="panel panel-info">
    <div class="panel-body">
        <div>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">标题</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="" placeholder="标题">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-sm-1"></label>
                    <div class="col-sm-10">
                        <script id="container" name="content" type="text/plain" style="height: 500px"></script>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">摘要：</label>
                    <div class="col-sm-10">
                        <textarea type="file" class="form-control" id="" rows="3" name="abstract"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="control-label col-sm-1">评论：</label>
                    <div class="col-sm-10">
                        <label class="radio-inline">
                            <input type="radio" name="is_comment" checked value="1">允许
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="is_comment" value="2">禁止
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="control-label col-sm-1"></label>
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-default btn-block">提交</button>
                    </div>
                </div>
                
            </form>
        </div>
    </div>
</div>
@require('/static/js/ueditor.config.js');
@require('/static/js/ueditor.all.min.js');

@endsection
@section('script')
@script()
console.log(UE);
var editor = UE.getEditor('container');
@endscript
@endsection
