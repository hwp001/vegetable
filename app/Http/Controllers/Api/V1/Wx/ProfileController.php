<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //编辑资料
    public function editUserInfo(Request $request)
    {
        $data = $request->all();
        $bool = (new Client())->updateUserInfoByOpenId($data);
        if ($bool){
            $res = (new Client())->getInfoByOpenid($data);
            if (!empty($res)){
                return json_encode(['statu'=>1,'userInfo'=>$res]);
            } else {
                return json_encode(['statu'=>0,'err'=>'用户信息获取失败']);
            }
        } else {
            return json_encode(['statu'=>0,'err'=>'用户信息更新失败']);
        }
    }
}
