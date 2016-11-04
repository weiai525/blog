<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\ClassController;
use App\Http\Controllers\Portal\ArticleController;
use App\Models\Portal\Article;
use App\Models\Portal\ArticleClass;
use App\Models\Portal\ArticleContent;
use Auth;
use DB;
use Request;
use Validator;
use Storage;

class ArticleController extends Controller
{
    
    private $errors;
    public function __construct()
    {
        //$this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }
    public function index()
    {
        $list = $this->getList();
        return tpl('portal.user_post-list',['list'=>$list]);
    }
    public function getAdd()
    {
        $class = new ClassController();
        $class = $class->getList(Auth::guard('web')->user()['id'],false);
        /*if (is_object($class)) {
            $class = $class->toArray();
        }*/
        return tpl('portal.user_post', ['class' => $class]);
    }
    public function getEdit($article_id)
    {
        $article = new ArticleController();
        $article = $article->getDetail($article_id);
        //print_r($article);
        $class = new ClassController();
        $class = $class->getList(Auth::guard('web')->user()['id'],false);
        return tpl('portal.user_post-edit', ['article' => $article,'class' => $class]);
    }
    /**
     * 修改处理方法
     * @author cuibo weiai525@outlook.com at 2016-10-18
     * @return [type] [description]
     */
    public function postEdit()
    {
        if (!Request::has('id')) {
            return $this->error(400102);
        }
        $article = new ArticleController();$requestdata = Request::only('id','title', 'content', 'is_comment', 'type', 'class_id');
        $this->validator($requestdata);
        $requestdata['is_comment'] = (boolean)$requestdata['is_comment'];
        $requestdata['modify_at'] = time();
         $requestdata['abstract'] = mb_substr(str_replace([' ','&nbsp;'],'',strip_tags($requestdata['content'])), 0,250);
        if ($this->update($requestdata)) {
            return $this->success();
        }
        return $this->error(500301,array_pop($this->errors));
    }
    public function postDel()
    {
        if (!Request::has('id')) {
            return $this->error(400102);
        }
        $ids = explode(',',Request::input('id'));
        $data['total'] = count($ids);
        $data['success'] = 0;
        $data['fail'] = 0;
        foreach ($ids as $key => $value) {
            if ($this->delete($value)) {
               $data['success']++;
            }else{
                $data['fail']++;
            }
        }
        return $this->success($data);
    }
    /**
     * 添加文章
     * description
     * @author cuibo weiai525@outlook.com at 2016-10-07
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function postAdd()
    {
        $requestdata = Request::only('title', 'content', 'is_comment', 'type', 'class_id');
        $this->validator($requestdata);
        $requestdata['u_id'] = Auth::guard('web')->user()['id'];
        $requestdata['is_comment'] = (boolean)$requestdata['is_comment'];
        $requestdata['modify_at'] = time();
        $requestdata['abstract'] = mb_substr(str_replace([' ','&nbsp;'],'',strip_tags($requestdata['content'])), 0,250);
        $this->dealImageUrl($requestdata['content']);
        if ($this->create($requestdata)) {
            return $this->success();
        }
        return $this->error(500201,array_pop($this->errors));
    }
    /**
     * [validator description]
     * @author cuibo weiai525@outlook.com at 2016-10-11
     * @return [type] [description]
     */
    protected function validator(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'required|mb_max:35',
            'content' => 'required|mb_max:600000',
            //'abstract' => 'required|max:500',
            'is_comment' => 'required|in:1,2',
            'type' => 'required|in:1,2,3',
           // 'p_id' => 'required',
            'class_id' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->error(400102, $validator->errors()->first());
        }
    }

    /**
     * 创建新文章
     *
     * @param  array $data
     * @return boolean
     */
    private function create(array $data)
    {
        DB::beginTransaction();
        $content = $data['content'];
        unset($data['content']);
        try {
            $article = Article::create($data);
            if (!$article) {
                throw new Exception('crate article error', 1);
            }
            if (!ArticleContent::create(['content' => $content, 'id' => $article->id])) {
                throw new Exception("crate article_content error", 1);
            }
            DB::commit();
            return true;
            //中间逻辑代码 DB::commit();
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            DB::rollBack();
            //接收异常处理并回滚 DB::rollBack();
            return false;
        }
    }
    /**
     * 修改文章
     * @author cuibo weiai525@outlook.com at 2016-10-18
     * @param  array  $data 同create方法
     * @return boolean       
     */
    private function update(array $data)
    {
        DB::beginTransaction();
        $content = $data['content'];
        $id = $data['id'];
        unset($data['content']);
        unset($data['id']);
        try {
            $article = Article::where('id',$id)->where('u_id',Auth::guard()->user()['id'])->update($data);
            if ($article === false) {
                throw new Exception('update article error', 1);
            }
            if (ArticleContent::where('id',$id)->update(['content' => $content]) === false) {
                throw new Exception("update article_content error", 1);
            }
            DB::commit();
            return true;
            //中间逻辑代码 DB::commit();
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            DB::rollBack();
            //接收异常处理并回滚 DB::rollBack();
            return false;
        }
    }
    private function delete($id,$u_id=null)
    {
       DB::beginTransaction();
        try {
            if ($u_id) {
                $article = Article::where('id',$id)->where('u_id',Auth::guard()->user()['id'])->delete();
            }else{
                $article = Article::where('id',$id)->delete();
            }
            if ($article === false) {
                throw new Exception('update article error', 1);
            }
            $content = ArticleContent::where('id',$id)->first();
            $this->deleteImage($content->content);
            if (ArticleContent::where('id',$id)->delete() === false) {
                throw new Exception("update article_content error", 1);
            }
            DB::commit();
            return true;
            //中间逻辑代码 DB::commit();
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            DB::rollBack();
            //接收异常处理并回滚 DB::rollBack();
            return false;
        } 
    }
    /**
     * 正则原文图片链接，删除文件
     * @author cuibo weiai525@outlook.com at 2016-10-22
     * @param  [type] $content [description]
     * @return [type]          [description]
     */
    private function deleteImage($content)
    {
        $zz = '/<img.*?src="(.*?)".*?>/';
        $arr = [];
        preg_match_all($zz, $content, $arr);
        foreach ($arr[1] as $key => $value) {
            if (Storage::disk('public')->has($value)) {
                Storage::disk('public')->delete($value);
            }
        }
    }
    /**
     * 获取文章列表
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @return [type] [description]
     */
    private function getList()
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
     * 处理正文图片链接，将正文包含的图片移动到image目录，并将正文中的img链接替换为正确连接
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @param  [type] &$content [description]
     * @return [type]           [description]
     */
    private function dealImageUrl(&$content)
    {
        $zz = '/<img.*?src=".*?\/imagetmp\/(.*?)".*?>/';
        $arr = [];
        preg_match_all($zz, $content, $arr);
        foreach ($arr[1] as $key => $value) {
            if (Storage::disk('public')->has('imagetmp/'.$value)) {
                Storage::disk('public')->move('imagetmp/'.$value,'image/'.$value);
            }
        }
        //正则替换 将imagetmp 替换为iamge
        $content = preg_replace('/(<img.*?src=".*?\/)(imagetmp\/)(.*?)(".*?>)/', '\1image/\3\4', $content);
        //print_r($arr);
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

}
