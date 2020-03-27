<?php

namespace App\Http\Controllers\Api\V1\Mp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\V1\Mp\UtilsController as MP_Utils;
class AccessTokenController extends Controller
{

    //获取access_token
    public function getAccessToken()
    {
        //获取access_token实例
        $accessToken = MP_Utils::app()->access_token;
        //$token数组 access_token expires_in
        $token = $accessToken->getToken();
        return $token;
    }
    //存入access_token，防止失效
    public function saveAccessToken()
    {
        if (!Redis::exists('access_token')) {
            $token = $this->getAccessToken();
            Redis::setex('access_token', 7000, $token['access_token']);
            Log::info('设置access_token:  '.Redis::get('access_token'));
            return '存储成功: '.Redis::get('access_token');
        }
        return Redis::get('access_token');
    }
}
