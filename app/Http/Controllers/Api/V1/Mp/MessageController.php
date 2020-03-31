<?php

namespace App\Http\Controllers\Api\V1\Mp;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use App\Models\Order;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\V1\Mp\UtilsController as MP_Utils;
use App\Http\Controllers\Api\V1\Mp\ClientsController as Clients;

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
                    Log::info(Redis::get('openid'));
                }

                 switch ($message['MsgType']) {
                     //event 菜单事件
                     case 'event':
                         return $this->messageTool($message['EventKey']);
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
        Log::info(Redis::get('openid'));
        //接收用户信息同时更新用户表，公众号表信息
        $bool = (new Clients())->SaveClientsInfo();
        if ($bool) {
            return $response;
        } else {
            return false;
        }

    }

    public function messageTool($key)
    {
        switch ($key){
                //特价商品
            case 'MP_KEY_GOODS' :
                $res = (new Goods())->getGoodsbyDiscount();
                return "特价商品:{$res['title']} ".PHP_EOL."原价 {$res['price']} 元 ".PHP_EOL."活动打 {$res['discount']} 折".PHP_EOL."还剩 {$res['count']} 公斤".PHP_EOL."请赶快入手吧" ;
                break;
                //订单详情
            case 'MP_KEY_ORDERS' :
                $orderData = (new Order())->getOrderInfo();
                if ($orderData) {
                    $str = "已完成订单：{$orderData['count']}".PHP_EOL;
                    for ($i=0;$i<$orderData['count'];$i++){
                        $j = $i + 1;
                        $str .= "第 {$j} 条订单:".PHP_EOL."拿货方式：{$orderData[$i]['gain_way_bool']}".PHP_EOL."支付方式：{$orderData[$i]['pay_way_bool']}".PHP_EOL."购买方式：{$orderData[$i]['have_way_bool']}".PHP_EOL."订单完成情况：{$orderData[$i]['true_order']}".PHP_EOL."---------------------".PHP_EOL;
                    }
                    return $str; break;
                } else {
                    return '暂无订单'; break;
                }

            case 'MP_KEY_miniprogram' : return '欢迎关注小程序'; break;
            case 'MP_KEY_CLIENTS' : return '关于个人'; break;
        }
    }



}
