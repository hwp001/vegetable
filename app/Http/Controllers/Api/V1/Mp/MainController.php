<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\V1\Mp\TokenController as Token_MP;
use App\Http\Controllers\Api\V1\Mp\MessageController as Message_MP;
use App\Http\Controllers\Api\V1\Mp\AccessTokenController as AccessToken_MP;
use App\Http\Controllers\Api\V1\Mp\ClientsController as Users_MP;
use Illuminate\Support\Facades\Redis;

class MainController extends Controller
{


    public function index(Request $request)
    {
        $input = $request->all();
        //若 验证token成功 则 echostr 全局存在 ，反之 不存在
        if (isset($input['echostr'])) {
            //每一次接入都要清空AccessToken
            Redis::del(['access_Token','openid']);
            $joinMp = (new Token_MP())->joinMp($input);
            if ($joinMp) {
                return $joinMp;
            } else {
                Log::info('接入失败');
                return '接入失败';
            }
        } else {
            //回信息
            $this->replyMessage();
        }
    }

    //回复消息
    public function replyMessage()
    {
        $AccessToken = new AccessToken_MP();
        $Message = new Message_MP();
        $Users = new Users_MP();
        //实时更新access_token
        $AccessToken->saveAccessToken();
        //消息回复 echo输出
        echo $Message->receiveMessage();
    }
}
