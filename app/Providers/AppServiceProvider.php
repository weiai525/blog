<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //中文字段长度，默认utf-8
        Validator::extend('mb_max', function ($attribute, $value, $parameters) {
            //var_dump(mb_strlen($value));
            return mb_strlen($value) <= $parameters[0];
        });

        //添加一个where条件后验证字段唯一性
        //unique_where:table,字段，字段，条件
        Validator::extend('unique_where', function ($attribute, $value, $parameters) {
            if (DB::table($parameters[0])
                ->where($parameters[2], $parameters[3])
                ->where($parameters[1], $value)
                ->count() > 0) {
                return false;
            }
            return true;
        });
        //排除一个值后验证唯一性
        Validator::extend('unique_except', function ($attribute, $value, $parameters) {
            if ($value == @$parameters[2]) {
                return true;
            }
            if (DB::table($parameters[0])
                ->where($parameters[1], $value)
                ->count() > 0) {
                return false;
            }
            return true;
        });
        //添加一个例外的参数，如果存在则不进行数据库查询
        Validator::extend('exists_include', function ($attribute, $value, $parameters) {
            if ($value == @$parameters[2]) {
                return true;
            }
            if (DB::table($parameters[0])
                ->where($parameters[1], $value)
                ->count() > 0) {
                return true;
            }
            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
