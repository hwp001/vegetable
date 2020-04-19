<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Client;
use App\Models\Comment;
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
        $data = ['openId'=>'omvgd0coPbGcBWzZVoJJLTBpQIYU'];
        $res = (new Comment())->getCommentById($data);
        return $res;
    }
}
