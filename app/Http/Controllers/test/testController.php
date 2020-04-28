<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use App\Http\Controllers\Controller;
use App\Models\Goods;
use Illuminate\Support\Facades\Mail;

class testController extends Controller
{
    public function index()
    {
        $data = [
            "goodImg/e56846ae700736e2d1510a1f816cfc7e.jpg",
            "goodImg/33fda9bc7d4e90ece7c327f784bb580e.jpg"
        ];
        return ToolController::UrlToId($data);
    }
}
