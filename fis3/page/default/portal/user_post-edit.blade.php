@extends('widget.default.layout.usercenter') @section('content')

<div>
    <form class="form form-horizontal" role="form" action="/user/article/postedit">
        {!! csrf_field()!!}
        <input type="" name="id" value="{{$article['id']}}" style="display:none">
        <div class="form-group">
            <div class="col-sm-2">
                <select class="form-control" name="type">
                  <option value="1">原创</option>
                  <option value="2">转载</option>
                </select>
            </div>
            <div class="col-sm-8">
                <input type="text" class="form-control" min="6" max="15" required="required" name="title" placeholder="标题..." value="{{$article['title']}}">
            </div>

            <div class="col-sm-2">
               <select class="form-control" name="class_id">
               @foreach ($class as $key => $value)
                  <option value="{{$value['id']}}">{{$value['name']}}</option>
               @endforeach
                  <option value="0">未分类</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <textarea id="editor" name="content" value="" autofocus>{!!$article['content']!!}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-5">
                <input type="checkbox" name="is_comment">允许评论
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-5">
                <div class="alert alert-info" role="alert" style="display: none">
                    <span></span>
                </div>
            </div>  
            <div class="col-sm-3 col-sm-offset-4">
                <button type="submit" class="btn btn-primary btn-block">保存</button>
            </div>
        </div>
</div>
</form>
</div>
@require('/static/css/simditor.css')
@require('/static/js/simditor/jquery.min.js') 
@require('/static/js/simditor/module.js') 
@require('/static/js/simditor/hotkeys.js') 
@require('/static/js/simditor/uploader.js') 
@require('/static/js/simditor/simditor.js') 
@endsection 
@section("script")
$(document).ready(function(){
var editor = new Simditor({ textarea: $('#editor'), toolbar:['title','bold','italic','underline','strikethrough','fontScale','color', 'ol' ,'ul' ,'blockquote','code','table','link','image','hr','indent','outdent','alignment' ], 
      upload:{ url:'ok' }, 
      pasteImage:true }); 
      }); 
$('form').submit(function(e){ 
e.preventDefault(); 
$('.alert-info').hide(); 
var url = $(this).attr('action'); 
var data = $(this).serializeArray(); 
$.ajax({ 
url:$(this).attr('action'), 
async:true, 
data:data, type:'post', 
success:function(data){ 
if(data['code'] == 0){
 window.location.href = '/user/article' 
 }else{
   $('.alert-info').html(data['msg']); 
   $('.alert-info').show(); 
} 
}, 
error:function(res){ 
   $('.alert-info').html('系统错误'); 
   $('.alert-info').show(); 
 }
 }); }); 
 @endsection
