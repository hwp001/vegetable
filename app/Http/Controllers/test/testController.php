<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Goods;
use App\Models\Order;
use Request;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Log;
class testController extends Controller
{
    public function index()
    {
        return (new Order())->times();
    }
}
