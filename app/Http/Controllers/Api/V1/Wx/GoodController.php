<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Goods;
use Illuminate\Http\Request;

class GoodController extends Controller
{
    //根据商品ID 获取商品评论
    public function getComment(Request $request)
    {
        $gid = $request->get('goodId');
        //商品详细数据
        $detail = (new Goods())->detail('bs_goods.id','=', $gid);
        //商品评论
        $res = (new Comment())->getComment('bs_goods.id', '=', $gid);
        if (!$res){
            return json_encode(['statu'=>false, 'goodDetail'=>$detail]);
        }
        return json_encode(['statu'=>true, 'goodComment'=>$res, 'goodDetail'=>$detail]);
    }
}
