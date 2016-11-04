<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>用户注册</title>
    @framework('/static/js/mod.js') @require('/static/css/bootstrap.min.css') @placeholder('styles')
</head>

<body>
    <nav class="navbar navbar-default" style="margin:0px">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
              
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li class=""><a href="/">首页<span class="sr-only">(current)</span></a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/auth/login">登录</a></li>
                    <li><a href="/auth/register">注册</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
    <div class="container">
        <div class="container">
            <div class="row" style="margin-top:50px;">
                <div class="col-xs-12 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-default">
                    <div class="panel-heading">新用户注册</div>
                        <div class="panel-body">
                            <form class="form form-horizontal" role="form" action="/auth/register">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">用户名：</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" min="6" max="15" required="required" name="name" placeholder="用户名">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">邮箱：</label>
                                    <div class="col-sm-5">
                                        <input type="text" class="form-control" min="6" max="15" required="required" name="email" placeholder="example@exaple.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">密码：</label>
                                    <div class="col-sm-5">
                                        <input type="password" min="6" max="15" required="required" class="form-control" name="password" placeholder="密码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password" class="col-sm-2 control-label">重复密码：</label>
                                    <div class="col-sm-5">
                                        <input type="password" min="6" max="15" required="required" class="form-control" name="password_confirmation" placeholder="密码">
                                    </div>
                                </div>
                                <div class="form-group" id="loginverifycode">
                                    <label for="code" class="col-sm-2 control-label">验证码</label>
                                    <div class="col-sm-5">
                                        <input type="text" required class="form-control" autocomplete="off" name="captcha" id="code" placeholder="验证码">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-2">
                                        <img src="{{captcha_src()}}" id="captcha">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-2">
                                        <input type="checkbox" name="remember-me">记住密码
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-2">
                                        <button type="submit" class="btn btn-primary btn-block">登录</button>
                                    </div>
                                    <div class="col-sm-5 col-sm-offset-2">
                                        <span id="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-5 col-sm-offset-2">
                                        <a class="btn btn-link" href="/password/reset"><small>忘记密码</small></a>
                                        <a class="btn btn-link am-fr" href="register"><small>注册</small></a>
                                    </div>
                                </div>
                        </div>
                        </form>
                        <div class="alert alert-warning" role="alert" style="display:none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
@script() 
var $ = require('/components/jquery.min'); 
var jQuery = $; 
require('/components/bootstrap.min');
var check = require('/components/check') 
$('#captcha').on('click',function(){
    $(this).attr('src',$(this).attr('src')+Math.random());
});
$('form').submit(function(e){
    $('.alert-warning').hide();
    e.preventDefault();
    var url = $(this).attr('action');
    var data = $(this).serializeArray();
    $.ajax({
            url:$(this).attr('action'),
            async:true,
            data:data,
            type:'post',
            success:function(data){
                if(data['code'] == 0){
                    window.location.href = data['data']['redicret'];
                }else{
                    $('#captcha').attr('src',$('#captcha').attr('src')+Math.random());
                    $('.alert-warning').html(data['msg']);
                    $('.alert-warning').show();
                }
            },
            error:function(res){
                $('#captcha').attr('src',$('#captcha').attr('src')+Math.random());
                $('.alert-warning').html('系统出错啦');
                $('.alert-warning').show();
            }
    });
});
@endscript
@placeholder('framework') 
@placeholder('scripts')

</html>
