<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
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
        //正则取出图片所需部分
        $content = "http://bs01.test/upload/goodImg/50c49b24a3cdf8b5275a5cbba903aeb1.jpg";
        $pattren = "/upload\/(.*)/";
        preg_match($pattren,$content,$match);
        return $match;
    }
}
