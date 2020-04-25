<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Order extends Model
{
    protected $table = 'bs_orders';
    protected $guarded = [];
    protected $dateFormat = 'Y-m-d H:i';

    //提取方式
    public function getGainWayBoolAttribute($value)
    {
        switch ($value) {
            case 0 : return '快递配送'; break;
            case 1 : return '线下自取'; break;
        }
    }
    //支付方式
    public function getPayWayBoolAttribute($value)
    {
        switch ($value){
            case 0 : return '微信支付'; break;
            case 1 : return '支付宝支付'; break;
            case 2 : return '扫码支付'; break;
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
    //更改订单状态
    public function changeStateById($id,$value)
    {
        $row = Order::where('id',$id)->update(['state'=>$value]);
        if (!empty($row)){
            return true;
        } else {
            return false;
        }
    }
    //订单是否完成
/*    public function getTrueOrderAttribute($value)
    {
        switch ($value){
            case 0 : return '未完成'; break;
            case 1 : return '已完成'; break;
            case 2 : return '已取消'; break;
        }
    }*/
//----------------------------------------------------------------------
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
        $cid = ToolController::getCid($data);
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
        return $res;
        if (!empty($res)) {
            return $res;
        } else {
            return false;
        }
    }
//-------------------------------------------------------------------------
    //根据 openid 获得订单
    public function getOrder($data)
    {
        //用openid 换取 cid
        $cid = ToolController::getCid($data);
        $dataOne = [
            'cid' => $cid,
            'state' => 1
        ];
        $res = $this->orderMain($dataOne);
        //分组
        $group = $this->groupRes($res->toArray());
        //获得未审核数据，并且将未审核数据并进分组
        array_push($group,$this->getOrderDisable($data));
        return $group;
    }
    //获得根据openid 获得审核中订单
    public function getOrderDisable($data)
    {
        $cid = ToolController::getCid($data);
        $data = [
            'cid' => $cid,
            'state' => 0
        ];
        $res = $this->orderMain($data);
        return $res;
    }

    //根据 openid 订单id 获得订单详情
    public function getOrderById($data)
    {
        //用openid 换取 cid
        $cid = ToolController::getCid($data);
        $data = [
            'cid' => $cid,
            'id'  => $data['id'],
            'state' => 1
        ];
        $res = $this->orderMain($data);
        $res[0]->goodDetail = $this->goodDetail($res[0]->goodDetail);
        //获取收货地址
        $res[0]->cargo = ((new Cargo())->getCargoById(['id' => $res[0]->cargo_id]))[0];
        return $res;
    }
    //根据 订单条件 获取订单内容
    public function orderMain($data)
    {
        $res = Order::where($data)->get(['id','cargo_id','gain_way_bool','pay_way_bool','have_way_bool','time','true_order','gid','totalCount','orderNum','totalPrice','true_order','created_at']);
        //通过 gid 换取 商品信息
        for ($i=0; $i<count($res); $i++){
            $gid_str = $res[$i]->gid;
            $res[$i] = $this->arrgid($gid_str,$res[$i]);
            if (!$res[$i]) {
                return false;
            }
        }
        return $res;
    }
    //处理 gid 0  判断是否有 ","
    public function arrgid($gid_str,$res)
    {
        $goodDetail = [];
        if (strpos($gid_str,',')){
            //存在 ","
            $gid = explode(",",$gid_str);
            for ($j=0; $j<count($gid); $j++){
                $goodRes = $this->strGid($gid[$j]);
                if ($goodRes) {
                    $goodDetail[] = $goodRes;
                } else {
                    //找不到此商品数据
                    return false;
                }
            }
        } else {
            //若不存在 则表示只有一个gid 则直接换取商品信息
            $goodDetail[] = $this->strGid($gid_str);
            if (!$goodDetail) {
                return false;
            }
         }
        $res->goodDetail = $goodDetail;
        return $res;
    }
    //处理 gid 1
    public function strGid($gid)
    {
        $goodRes = DB::table('bs_orders_good')
            ->leftJoin('bs_goods','bs_orders_good.gid','bs_goods.id')
            ->where('bs_orders_good.id',$gid)
            ->get(['bs_orders_good.id','gid','bs_goods.title','bs_goods.price','totalCount','totalPrice']);
        if (!empty($goodRes)){
            return  $goodRes[0];
        } else {
            return false;
        }
    }
    //根据订单签收状态分组
    public function groupRes($res)
    {
        $groupOne = [];
        $groupTwo = [];
        $groupZero = [];
        for ($i=count($res)-1; $i>0; $i--){
            if ($res[$i]['true_order'] == 0) {
                $groupZero[] = $res[$i];
            } elseif($res[$i]['true_order'] == 1) {
                $groupOne[] = $res[$i];
            } else {
                $groupTwo[] = $res[$i];
            }
        }
        return [
             $groupZero,
             $groupOne,
             $groupTwo
        ];
    }
    //拿取goodDetail 里面 gid 进行商品详细数据获取
    public function goodDetail($goodDetail)
    {
        for ($i=0; $i<count($goodDetail); $i++){
            $gid = $goodDetail[$i]->gid;
            $res = (new Goods())->detail('bs_goods.id','=',$gid);
            if (count($res) == 0) {
                return false;
            }
            //设定要传入的字段
            $columData = ['description','kind','img','cfav','buy_state'];
            for ($j=0; $j<count($columData); $j++) {
                $colum = $columData[$j];
                $goodDetail[$i]->$colum = ($res[0])->$colum;
            }
        }
        return $goodDetail;
    }
//----------------------------------------------------------------------------
    //根据openid 订单id 改变订单状态
    public function cancelOrder($data,$true_order)
    {
        $cid = DB::table('bs_clients')
            ->leftJoin('bs_mps','bs_clients.id','bs_mps.cid')
            ->where('bs_mps.wx_openid',$data['openId'])
            ->get('bs_clients.id');
        $cid = $cid[0]->id;
        $row = Order::where([
            'cid' => $cid,
            'id' => $data['id']
        ])->update(['true_order' => $true_order]);
        if (!empty($row)){
            return true;
        } else {
            return false;
        }
    }
}



