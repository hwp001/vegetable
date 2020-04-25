<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use Illuminate\Database\Eloquent\Model;
use DB;
class Client extends Model
{
    //对应表
    protected $table = 'bs_clients';
    //绑定是否可以批量赋值
    protected $guarded = [];
    //改变用户状态
    public function changeStateById($id,$value)
    {
        $row = Client::where('id',$id)->update(['state'=>$value]);
        if (!empty($row)){
            return true;
        } else {
            return false;
        }
    }


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
            ->where('bs_clients.state','!=',2)
            ->get(['bs_clients.id as cid','bs_mps.id as mid','username','name','avatar','phone','email','address','decs','mp_openid','wx_openid','unionid']);
       return $res;
    }

    //根据openid 更新用户信息
    public function updateUserInfoByOpenId($data)
    {
        //根据openid 获得cid
        $cid = ToolController::getCid($data);
        $update_data = [
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'decs' => $data['decs']
        ];
        $row = Client::where('id',$cid)->update($update_data);
        if (!empty($row)) {
            return true;
        } else {
            return false;
        }
    }
}
