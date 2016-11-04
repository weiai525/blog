@extends('widget.default.layout.usercenter') 
@section('title')
我的头像
@endsection
@section('content')

<div class="col-sm-12">
     <div class="col-sm-3" style="width:180px;height:180px;padding: 0px;" >
        <img src="{{Auth::user()['avatar']}}" style="width:180px;height:180px;padding: 0px;">
    </div>
</div>
<hr>
<div class="col-sm-12">
    <div>
        <input id="inputimage" name="file" accept="" class="ignore" size="1" style="position:absolute;left:0;opacity:0;z-index:100;cursor:hand;width:98px;height:70px;" type="file"><a class="btn btn-info" href="javascript:;" id="js_upload_file">添加头像</a>
    </div>
    <div class="col-sm-3" style="width:180px;height:180px;padding: 0px;" >
        <img src="" id="srcimage" alt="" style="width:180px;height:180px;">
    </div>
    <div class="col-sm-1">
        
    </div>
    <div class="col-sm-3" style="width:180px;height:180px;padding:0px;overflow:hidden;" id="newcro">
    </div>
    <div class="col-sm-3">
        <button type="" class="btn btn-primary" id="btn-modify-image">保存</button>
    </div>
</div>
@require('/static/css/cropper.min.css')
@require('/static/js/cropper/cropper.js')
@endsection 
@section("script")
$(document).ready(function(){
var cropperOptions = {
    aspectRatio: 1 / 1,
    background: 0,
    zoomable: 0,
    viewMode:1,
    preview: '#newcro',
    crop: function(data) {}
};
var $image = $('#srcimage');
$image.cropper(cropperOptions);
//var cropper = new Cropper($image, cropperOptions);
  //加载本地图片
$('#inputimage').on('change', function() {
    var file = this.files[0];
    var url;
    url = URL.createObjectURL(file);
    $('#srcimage').attr('src', url);
    $image.cropper("replace", url);
});
$('#btn-modify-image').on('click', function() {
    var data = $image.cropper('getCroppedCanvas', {
        'width': 300,
        'height': 300
    }).toDataURL();
    $.post('{{route('user_modifyimage')}}', {
        "base64": data
    }, function(returndata) {
        if (returndata['code'] == 0) {
            location.reload();
        } else {
            $alert = $('#am-alert');
            $alert.find('.content').text(returndata.msg);
            $alert.modal('open');
        }
    });
});
});
@endsection
