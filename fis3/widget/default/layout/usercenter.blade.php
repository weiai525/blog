<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @section("title")
        {{$pagetitle or '默认标题'}}
        @show
    </title>
    @framework('/static/js/mod.js') @require('/static/css/bootstrap.min.css') @placeholder('styles')
    @require('/static/css/common.css') @placeholder('styles')

</head>
<body class="">
    @include('widget.header.usercenter-default')
    <div class="container" style="padding-top: 20px;">
    <div class="col-sm-2">
        <div class="list-group">
          <a href="#" class="list-group-item text-center">个人资料</a>
          <a href="{{route('user_image')}}" class="list-group-item text-center">我的头像</a>
          <a href="{{route('user_article')}}" class="list-group-item text-center">我的文章</a>
          <a href="{{route('user_class')}}" class="list-group-item text-center">分类管理</a>
          <a href="#" class="list-group-item text-center">Vestibulum at eros</a>
        </div>
    </div>
    <div class="col-sm-10">
        @section("content")
        @show
    </div>
    </div>
    @include('widget.footer.usercenter-default')
    @placeholder('framework')
    @script()
        var $ = require('/components/jquery.min'); 
        var jQuery = $; 
        var Jquery = $; 
        require('/components/bootstrap.min');
        @section("script")
        @show
    @endscript
    @placeholder('scripts')

</body>
</html>
