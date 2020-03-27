<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Mp\UtilsController as MP_Utils;
use Illuminate\Support\Facades\Redis;

class UsersController extends Controller
{
    //获取用户信息
    public function getClientsInfo()
    {
        if (Redis::exists('openid')) {
            $openid = Redis::get('openid');
            $users = MP_Utils::app()->user->get($openid);
            //返回数组
            $data = [
                'username' => $users['nickname'],
                'address'  => $users['province'].$users['country'],
                'avatar'   => $users['headerimgurl'],
                'ip'       => $_SERVER['REMOTE_ADDR']
            ];
            return $users;
        } else {
            return '用户不存在';
        }
    }
}
