<?php

Route::get('/home', 'HomeController@index');
Route::get('/ueditor_upload', 'UeditorController@index');
Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('/', 'IndexController@index');
});
Route::group(['middleware' => ['web']], function () {
    Route::get('/test', 'TestController@index');
    Route::get('/auth/login', 'Auth\WebController@getLogin');
    Route::post('/auth/login', 'Auth\WebController@postLogin');
    Route::get('/auth/register', 'Auth\WebController@getRegister');
    Route::post('/auth/register', 'Auth\WebController@postRegister');
    Route::get('/admin/init', 'Auth\AdminController@init');
    Route::get('/admin/login', 'Auth\AdminController@getlogin');
    Route::post('/admin/login', 'Auth\AdminController@postlogin');
    Route::get('logout', 'Auth\WebController@logout');
    //通用上传路由
    Route::post('upload', ['uses'=>'UploadController@index','as'=>'upload']);
    Route::get('article/{id}', ['uses'=>'Portal\ArticleController@detail']);
    Route::get('u/{u_id}', ['uses'=>'Portal\UserHomeController@index']);
});

Route::group(['middleware' => ['web', 'auth:web']], function () {
    Route::get('/user/article', ['uses' => 'User\ArticleController@index', 'as' => 'user_article']);
    Route::get('/user', 'User\HomeController@index');
    Route::get('/user/class', ['uses' => 'User\ClassController@index', 'as' => 'user_class']);
    Route::get('/user/article/postadd', 'User\ArticleController@getAdd');
    Route::post('/user/article/postadd', 'User\ArticleController@postAdd');
    Route::get('/user/article/getedit/{id}', 'User\ArticleController@getEdit');
    Route::post('/user/article/postedit/', 'User\ArticleController@postEdit');
    Route::get('/user/article/del/', 'User\ArticleController@postDel');

    Route::post('/user/class/postadd', 'User\ClassController@postAdd');
    Route::get('/user/class/del', 'User\ClassController@postDel');
    Route::post('/user/class/postedit', 'User\ClassController@postEdit');

    Route::get('/user/image', ['uses'=> 'User\InformationController@getModifyImage','as'=>'user_image']);
    Route::Post('/user/modifyimage', ['uses'=> 'User\InformationController@postModifyImage','as'=>'user_modifyimage']);
});
Route::group(['middleware' => ['web']], function () {

});
