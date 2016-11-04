<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',35);
            $table->string('abstract',250);//文章摘要
            $table->char('u_id',255);//兼容string类型id
            $table->tinyInteger('status')->unsigned()->default(1);// 1正常 2 草稿箱 3 回收站 4 管理员拉黑
            $table->tinyInteger('type')->unsigned()->default(1);// 1原创 2 转载 3 翻译 
            $table->tinyInteger('is_comment')->unsigned()->default(1);// 是否允许评论 1 允许 2 不允许
            $table->tinyInteger('p_id')->unsigned();// 系统板块id
            $table->tinyInteger('class_id')->unsigned();//用户个人分类id
            $table->integer('hits')->unsigned();//点击量
            $table->integer('like')->unsigned();//赞的数量
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
            $table->bigInteger('modify_at');//用户修改文章的时间，仅修改文章关键信息时手动更新
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}
