<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
class Goods extends Model
{
    protected $table = 'bs_goods';
    protected $guarded = [];

    //修改器
    public function getBuyStateAttribute($value)
    {
        switch ($value){
            case 0 : return '购买';break;
            case 1 : return '预订';break;
        }
    }

    //将图片存入图片表，然后取出id存入商品表
    public function setImgIdsAttribute($pictures)
    {
        $idStr = '';
        if (is_array($pictures)) {
            foreach ($pictures as $k => $v) {
               $idStr .= Image::create(['imgUrl' => $v])->id.",";
            }
            $idStr = substr($idStr,0,strripos($idStr,','));
        } else {
            $idStr .= Image::create(['imgUrl' => $pictures])->id;
        }
        $this->attributes['img_ids'] = json_encode($idStr);
    }

    public function getImgIdsAttribute($pictures)
    {
//        return json_decode($pictures, true);
        //将获得的 img编号 转换为 图片地址
        return ToolController::IdToUrlStr($pictures);
    }

    //取出特价商品
    public function getGoodsbyDiscount()
    {
        $discount = self::get()->min('discount')->where(['count','>',0]);
        $res = self::get(['id', 'title', 'price', 'discount', 'count', 'cavr'])->where('discount', $discount);
        return $res[1];
    }

    /**
     * 目前只判断一个字段
     * @param $a
     * @param $b
     * @param $c
     * @return 返回商品详细数据
     */
    public function detail($a,$b,$c)
    {
        $res = DB::table('bs_goods')
            ->leftJoin('bs_goods_category as c','kind_id','c.id')
            ->where($a,$b,$c)
            ->where('bs_goods.count','>',0)
            ->get(['bs_goods.id','title','bs_goods.description','c.name as kind','img_ids as img','price','count','cfav','buy_state'])->toArray();
        //根据imgId => imgUrl
        return ToolController::IdtoUrl($res);
    }

    //获取全部商品详情  商品数量不为0
    public function allDetail()
    {
        $res = DB::table('bs_goods')
            ->leftJoin('bs_goods_category as c','kind_id','c.id')
            ->where('bs_goods.count','>',0)
            ->get(['bs_goods.id','title','bs_goods.description','c.name as kind','img_ids as img','price','count','cfav','buy_state'])->toArray();
        //根据imgId => imgUrl
        return ToolController::IdtoUrl($res);
    }

    //根据关键字 模糊搜索商品 并返回首列id
    public function searchGood($data)
    {
        $res = DB::table('bs_goods')
            ->leftJoin('bs_goods_category as c','bs_goods.kind_id','c.id')
            ->where('c.name','like','%'.$data['value'].'%')
            ->where('bs_goods','>',0)
            ->orWhere('bs_goods.title','like','%'.$data['value'].'%')
            ->get('bs_goods.id');
        return $res[0]->id;
    }

}


