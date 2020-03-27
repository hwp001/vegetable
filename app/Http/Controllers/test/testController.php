<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use App\Models\Client as Client;
use Illuminate\Support\Facades\Log;

class testController extends Controller
{
    public function index()
    {
        $signature = $_GET["signature"];
	    $timestamp = $_GET["timestamp"];
	    $nonce = $_GET["nonce"];
		
	    $token = 'hwp';
	    $tmpArr = array($token, $timestamp, $nonce);
	    sort($tmpArr, SORT_STRING);
	    $tmpStr = implode( $tmpArr );
	    $tmpStr = sha1( $tmpStr );
	    file_put_contents('wx\text.txt', $signature.'-'.$timestamp.'-'.$nonce.'-'.$_GET['echostr']);
	    if( $tmpStr == $signature ){
	        return $_GET["echostr"];
	    }else{
	        return false;
	    }
	
    }

    public function hello()
    {
       return json_encode('hello');
    }
}
