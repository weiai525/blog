<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use Auth;
use Request;
use App\Models\Auth\User;
use App\Models\Portal\Article;
use App\Models\Portal\ArticleClass;
use App\Models\Portal\ArticleContent;

class UserHomeController extends Controller
{
    public function index($u_id)
    {
        $user = $this->getUserInfo($u_id);
        if (!$user) {
            return ;
        }
        $user['home_url'] = config('app.url').'u/'.$user['id'];
        $list = $this->getArticleList();
        return tpl('portal.user_home',['user'=>$user,'list'=>$list]);

    }
    /**
     * 获取文章列表
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @return [type] [description]
     */
    private function getArticleList()
    {
        $list = Article::where('u_id',Auth::guard('web')->user()['id'])->paginate(15)->toArray();
        $ids = [];
        foreach ($list['data'] as $key => $value) {
            $ids[] = $value['class_id'];
        }
        $class = $this->getClassnameById($ids);
        foreach ($list['data'] as $key => $value) {
            $list['data'][$key]['class_name'] = @$class[$value['class_id']]['name'];
        }

        return $list;
    }
    /**
     * 根据id获取分类名称
     * @author cuibo weiai525@outlook.com at 2016-10-21
     * @param  array  $id [0=>'id',1=>'id',,,,]
     * @return array     [['id'=>'','name'=>''],['id'=>'','name'=>''],,,]
     */
    private function getClassnameById(array $id)
    {
        $data = ArticleClass::select('id', 'name')->whereIn('id', $id)->get();
        if (!is_object($data)) {
            return [[]]; //返回二维空数组
        }
        $ndata = [];
        //循环，将数组key设置为分类的id，方便在后面直接通过id获取数组名称
        foreach ($data as $key => $value) {
            $ndata[$value->id] = [
                'id' => $value->id,
                'name' => $value->name,
            ];
        }
        $ndata[0]=['id'=>0,'name'=>'未分类'];
        return $ndata;
    }
    private function getUserInfo($u_id)
    {
        $user = User::where('id',$u_id)->first();
        if (!is_object($user)) {
            return false;
        }
        return $user->toArray();
    }
}
