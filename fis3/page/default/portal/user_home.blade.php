@extends('widget.default.layout.userhome') 
@section('title')
{{$user['name']}}_主页
@endsection
@section('content')
<div class="jumbotron">
    <h2>{{$user['name']}}的博客</h2>
    <p>{{$user['home_url']}}</p>
    <ul class="nav nav-pills" role="tablist">
      <li role="presentation" class="active"><a href="#">首页</a></li>
      <li role="presentation"><a href="#">博文目录</a></li>
      <li role="presentation"><a href="#">图片</a></li>
      <li role="presentation"><a href="#">关于我</a></li>
    </ul>
</div>
<div class="col-sm-3">
<div class="panel panel-default">
    @include('widget.default.sidebar.userinfo',['user'=>$user])
</div>
</div>
<div class="col-sm-9">
    <div class="panel">
        <div class="heading">
            
        </div>
        <div class="body">
            @foreach ($list['data'] as $key => $value)
                <div class="">
                  <a href="/article/{{$value['id']}}" class="list-group-item">
                    <h3 class="list-group-item-heading">{{$value['title']}}<small>{{date('Y-m-d',$value['created_at'])}}</small></h3>
                    <p class="list-group-item-text">{{$value['abstract']}}</p>
                  </a>
                </div>
                <hr>
            @endforeach
        </div>
    </div>
    <div>
    @include('widget.default.sidebar.pagination',['pagination'=>$list])
    </div>
</div>
@endsection 
@section("script")
$(document).ready(function(){
  
});
@endsection
