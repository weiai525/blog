<?php
namespace App\Libs;

use DB;

class Access
{
    /**
     * 检查权限
     * @param rules array  需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param user_id  int           认证用户的id
     * @param type string    如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return boolean           通过验证返回true;失败返回false
     */
    public function check($user_id, $rules, $type)
    {
        // 用户角色
        $roles = DB::table('user_role')->select('role_id')->where('user_id', $user_id)->where('status', 1)->get();
        $arr = [];
        foreach ($roles as $key => $value) {
            $arr[] = $value['role_id'];
        }
        $roles = $arr;
        // 用户拥有的权限规则
        $data = DB::table('role_rule')
            ->leftJoin('rules', 'role_rule.rule_id', '=', 'rules.id')
            ->whereIn('role_id', $roles)
            ->select('role_rule.*', 'rules.route')
            ->get();
        $list = [];
        foreach ($data as $key => $value) {
            $list[] = strtolower($value['route']);
        }
        //计算交集，不为空则表示有一条规则满足要求
        if ($type == 'or' && !empty(array_intersect($rules, $list))) {
            return true;
        }
        if (empty(array_diff($rules, $list))) {
            return true;
        }
        return false;
    }
}
