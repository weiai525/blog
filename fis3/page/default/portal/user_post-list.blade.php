@extends('widget.default.layout.usercenter') @section('content')

<div>
<table class="table table-bordered">
<caption>
<a type="button" class="btn btn-success btn-sm" href="/user/article/postadd">新增</a>
<button type="button" class="btn btn-info btn-sm disabled" id="add-class">修改分类</button>
<button type="button" class="btn btn-danger btn-sm disabled" id="delete-all">删除</button>
<form class="navbar-form navbar-right" role="search" style="margin: 0px;">
        <div class="form-group">
            <select class="form-control" name="type">
              <option value="1">原创</option>
              <option value="2">转载</option>
            </select>
          <input type="date" class="form-control">
          <input type="date" class="form-control">
          <input type="text" class="form-control" placeholder="..">
        </div>
        <button type="submit" class="btn btn-default">搜索</button>
</form>
</caption>
  <thead>
    <tr>
      <th style="width: 50px;"><input type="checkbox" name="" class="check-all" data-id="check-list"></th>
      <th>id</th>
      <th>标题</th>
      <th style="width: 160px;">时间</th>
      <th>类型</th>
      <th>分类</th>
    </tr>
  </thead>
  <tbody id="check-list">
  @foreach ($list['data'] as $key => $value)
    <tr data-id="{{$value['id']}}">
      <td><input type="checkbox" name="" class="check-single" data-id="{{$value['id']}}"></td>
      <td>{{$value['id'] or '' }}</td>
      <td class="td-list-title">
        <span class="glyphicon glyphicon-pencil list-edit-icon" data-id="{{$value['id']}}"></span>
        <span><a href="/article/{{$value['id']}}">
            {{$value['title']}}
            </a></span>
      </td>
      <td>{{date('Y-m-d',$value['created_at'])}}</td>
      <td>{{$value['type'] or ''}}</td>
      <td>{{$value['class_name'] or ''}}</td>
    </tr>
  @endforeach
    
  </tbody>
</table>
    
</div>
<div>
@include('widget.default.sidebar.pagination',['pagination'=>$list])
</div>
@endsection
@section("script")
//跟据值删除数组元素
Array.prototype.delByValue = function(value){
  for(var k = 0; k < this.length;k++){
    if(value == this[k]){
      this.splice(k,1);
    }
  }
}
//去重
Array.prototype.unique = function(){
  if(this.length == 0){
    return [];
  }
  this.sort();
  var re=[this[0]];
  for(var i = 1; i < this.length; i++)
  {
    if( this[i] !== re[re.length-1])
    {
      re.push(this[i]);
    }
  }
  //this = re;
  return re;
}
var checked_id  = new Array();//存储当前勾选了的id

$('.check-all').on('click',function(){
  var id = $(this).data('id');
  var list = $('#'+id).find('.check-single');
  if($(this).is(':checked')){
    console.log(list.length);
    for(var k=0;k< list.length;k++){
      //$(list[k]).attr('checked', true);//该使用方式会出现checkd属性已有，但却不打勾
      $(list[k]).prop('checked', true);
      checked_id.push($(list[k]).data('id'));
    }
    $('#add-class').removeClass('disabled');
    $('#delete-all').removeClass('disabled');
  checked_id = checked_id.unique();
    console.log(checked_id);

  }else{
    for(var k=0;k< list.length;k++){
     // $(list[k]).attr('checked', false);
      $(list[k]).removeAttr('checked');
      checked_id.delByValue($(list[k]).data('id'));
    }
    $('#add-class').addClass('disabled');
    $('#delete-all').addClass('disabled');
  checked_id = checked_id.unique();
  console.log(checked_id);

  }
});
$('.check-single').on('click',function(){
   if($(this).is(':checked')){
   checked_id.push($(this).data('id'));
    $('#add-class').removeClass('disabled');
    $('#delete-all').removeClass('disabled');
  }else if(checked_id.length == 1){
    $('#add-class').addClass('disabled');
    $('#delete-all').addClass('disabled');
    checked_id.delByValue($(this).data('id'));
  }else{
    checked_id.delByValue($(this).data('id'));
  }
  checked_id = checked_id.unique();
  console.log(checked_id);
});
$('.list-edit-icon').on('click',function(){
  window.location.href = '/user/article/getedit/'+$(this).data('id');
});
$('.list-edit-icon').on('hover',function(){
  console.log('');
});
//相应删除事件
$('#delete-all').on('click',function(){
checked_id = checked_id.unique();
var id = checked_id.join(',')
  $.get('/user/article/del?id='+id,function(data){
    if(data['code'] == 0){
      alert('共'+data['data']['total']+'篇,成功'+data['data']['success']+'篇,失败'+data['data']['fail']+'篇');
    }else{
      alert(data['msg']);
    }
  })
});
@endsection
