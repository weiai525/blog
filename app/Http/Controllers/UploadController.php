<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Request;

//use

class UploadController extends Controller
{
    private $filename;
    private $file_type;
    private $config;

    public function __construct()
    {
        $this->config = config('upload.file');
    }
    public function index()
    {
        $type = Request::input('type');
        switch ($type) {
            case 'file':
                $this->config = config('upload.file');
                return $this->uploadFile();
                break;

            case 'image':
                $this->config = config('upload.image');
                return $this->uploadImage();
                break;

            case 'image_simditor':
                $this->config = config('upload.image');
                return $this->uploadImageSimditor();
                break;

            default:
                return $this->error(500301);
                break;
        }
    }
    /**
     * 上传文件
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @return [type] [description]
     */
    public function uploadFile()
    {
        $pathFormat = $this->config['pathFormat'];
        $maxSize = $this->config['size'];
        $fieldName = $this->config['fieldName'];
        $result = $this->upload($fieldName,$pathFormat, $maxSize);
        if ($result) {
            //可进行后一步更多操作
            return $this->success();
        }
        return $this->error(500301);
    }
    /**
     * 上传图片
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @return [type] [description]
     */
    public function uploadImage()
    {
        $pathFormat = $this->config['pathFormat'];
        $maxSize = $this->config['size'];
        $fieldName = $this->config['fieldName'];
        $result = $this->upload($fieldName,$pathFormat, $maxSize);
        if ($result) {
            //可进行后一步更多操作
            return $this->success();
        }
        return $this->error(500301);
    }
    /**
     * simidor上传图片
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @return [type] [description]
     */
    public function uploadImageSimditor()
    {
        $pathFormat = $this->config['pathFormat'];
        $maxSize = $this->config['size'];
        $fieldName = $this->config['fieldName'];
        $result = $this->upload($fieldName,$pathFormat, $maxSize);
        if ($result) {
            //可进行后一步更多操作
            return response()->json(['file_path'=>$result]);
        }
        return $this->error(500301);
    }
    /**
     * 核心上传操作
     * @author cuibo weiai525@outlook.com at 2016-10-19
     * @param  string  $path     保存路径
     * @param  string  $filename 文件名不包含扩展名，使用源文件扩展名
     * @param  integer $max_size 允许的文件大小
     * @return             返回false或成功操作的文件名
     */
    private function upload($fieldName,$pathFormat, $maxSize = 20480000)
    {
        if (!Request::hasFile($fieldName)) {
            return false;
        }
        //获取文件实例
        $file = Request::file($fieldName);
        if (!$file->isValid()) {
            return false;
        }
        $path = $this->getPathByFormat($pathFormat, $file->getClientOriginalName());
        $pathArr = explode('/', $path);
        $filename = array_pop($pathArr);
        $path = implode('/', $pathArr) . '/';
        if ($file->getClientSize() > $maxSize) {
            return false;
        }
        //获取文件扩展名
        $filetype = $file->guessExtension();
        $filename = $filename . '.' . $filetype;
        if (!file_exists(base_path() . $path)) {
            mkdir(base_path() . $path);
        }
        if (!$file->move(base_path() . $path, $filename)) {
            return false;
        }
        //替换掉pubic目录，fis3环境下自动缺省public目录/
        //如不是fis3环境可以注释掉
        $path = str_replace('public/', '', $path);
        return $path . $filename;
    }
    private function uploadBase64($fieldName,$pathFormat, $maxSize = 20480000)
    {
        $photo = Request::input('base64', 'base64');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $photo, $result)) {
            $base64 = str_replace($result[1], '', $photo);
            $image = base64_decode($base64);
            if ($image) {
                $imageInfo = getimagesizefromstring($image);
                if ($imageInfo[0] == $imageInfo[1] && $imageInfo[0] == 300 && in_array($imageInfo['mime'], ['image/png', 'image/jpg', 'image/bmp', 'image/jpeg']) && strlen($image) / 1024 / 1024 <= 2) {
                    $filename = md5($this->user_id) . '.' . substr($imageInfo['mime'], 6);
                    $path =public_path().'image/avatar/';
                    if (!file_exists($path)) {
                        mkdir($path);
                    }
                    file_put_contents($path . $filename, $image);
                    model('userInfo')->where('user_id', $this->user_id)->update(['image' => $filename]);
                    return $this->success('头像修改成功');
                } else {
                    return $this->error('头像格式不对');
                }
            }
            return $this->error();
        } else {
            return $this->error();
        }
    }
    /**
     * 跟据路径格式转化为实际的路径
     * @author cuibo weiai525@outlook.com at 2016-10-20
     * @param  [type] $format [description]
     * @param  string $clientOriginalName 原始文件名，不含扩展名
     * @return [type]         [description]
     */
    private function getPathByFormat($format, $clientOriginalName)
    {
        /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
        /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
        /* {time} 会替换成时间戳 */
        /* {yyyy} 会替换成四位年份 */
        /* {yy} 会替换成两位年份 */
        /* {mm} 会替换成两位月份 */
        /* {dd} 会替换成两位日期 */
        /* {hh} 会替换成两位小时 */
        /* {ii} 会替换成两位分钟 */
        /* {ss} 会替换成两位秒 */
        /* 非法字符 \ =>* ? " < > | */
        $time = time();
        //过滤非法字符
        $format = str_replace($this->config['illegalCharacter'], '', $format);
        //替换随机字符串
        $arr = [];
        if (preg_match('/\{rand:([0-9]*)\}/', $format, $arr)) {
            $format = preg_replace('/\{rand:([0-9]*)\}/', str_random(@$arr[1]), $format);
        }
        $search = ['{filename}', '{time}', '{yyyy}', '{yy}', '{mm}', '{dd}', '{hh}', '{ii}', '{ss}'];
        $replace = [$clientOriginalName, $time, date('Y'), date('y'), date('m'), date('d'), date('H'), date('i'), date('s')];
        $format = str_replace($search, $replace, $format);
        return $format;

    }
}
