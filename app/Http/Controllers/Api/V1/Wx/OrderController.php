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
}
