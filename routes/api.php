<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$api = app('Dingo\Api\Routing\Router');
//需指定完整命名空间
$api->version('v1',['namespace' => 'App\Http\Controllers\Api\V1\Mp'], function($api) {
    //微信公众号组
    $api->group([],function ($api){
        $api->any('main','MainController@index');
        $api->any('menu','MainController@menu');
        $api->any('test','times@times');
        $api->any('test1','ClientsController@downImg');
    });

});

$api->version('v1',['namespace'=>'App\Http\Controllers\Api\V1\Admin'],function ($api){
    //前端接口数据请求
    $api->any('getClients',function (){
        return \App\Models\Client::all(['id','username']);
    });
});

$api->version('v1',['namespace'=>'App\Http\Controllers\Api\V1\Wx'],function ($api){
    //登录接口
    $api->any('login', 'LoginController@index');
    //解密用户数据
    $api->any('decode','LoginController@decode');
    //首页请求接口
    $api->any('home','HomeController@home');
    //推荐 优惠
    $api->any('multiData','HomeController@multiData');
    //分类页请求接口
    $api->any('category','CategoryController@GoodCategory');
    //请求子种类
    $api->any('childCategory','CategoryController@ChildCategory');
    //根据种类id 获取商品详细数据
    $api->any('detail','CategoryController@detailGoodItem');
    //获取全部商品
    $api->any('all','CategoryController@allDetail');
    //根据商品ID获取商品评论
    $api->any('getComment','GoodController@getComment');
});
