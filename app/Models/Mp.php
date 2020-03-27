<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mp extends Model
{
    //关联表
    protected $table = 'bs_mps';
    //不可批量存入
    protected $guarded = [];
    //反向关联客户表
    public function client()
    {
        return $this->belongsTo('App\Models\Client','cid');
    }
    //查找openid
    public function findOpenid($openid)
    {
        return self::where([
            'mp_openid' => $openid,
            'state'  => 0
        ])->first();
    }

}
