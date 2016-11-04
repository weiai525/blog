@extends('widget.default.layout.usercenter')
@section('content')
<div class="modal fade" id="addclassModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">新增分类</h4>
      </div>
      <div class="modal-body" style="background-color:rgb(245,245,245)">
      <form class="form-inline" role="form" action="/user/class/postadd" id="form-addclass">
            {!!csrf_field()!!}
          <div class="row">
                  <div class="form-group col-sm-8">
                    <input type="text" class="form-control" placeholder="名称" name="name" required>
                  </div>
                  <button type="submit" class="btn btn-default">保存</button>
          </div>
        </form>
      </div><!-- 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary">保存</button>
      </div> -->
    </div>
  </div>
</div>
<div class="modal fade" id="editclassModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">修改分类</h4>
      </div>
      <div class="modal-body" style="background-color:rgb(245,245,245)">
      <form class="form-inline" role="form" action="/user/class/postedit" id="form-editclass">
            {!!csrf_field()!!}
            <input type="text" value="" name="id" class="hidden">
          <div class="row">
                  <div class="form-group col-sm-6">
                    <input type="text" class="form-control" placeholder="名称" name="name" required>
                  </div>
                  <button type="submit" class="btn btn-default">保存</button>
          </div>
        </form>
      </div><!-- 
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary">保存</button>
      </div> -->
    </div>
  </div>
</div>

<div class="modal fade" id="delclassModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">关闭</span></button>
        <h4 class="modal-title">确定删除该分类？</h4>
      </div>
      <div class="modal-body" style="background-color:rgb(245,245,245)">
      删除该分类后，该分类下的文章将自动移动到未分类
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
        <button type="button" class="btn btn-primary" id="delclass-submit">确定</button>
      </div>
    </div>
  </div>
</div>
<div class="panel panel-default">
<div class="panel-heading">
    <a href="#" data-toggle="modal" data-target="#addclassModal" data-backdrop="static">添加</a>
    <a href="#" data-toggle="modal" id="edit-click">编辑</a>
    <a href="#" data-toggle="modal" id="edit_complete-click" style="display: none">完成</a>
</div>
<div class="panel-body">
    @foreach ($class as $key => $value)
    <div class="nav-item text-truncate">
        <div class="nav-item-del">
            <span class="glyphicon glyphicon-remove" data-id={{$value['id']}}></span>
        </div>
        <div class="nav-item-content">
            <span class="glyphicon glyphicon-pencil nav-item-edit" data-id={{$value['id']}}></span>
            <span><a href="">
            {{$value['name']}}
            </a></span>
        </div>
    </div>
    @endforeach
</div>
<!-- HTML to write -->
<a href="#" data-toggle="tooltip" title="Some tooltip text!">Hover over me</a>

<!-- Generated markup by the plugin -->
<div class="tooltip top" role="tooltip">
  <div class="tooltip-arrow"></div>
  <div class="tooltip-inner">
    Some tooltip text!
  </div>
</div>
</div>
@endsection
@section('script')
var delete_id = '';
$('#form-addclass').submit(function(e){ 
    e.preventDefault(); 
    var url = $(this).attr('action'); 
    var data = $(this).serializeArray(); 
    $.ajax({ 
    url:$(this).attr('action'), 
    async:true, 
    data:data, type:'post', 
    success:function(data){ 
    if(data['code'] == 0){
       alert('添加成功');
       $('form input').val('');
     }else{
       alert(data['msg']);
    } 
    }, 
    error:function(res){ 
       alert('系统错误');
     }
     }); 
}); 
$('#form-editclass').submit(function(e){ 
    e.preventDefault(); 
    var url = $(this).attr('action'); 
    var data = $(this).serializeArray(); 
    $.ajax({ 
    url:$(this).attr('action'), 
    async:true, 
    data:data, type:'post', 
    success:function(data){ 
    if(data['code'] == 0){
       alert('修改成功');
     }else{
       alert(data['msg']);
    } 
    }, 
    error:function(res){ 
       alert('系统错误');
     }
    }); 
}); 
$('#edit-click').on('click',function(){
    $('.nav-item-edit').show();
    $('.nav-item-del').show();
    $('#edit-click').hide();
    $('#edit_complete-click').show();
});
$('#edit_complete-click').on('click',function(){
    $('.nav-item-edit').hide();
    $('.nav-item-del').hide();
    $('#edit-click').show();
    $('#edit_complete-click').hide();
});
$('.nav-item-del').on('click',function(){
    var id = $(this).find('span').data('id');
    delete_id = id;
    $('#delclassModal').modal({backdrop:'static'});

});
$('.nav-item-edit').on('click',function(){
    var id = $(this).data('id');
    $('#form-editclass input[name=id]').val(id)
    $('#editclassModal').modal({backdrop:'static'});
});
$('#delclass-submit').on('click',function(){
    $.ajax({ 
    url:'/user/class/del', 
    async:true, 
    data:{id:delete_id}, type:'get', 
    success:function(data){ 
    if(data['code'] == 0){
       alert('删除成功');
     }else{
       alert(data['msg']);
    } 
    }, 
    error:function(res){ 
       alert('系统错误');
     }
    }); 
});
@endsection
