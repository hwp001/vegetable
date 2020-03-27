<?php

namespace App\Http\Controllers\Api\V1\Mp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TokenController extends Controller
{
    //服务器接入微信公众号
    public function joinMp($input)
    {
        $signature = $input['signature'];
        $timestamp = $input['timestamp'];
        $nonce = $input['nonce'];
        $token = 'HWP';
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        Log::info($tmpStr);
        Log::info($signature);
        if ($tmpStr == $signature) {
            return $input["echostr"];
        } else {
            return false;
        }

    }
}
