<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Utils\Tool;
use EasyWeChat\Factory;
use Illuminate\Http\Request;
use Ixudra\Curl\Facades\Curl;

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

    //将远程图片存入本地
    public static function downImg($url)
    {
        $res = Curl::to($url)->get();
        $code = md5(Tool::random());
        file_put_contents(public_path('upload/images/'.$code.".jpg"), $res) or die('图片保存失败');
        return $code;
    }
}
