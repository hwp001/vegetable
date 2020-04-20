<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Client extends Model
{
    //对应表
    protected $table = 'bs_clients';
    //绑定是否可以批量赋值
    protected $guarded = [];

    //新增用户
    public function addClients($data)
    {
        return self::save($data);
    }

    //根据openid 获取用户信息
    public function getInfoByOpenid($data)
    {
       $res =  DB::table('bs_mps')
            ->leftJoin('bs_clients','bs_mps.cid','bs_clients.id')
            ->where('bs_mps.wx_openid',$data['openId'])
            ->get(['bs_clients.id as cid','bs_mps.id as mid','username','name','avatar','phone','email','address','decs','mp_openid','wx_openid','unionid']);
       return $res;
    }

}
