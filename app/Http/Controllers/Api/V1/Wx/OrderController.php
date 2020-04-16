<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //新增订单
    public function addOrder(Request $request)
    {
        $data = $request->all();
        $res = (new Order())->addOrder($data);
        if ($res) {
            return json_encode(['statu'=>1,'data'=>$res]);
        } else {
            return json_encode(['statu'=>0,'err'=>'订单新增失败']);
        }
    }

    //根据 openid 订单状态获取订单
    public function getOrder(Request $request)
    {
        $data = $request->all();
        $res = (new Order())->getOrder($data);
        if (!$res){
            return json_encode(['statu'=>0,'err'=>'数据获取失败']);
        } else {
            return json_encode(['statu'=>1,'data'=>$res]);
        }
    }

    //根据openid 订单id 改变订单状态
    public function cancelOrder(Request $request)
    {
        $data = $request->all();
        $bool = (new Order())->cancelOrder($data,2);
        if ($bool) {
            return json_encode(['statu' => 1]);
        } else {
            return json_encode(['statu' => 0, 'err' => '订单取消失败']);
        }
    }

    //根据openid 订单id 改变订单状态
    public function recoverOrder(Request $request)
    {
        $data = $request->all();
        $bool = (new Order())->cancelOrder($data,0);
        if ($bool) {
            return json_encode(['statu' => 1]);
        } else {
            return json_encode(['statu' => 0, 'err' => '订单取消失败']);
        }
    }

    //根据openid 订单id 改变订单状态
    public function signOrder(Request $request)
    {
        $data = $request->all();
        $bool = (new Order())->cancelOrder($data,1);
        if ($bool) {
            return json_encode(['statu' => 1]);
        } else {
            return json_encode(['statu' => 0, 'err' => '订单取消失败']);
        }
    }


    //根据openid 订单id 获取订单信息
    public function getOrderById(Request $request)
    {
        $data = $request->all();
        $res = (new Order())->getOrderById($data);
        if (!empty($res)) {
            return json_encode(['statu' => 1, 'data' => $res]);
        } else {
            return json_encode(['statu' => 0, 'err' => '订单信息获取失败']);
        }
    }
}
