<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use DB;
use Illuminate\Http\Request;

class RbacController extends Controller
{
    public $user_id;

    /**
     * 添加角色
     * @author cuibo weiai525@outlook.com at 2016-10-23
     */
    public function addRole(Request $request)
    {
        // 添加角色时只添加name remark参数
        $this->validate($request, [
            'name' => 'reuqired|mb_max:15',
            'remark' => 'reuqired|mb_max:255',
        ]);
        $roleModel = new Role();
        $roleModel->name = $request->input('name');
        $roleModel->remark = $request->input('remark');
        if (!$roleModel->save()) {
            return $this->error('系统错误');
        }
        return $this->success();
    }
    /**
     * 删除角色
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @return [type] [description]
     */
    public function deleteRole(Request $request)
    {
        // 添加角色时只添加name remark参数
        $this->validate($request, [
            'id' => 'reuqired',
        ]);
        // 启动事务
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            Role::where('id', $id)->delete();
            RoleRule::where('role_id', $id)->delete();
            UserRole::where('role_id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();
            return $this->error(500201, '删除角色失败');
        }
        return $this->success();
    }
    /**
     * 编辑角色
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @return [type] [description]
     */
    public function editRole(Request $request)
    {
        $this->validate($request, [
            'id' => 'reuqired|integer',
            'status' => 'in:0,1',
            'name' => 'mb_max:15',
            'remark' => 'mb_max:255',
        ]);
        $data = $request->only('status', 'name', 'remark');
        if (empty($data)) {
            return $this->error(500201, '被修改的参数不能为空');
        }
        $rows = Role::where('id', $request->input('id'))->update($data);
        if ($rows === false) {
            return $this->error(500201, '系统错误');
        } elseif ($rows == 0) {
            return $this->error(500201, '角色不存在');
        } else {
            return $this->success();
        }
    }

    /**
     * 获取角色列表
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @return json [description]
     */
    public function getRoleList(Request $request)
    {
        $data = Role::select()->get()->toArray();
        if ($request->ajax()) {
            return $this->success($data);
        }
        return view('', ['list' => $data]);
    }
    /**
     * 编辑角色权限
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function editRoleRule(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'reuqired|integer',
            'rules' => 'required|JSON',
        ]);
        $role_id = $request->input('role_id');
        $rules = json_decode($request->input('rules'), 1);
        $routeData = [];
        // 构造插入数据格式
        foreach ($rules as $key => $value) {
            $routeData[] = ['role_id' => $role_id, 'rule_id' => $value];
        }
        // 启动事务
        DB::beginTransaction();
        try {
            $roleRuleModel = new RoleRule();
            $roleRuleModel->where('role_id', $role_id)->delete();
            $roleRuleModel->insert($routeData);
            DB::commit();
            return $this->success();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();
            return $this->error(500201, '编辑权限失败');
        }
    }
    /**
     * 获取指定角色的权限列表
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @return [type] [description]
     */
    public function getRoleRule(Request $request)
    {
        $this->validate($request, [
            'id' => 'reuqired|integer',
        ]);
        $data = RoleRule::where('role_id', $request->input('id'))->select()->get();
        return $this->success($data);
    }
    /**
     * 编辑用户角色
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function editUserRole(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'reuqired|integer',
            'roles' => 'required|JSON',
        ]);
        $user_id = $request->input('user_id');
        $roles = json_decode($request->input('roles'), 1);
        $routeData = [];
        // 构造插入数据格式
        foreach ($roles as $key => $value) {
            $routeData[] = ['user_id' => $user_id, 'rule_id' => $value];
        }
        // 启动事务
        DB::beginTransaction();
        try {
            $userRoleModel = new UserRole();
            $userRoleModel->where('user_id', $user_id)->delete();
            $userRoleModel->insert($routeData);
            DB::commit();
            return $this->success();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();
            return $this->error(500201, '编辑权限失败');
        }
    }
    /**
     * 获取指定角色的用户列表
     * @author cuibo weiai525@outlook.com at 2016-10-23
     */
    public function getRoleUser(Request $request)
    {
        $this->validate($request, [
            'role_id' => 'reuqired|integer',
        ]);
        $data = UserRole::where('role_id', $request->input('role_id'))->select()->get();
        return $this->success($data);
    }
    /**
     * 获取指定用户的角色列表
     * @author cuibo weiai525@outlook.com at 2016-10-23
     */
    public function getUserRole(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'reuqired|integer',
        ]);
        $data = UserRole::where('user_id', $request->input('user_id'))->select()->get();
        return $this->success($data);
    }
    /**
     * 添加权限规则
     * @author cuibo weiai525@outlook.com at 2016-10-23
     */
    public function addRule(Request $request)
    {
        $this->validate($request, [
            'name' => 'reuqired|mb_max:15',
            'route' => 'reuqired|mb_max:255',
        ]);
        $ruleModel = new Rule();
        $ruleModel->name = $request->input('name');
        $ruleModel->remark = $request->input('route');
        if (!$roleModel->save()) {
            return $this->error('系统错误');
        }
        return $this->success();
    }
    /**
     * 删除权限规则
     * @author cuibo weiai525@outlook.com at 2016-10-23
     */
    public function deleteRule()
    {
        // 添加角色时只添加name remark参数
        $this->validate($request, [
            'id' => 'reuqired',
        ]);
        // 启动事务
        DB::beginTransaction();
        try {
            $id = $request->input('id');
            Rule::where('id', $id)->delete();
            RoleRule::where('rule_id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            // 回滚事务
            DB::rollback();
            return $this->error(500201, '删除权限失败');
        }
        return $this->success();
    }
    /**
     * 编辑规则
     * @author cuibo weiai525@outlook.com at 2016-10-23
     * @return [type] [description]
     */
    public function editRule()
    {
        $this->validate($request, [
            'id' => 'reuqired|integer',
            'status' => 'in:0,1',
            'name' => 'mb_max:15',
            'route' => 'mb_max:255',
        ]);
        $data = $request->only('status', 'name', 'route');
        if (empty($data)) {
            return $this->error(500201, '被修改的参数不能为空');
        }
        $rows = Rule::where('id', $request->input('id'))->update($data);
        if ($rows === false) {
            return $this->error(500201, '系统错误');
        } elseif ($rows == 0) {
            return $this->error(500201, '规则不存在');
        } else {
            return $this->success();
        }
    }
    /**
     * 查看权限规则列表
     * @author cuibo weiai525@outlook.com at 2016-10-23
     */
    public function getRule()
    {
        $data = Rule::select()->get()->toArray();
        if ($request->ajax()) {
            return $this->success($data);
        }
        return view('', ['list' => $data]);
    }

}
