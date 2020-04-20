<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
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

    //查找用户列表是否有这个用户，没有则插入用户表、公众号表；有的话，查公众号
    //是否有openid,有，直接插入公众号表
    //暂时用用户名来判断
    public function addWxUserInfo($data)
    {
//        return $data;
        //查找此用户是否存在
        $hasClient = Client::where('username', $data['nickName'])->first();
//        return $hasClient->id;
        //若用户存在，查找公众号表此用户时候有数据
        if(!empty($hasClient)){
            $hasMp = Mp::where('cid',$hasClient->id)->first();
            //查看此用户所在公众号表，是否已经插入openid
            if (!empty($hasMp)){
                //若已经插入，则直接更新openid
                    $bool = Mp::where('cid',$hasClient->id)->update(['wx_openid' => $data['openId']]);
                    if (!empty($bool)) {
                        return true;
                    }
                    return false;
            } else {
                //若用户并未插入到公众号表中则
                $create = [
                    'cid' => $hasClient->id,
                    'wx_openid' => $data['openId']
                ];
//                return $create;
                $bool = Mp::create($create);
                if (!empty($bool)){
                    return true;
                }
                return false;
            }
        } else {
            //更新用户表 公众号表 事务类型
            DB::beginTransaction();
            //若用户表没有没有用户记录
            $create_data = [
                'username' => $data['nickName'],
                'avatar' => $data['avatarUrl'],
                'address' => $data['province'] . $data['country'] . $data['city']
            ];
            //返回模型实例
            $id = Client::create($create_data)->id;
            if (!empty($id)){
                $mp_data = [
                    'cid' => $id,
                    'wx_openid' => $data['openId']
                ];
                $res = Mp::create($mp_data);
                if (!empty($res)){
                    DB::commit();
                    return true;
                } else {
                    DB::rollBack();
                    return false;
                }
            } else {
                DB::rollBack();
                return false;
            }

        }
    }
}
