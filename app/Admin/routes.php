<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');
    $router->resource('clients', 'ClientController');
    $router->resource('mps', 'MpController');
    $router->resource('goods/category', 'CategoryController');
    $router->resource('goods/image', 'ImageController');
    $router->resource('goods/detail', 'GoodsController');
    $router->resource('goods/comment', 'CommentController');
    $router->resource('goods/activity','ActivityController');
    $router->resource('orders/cargo', 'CargoController');
    $router->resource('orders/detail', 'OrderController');
    $router->resource('ordersGood/detail', 'OrdersGoodController');

    //接口数据
    $router->group([],function($api){
        $api->any('getClientsIdAndUsername','ClientController@getClientsIdAndUsername');
        $api->any('getGoodsIdAndName','GoodsController@getGoodsIdAndName');
        $api->any('getImg','CommentController@getImg');
    });
});
