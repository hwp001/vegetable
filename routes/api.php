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
        $api->any('test','MainController@replyMessage');
    });

});
