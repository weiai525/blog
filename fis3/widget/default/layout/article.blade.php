<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="" type="image/x-icon" href="/favicon.ico" media="screen" />
    <title>
        @section("title")
        {{$pagetitle or '默认标题'}}
        @show
    </title>
    @framework('/static/js/mod.js') @require('/static/css/bootstrap.min.css') @placeholder('styles')
    @require('/static/css/common.css') @placeholder('styles')

</head>
<body class="">
    @include('widget.default.header.header')
    <div class="container" style="padding-top: 10px;">
        @section("content")
        @show
    </div>
    @include('widget.default.footer.footer')
    @placeholder('framework')
    @script()
        var $ = require('/components/jquery.min'); 
        var jQuery = $; 
        var Jquery = $; 
        require('/components/bootstrap.min');
        @section("script")
            @require('/static/css/simditor.css')
        @show
    @endscript
    @placeholder('scripts')

</body>
</html>
