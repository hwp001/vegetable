<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
class Goods extends Model
{
    protected $table = 'bs_goods';
    protected $guarded = [];

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
        return json_decode($pictures, true);
    }

    //取出特价商品
    public function getGoodsbyDiscount()
    {
        $discount = self::get()->min('discount');

        $res = self::get(['id', 'title', 'price', 'discount', 'count', 'cavr'])->where('discount', $discount);

        return $res[1];

    }
}
