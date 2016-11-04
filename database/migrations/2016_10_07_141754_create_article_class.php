<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleClass extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_classes', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name',25);
            $table->char('u_id',255)->index();//兼容string类型id用户修改文章的时间，仅修改文章关键信息时手动更新
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_class');
    }
}
