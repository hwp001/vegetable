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
     return 111111;
    }

    public function hello()
    {
       return json_encode('hello');
    }
}
