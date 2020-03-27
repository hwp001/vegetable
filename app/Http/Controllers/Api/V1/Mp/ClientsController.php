<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Mp\UtilsController as MP_Utils;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\Client;
use App\Models\Mp;
class ClientsController extends Controller
{
    //获取用户信息 并存取
    public function SaveClientsInfo()
    {
        $Client = new Client();
        $Mp = new Mp();
        if (Redis::exists('openid')) {
            $openid = Redis::get('openid');
            //获取用户基本信息
            $users = MP_Utils::app()->user->get($openid);
            //将头像存入本地
            $code = MP_Utils::downImg($users['headimgurl']);
            //返回数组
            $data = [
                'username' => $users['nickname'],
                'address' => $users['province'].$users['country'],
                'avatar' => "images/".$code.".jpg",
                'ip' => $_SERVER['REMOTE_ADDR'],
            ];
//            return $users;
            //查询石否有 openid
            if ($Mp->findOpenid($users['openid'])) {
                //用户已经存在
                return true;
            } else {
                //事务处理，保证公众号表，还有客户表同时插入
                DB::beginTransaction();
                $cid = $Client->create($data)->id;
                if (!empty($cid)) {
                    $mp_data = [
                        'cid' => $cid,
                        'mp_openid' => $users['openid']
                    ];
                    $mid = $Mp->create($mp_data)->id;
                    if (!empty($mid)) {
                        DB::commit();
                        return true;
                    } else {
                        DB::rollBack();
                    }
                } else {
                    DB::rollBack();
                }
            }
        } else {
            return false;
        }
    }


}
