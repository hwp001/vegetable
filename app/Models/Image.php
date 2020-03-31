<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'bs_image';
    protected $guarded = [];

    //验证图片是否存在 ，存在则返回id
    public function hasImg($ImgUrl)
    {
        return self::where('imgUrl',$ImgUrl)->first()->id;
    }
}
