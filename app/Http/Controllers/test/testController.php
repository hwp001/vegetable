<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Goods;
use App\Models\Mp;
use App\Models\Order;
use Request;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
class testController extends Controller
{
    public function index()
    {
        $data = [
            "avatarUrl" =>"https://wx.qlogo.cn/mmopen/vi_32/TzRlHKricVQJtXmRass1yYBlDt71OCON2GxdJMkcyRKAqouF8aVrwnicUe5vianyRvOHa6zVyblJynXuO1OFViboeQ/132",
            "city" => '',
            "country" => "Sweden",
            "nickName" => "我守一。",
            "openId" => "cesce",
            "province" => 'fafa',
        ];
        var_dump((new Mp())->addWxUserInfo($data));
    }
}
