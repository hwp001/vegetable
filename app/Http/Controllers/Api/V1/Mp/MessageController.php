<?php

namespace App\Http\Controllers\Api\V1\Mp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\V1\Mp\UtilsController as MP_Utils;

class MessageController extends Controller
{
    //消息接收
    public function receiveMessage()
    {
        //easywechat 应用实例
        $app = MP_Utils::app();
        $app->server->push(
            function ($message) {
                //获取用户openid并保存到session中，若存在openid 说明用户触发过事件
                if (!Redis::exists('openid')) {
                    Redis::set('openid', $message['FromUserName']);
                }
                switch ($message['MsgType']) {
                    //event 菜单事件
                    case 'event':
                        switch ($message['EventKey']){
                            case 'MP_KEY_miniprogram' : return '欢迎关注小程序'; break;
                            case 'MP_KEY_GOODS' : return '特价商品'; break;
                            case 'MP_KEY_ORDERS' : return '订单详情'; break;
                            case 'MP_KEY_CLIENTS' : return '关于个人'; break;
                        };
                        break;
                    case 'text':
                        return '收到文字消息';
                        break;
                    case 'image':
                        return '收到图片消息';
                        break;
                    case 'voice':
                        return '收到语音消息';
                        break;
                    case 'video':
                        return '收到视频消息';
                        break;
                    case 'location':
                        return '收到坐标消息';
                        break;
                    case 'link':
                        return '收到链接消息';
                        break;
                    case 'file':
                        return '收到文件消息';
                    // ... 其它消息
                    default:
                        return '收到其它消息';
                        break;
                }
            }
        );
        $response = $app->server->serve();
        file_put_contents('wx\test.txt', $response, FILE_APPEND);
        return $response;
    }
    //获取用户信息


}
