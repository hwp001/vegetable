<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Goods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //获取商品种类
    public function GoodCategory()
    {
        $res = Category::where('pid',0)->get(['id','name']);
        return json_encode($res);
    }

    //根据pid 获取子类
    public function ChildCategory(Request $request)
    {
        $pid = $request->get('pid');
        $res = Category::where('pid',$pid)->get(['id','name']);
        return json_encode($res);
    }

    //根据种类id 获取商品数据
    public function detailGoodItem(Request $request)
    {
        $kind_id = $request->get('kindId');
        $res = (new Goods())->detail('kind_id','=',$kind_id);
        return json_encode($res);
    }

    //获取全部商品详情
    public function allDetail()
    {
        $res = (new Goods())->allDetail();
        return json_encode($res);
    }
}
