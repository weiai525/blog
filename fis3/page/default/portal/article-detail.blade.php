@extends('widget.default.layout.article') 
@section('title')
{{$data['title']}}
@endsection
@section('content')
<div class="col-sm-3">
<div class="panel panel-default">
    @include('widget.default.sidebar.userinfo',['user'=>$user])
</div>
</div>
<div class="col-sm-9">
    <div class="article-title">
      <h3>{{$data['title']}}</h3>
    </div>
    <div class="article-info">
        <p class="">
            <span>作者:</span><span>{{$data['u_name']}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <span>时间:</span><span>{{date('Y-m-d',$data['created_at'])}}</span>
        </p>
      
    </div>
    <hr>

    <div class="content">
        {!!$data['content']!!}
    </div>
</div>
@endsection 
@section("script")
$(document).ready(function(){
  
});
@endsection
