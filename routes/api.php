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
    //用户登录过，直接获取用户信息
    $api->any('loggedUserInfo','LoginController@loggedUserInfo');
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
    //新增地址
    $api->any('addCargo','AddressController@addCargo');
    //获取地址
    $api->any('getCargo','AddressController@getCargo');
    //更新地址
    $api->any('updateCargo','AddressController@updateCargo');
    //根据id获得快递地址
    $api->any('getCargoById','AddressController@getCargoById');
    //根据id更新快递地址
    $api->any('updateCargoById','AddressController@updateCargoById');
    //根据id删除快递地址
    $api->any('delCargoById','AddressController@delCargoById');
    //新增订单
    $api->any('addOrder','OrderController@addOrder');
    //根据openid 订单状态 获取订单
    $api->any('getOrder','OrderController@getOrder');
    //更加openid 订单id 改变订单状态
    $api->any('cancelOrder','OrderController@cancelOrder');
    //如上
    $api->any('recoverOrder','OrderController@recoverOrder');
    //如上上
    $api->any('signOrder','OrderController@signOrder');
    //根据openid 订单id 获得订单
    $api->any('getOrderById','OrderController@getOrderById');
    //增加评论
    $api->any('addComment','CommentController@addComment');
    //上传图片
    $api->any('uploadImg','CommentController@uploadImg');
    //获得评论
    $api->any('getCommentById','CommentController@getCommentById');
    //更新用户信息资料
    $api->any('editUserInfo','ProfileController@editUserInfo');
});
