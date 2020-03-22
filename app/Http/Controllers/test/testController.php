<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class testController extends Controller
{
    public function index()
    {
        return env('APP_URL').'/upload/images/image.jpg';
    }
}
