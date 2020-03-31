<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test','test\testController@index');

Route::get('hello','test\testController@hello');

Route::get('mm','Api\V1\MpController@get_access_token');

Route::get('mp','Api\V1\MpController@hello');

//前端接口数据
Route::any('/getClients',function (){
   return \App\Models\Client::all(['id','username as text']);
});
