<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class Order extends Model
{
    protected $table = 'bs_orders';
    protected $guarded = [];

    //定义修改器
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
}
