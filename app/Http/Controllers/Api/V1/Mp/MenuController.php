<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\V1\Mp\UtilsController as MP_Utils;

class MenuController extends Controller
{
    private $app;

    public function __construct()
    {
        $this->app = MP_Utils::app();
    }

    //删除菜单
    public function delete()
    {
        return $this->app->menu->delete();
    }

    //添加菜单  (只添加一次)
    public function add()
    {
        $buttons = [
            [
                "type"  => "click",
                "name"  => "小程序",
                "key"   => "MP_KEY_miniprogram"
            ],
            [
                "name" => "商品详情",
                "sub_button" => [
                    [
                        "type" => "click",
                        "name" => "特价商品",
                        "key"  => "MP_KEY_GOODS"
                    ],
                    [
                        "type" => "click",
                        "name" => "订单详情",
                        "key"  => "MP_KEY_ORDERS"
                    ],
                ],
            ],
            [
                "type" => "click",
                "name" => "关于个人",
                "key"  => "MP_KEY_CLIENTS"
            ]
        ];

        return $this->app->menu->create($buttons);
    }
}
