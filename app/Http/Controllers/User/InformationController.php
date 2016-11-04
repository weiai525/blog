<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Auth;
use Request;
use App\Models\Auth\User;

class InformationController extends Controller
{
    public function index($u_id)
    {
        $user = $this->getUserInfo($u_id);
        return tpl('');

    }

    public function getModifyImage()
    {
        return tpl('user.image-index');
    }
    public function postModifyImage()
    {
        $photo = Request::input('base64', 'base64');
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $photo, $result)) {
            $base64 = str_replace($result[1], '', $photo);
            $image = base64_decode($base64);
            if (!$image) {
                return $this->error(400302);
            }
            $imageInfo = getimagesizefromstring($image);
            if ($imageInfo[0] == $imageInfo[1] && $imageInfo[0] == 300 && in_array($imageInfo['mime'], ['image/png', 'image/jpg', 'image/bmp', 'image/jpeg']) && strlen($image) / 1024 / 1024 <= 2) {
                $filename = date('Ymdhis').str_random(6). '.' . substr($imageInfo['mime'], 6);
                $path =public_path().'/image/avatar/';
                if (!file_exists($path)) {
                    mkdir($path);
                }
                file_put_contents($path . $filename, $image);
                $user = new User();
                $userinfo = $user->where('id',Auth::user()['id'])->first();
                //删除原头像文件
                $originfile = public_path().$userinfo['avatar'];
                if (file_exists($originfile)) {
                    unlink($originfile);
                }
                User::where('id',Auth::user()['id'])->update(['avatar'=>'/image/avatar/'.$filename]);
                return $this->success();
            } else {
                return $this->error(400303);
            }
        } else {
            return $this->error(400302);
        }
    }

    private function getUserInfo($u_id)
    {
        return User::where('id',$u_id)->first();
    }
}
