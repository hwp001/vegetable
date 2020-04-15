<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Order extends Model
{
    protected $table = 'bs_orders';
    protected $guarded = [];

    //提取方式
    public function getGainWayBoolAttribute($value)
    {
        switch ($value) {
            case 0 : return '线下自提'; break;
            case 1 : return '快递配送'; break;
        }
    }
    //支付方式
    public function getPayWayBoolAttribute($value)
    {
        switch ($value){
            case 0 : return '微信支付'; break;
            case 1 : return '支付宝支付'; break;
            case 2 : return '现金支付'; break;
        }
    }
    //购物方式
    public function getHaveWayBoolAttribute($value)
    {
        switch ($value){
            case 0 : return '直接购买'; break;
            case 1 : return '预定'; break;
        }
    }
    //订单是否完成
    public function getTrueOrderAttribute($value)
    {
        switch ($value){
            case 0 : return '未完成'; break;
            case 1 : return '已完成'; break;
        }
    }

    //根据openid 找到cid 根据cid 匹配订单次数
    //若没订单则返回暂无订单
    //若有订单则返回订单详情
    public function getOrderInfo()
    {
        if (Redis::exists('openid')) {
            $openid = Redis::get('openid');
            //获取cid
            $cid = Mp::where('mp_openid', $openid)->get('cid')[0]->cid;
            if (!empty($cid)) {
                $res = self::where('cid',$cid)->get();
                if (empty($res)) {
                    return false;
                } else {
                    //总单数
                    $count = $res->count();
                    for ($i=0; $i<$count; $i++){
                        $data[$i] = [
                            'gain_way_bool' => $res[$i]['gain_way_bool'],
                            'pay_way_bool'  => $res[$i]['pay_way_bool'],
                            'have_way_bool' => $res[$i]['have_way_bool'],
                            'true_order'    => $res[$i]['true_order']
                        ];
                    }
                    $data['count'] = $count;
                    return $data;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //新增订单
    public function addOrder($data)
    {
        //用openid 换取 cid
        $cid = DB::table('bs_clients')
                ->leftJoin('bs_mps','bs_clients.id','bs_mps.cid')
                ->where('bs_mps.wx_openid',$data['openId'])
                ->get('bs_clients.id');
        $cid = $cid[0]->id;
        //自提 "1" 还是 快递收货 "0"
        if ($data['address'] == "1"){
            //若是自提  先创建一个默认快递地址
                //自提地址
                $address = '广东省惠州市金光大道小花园润发一号店';
                $cargo_data = [
                    'cid' => $cid,
                    'name' => $data['userName'],
                    'phone' => $data['phone'],
                    'address' => $address
                ];
                //查找是否已经创建过此默认快递地址 否则创建 是则获取id
                $res = Cargo::where($cargo_data)->get('id');
//                return $res;
                if (count($res) == 0) {
                    //若不存在 则创建并返回cargoId
                    $cargoId = Cargo::create($cargo_data)->id;
                } else {
                    //若存在 则获取快递地址id
                    $cargoId = $res[0]->id;
                }
                return $this->orderData($cid, $cargoId, $data);
        } else {
           return $this->orderData($cid, $data['cargoId'], $data);
        }
    }
    //字符串gid处理
    public function subGid($data)
    {
        //先将cartList进行解码转为二维数组
        $cartList = json_decode($data['cartList'],true);
        $gid = '';
        for ($i=0; $i<count($cartList); $i++){
            $orders_good_data = [
                'gid' => $cartList[$i]['id'],
                'totalCount' => $cartList[$i]['count'],
                'totalPrice' => $cartList[$i]['count'] * $cartList[$i]['price']
            ];
            $gid .= OrdersGood::create($orders_good_data)->id . ",";
        }
        //将 $gid 插入订单列表 多了一个 ","
        return substr($gid,0,strrpos($gid,','));
    }
    //订单数据构建
    public function orderData($cid, $cargoId, $data)
    {
        //将订单商品数据存入 订单商品表 并获取商品id
        //先将cartList进行解码转为二维数组
        //处理订单商品
        $gid = $this->subGid($data);
        $order_data = [
            'cid' => $cid,
            'cargo_id' => $cargoId,
            'gain_way_bool' => intval($data['address']),
            'pay_way_bool' => intval($data['pay']),
            'time' => $data['date']." ".$data['time'],
            'gid' => $gid,
            'totalCount' => $data['totalCount'],
            'totalPrice' => $data['totalPrice']
        ];

        $res = Order::updateOrCreate(
            ['orderNum' => $data['orderNum']],
            $order_data
        );
        if (!empty($res)) {
            return true;
        } else {
            return false;
        }
    }
}


