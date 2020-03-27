<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use EasyWeChat\Factory;
use Illuminate\Http\Request;

class UtilsController extends Controller
{
    //根据config生成 easywechat 实例
    public static function app()
    {
        $info = config('wechat.official_account.default');
        $config = [
            'app_id' => $info['app_id'],
            'secret' => $info['secret'],
        ];
        //easywechat 应用实例
        return Factory::officialAccount($config);
    }
}
