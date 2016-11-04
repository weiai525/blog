<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\App\Article;
use App\Models\App\ArticleClass;
use App\Models\App\ArticleContent;
use Auth;
use Request;
use Validator;

class HomeController extends Controller
{

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
    public function index()
    {
        return tpl('user.home');
    }

    /**
     * 验证
     *
     * @param  array  $data
     * @return void
     */
    protected function postAddValidator(array $data)
    {
        $requestdata = Request::only('title', 'abstract', 'is_comment', 'p_id', 'class_id');
        $validator = Validator::make($requestdata, [
            'title' => 'required|mb_max:35',
            'content' => 'required|mb_max:600000',
            'abstract' => 'required|max:500',
            'is_comment' => 'required|in:1,2',
            'type' => 'required|in:1,2,3',
            'p_id' => 'required',
            'class_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error(500201, $validator->errors()->first());
        }
    }
    /**
     * 添加个人分类
     * description
     * @author cuibo weiai525@outlook.com at 2016-10-07
     *
     * @return [type] [description]
     */
    public function postAdd()
    {
        $requestdata = Request::only('name');
        $u_id = Auth::user()['id'];
        $validator = Validator::make($requestdata, [
            'name' => 'required|mb_max:25|unique_where:article_class,name,u_id,' . $u_id,
        ]);
        if ($validator->fails()) {
            return $this->error(500201, $validator->errors()->first());
        }
        $requestdata['u_id'] = $u_id;
        if (ArticleClass::create($requestdata)) {
            return $this->success();
        }
        return $this->error(500201, '系统错误');
    }
    /**
     * 文章分类列表
     * description
     * @author cuibo weiai525@outlook.com at 2016-10-11
     * @param  mixture  $u_id   [用户id]
     * @param  boolean $is_get [是否为外部请求]
     * @return mixture          [返回json或object]
     */
    public function getList($u_id,$is_get = true)
    {
        $list = ArticleClass::select('id', 'name')->where('u_id', $u_id)->get();
        //内部调用直接返回结果
        if (!$is_get) {
            return $list;
        } /*
        if (!$list) {
        return $this->error(500201,'系统错误');
        }*/
        return $this->success($list);
    }

}
