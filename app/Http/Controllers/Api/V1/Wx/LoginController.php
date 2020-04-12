<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Mp;
use Log,Request;
use Illuminate\Support\Facades\Redis;
class LoginController extends Controller
{
    //拿取小程序code 然后换取 sesson_key
    public function index(Request $request)
    {
        //获取小程序实例
        $app = ToolController::wxapp();
        //获取小程序传过来的code
        $code = $request::input('code');
        $response = $app->auth->session($code);
        return json_encode($response);

        /*        if (!Redis::exists('session_key')) {
            Redis::setex('session_key', 7000, $response['session_key']);
        }
        return json_encode($response);*/
    }
    //用户信息解密
    public function decode(Request $request)
    {
        //分别获取 code 加密数据 密钥
        $userInfo = $request::all();
        $code = $userInfo['code'];
        $encryptedData = $userInfo['encryptedData'];
        $iv = $userInfo['iv'];
        //获取小程序实例
        $app = ToolController::wxapp();
        //使用code 置换 session_key
        $res = $app->auth->session($code);
//        return $res;
        //解密数据 获得用户详细数据
        $answer = $app->encryptor->decryptData($res['session_key'], $iv, $encryptedData);
        //更新用户表，公众号表
        $bool = (new Mp())->addWxUserInfo($answer);
        $data['userInfo'] = $answer;
        $data['status'] = 1;
        if (!$bool) {
            $data['status'] = 0;
        }
        return json_encode($data);
    }



}
