<?php

namespace App\Http\Middleware;

use Closure;

class AccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null $WeChatID
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 排除验证的路由
        $except = [];
        $path = $request->path();
        if (in_array($path, $except)) {
            return $next($request);
        }
        $user = auth()->guard('admin')->user();
        $user_id = $user['id'];
        if (check_access($user_id, [$path])) {
            return $next($request);
        } else {
            if ($request->ajax()) {
                return response()->json(['code' => -1, 'msg' => '无权限操作']);
            }
            return '无权限访问';
            //return view('wechat.tips-warn', ['message' => '请在微信内打开']);
        }
    }

}
