<?php

use App\Models\Auth\User;
if (!function_exists('tpl')) {
    /**
     * 用法与view()一样，使用该函数自动返回当前模板下的视图
     * @author cuibo weiai525@outlook.com at 2016-10-13
     * @param  [type] $view      [description]
     * @param  array  $data      [description]
     * @param  array  $mergeData [description]
     * @return [type]            [description]
     */
    function tpl($view = null, $data = [], $mergeData = [])
    {
        return view(config('app.tpl_path') . '.' . $view, $data, $mergeData);
    }
}

if (!function_exists('str_omit')) {
    /**
     * 省略态字符串
     * @author cuibo weiai525@outlook.com at 2016-10-14
     * @param  string $string 输入字符串
     * @param  integer $number 截取的字符个数
     * @return string         返回字符串
     */
    function str_omit($string, $number)
    {
        $len = mb_strlen($string);
        if ($number < $len && $number > 0) {
            return mb_substr($string, 0, $number).'...';
        }
        return $string;
    }
}
if (!function_exists('get_user_info')) {
    /**
     * 获取用户信息
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @param   $u_id [用户id]
     * @return [type]       [description]
     */
    function get_user_info($u_id)
    {
        $user  = new User();
        $user = $user->where('id',$u_id)->first();
        if (is_object($user)) {
            return $user->toArray();
        }
        return [];
    }
}
