<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $table = 'bs_comment';
    protected $guarded = [];

    public function Client()
    {
        return $this->hasMany(Client::class,'cid');
    }

    public function Goods()
    {
        return $this->hasMany(Comment::class,'gid');
    }

    /**
     * 根据一种条件获取商品评论
     * @param $a
     * @param $b
     * @param $c
     * @return mixed
     */
    public function getComment($a,$b,$c)
    {
        $res = DB::table('bs_clients')
                ->leftJoin('bs_comment','bs_clients.id','cid')
                ->leftJoin('bs_goods','bs_goods.id','bs_comment.gid')
                ->where($a, $b, $c)
                ->get(['bs_comment.id','username','avatar','title','star','bs_comment.description','imgUrl as img','bs_comment.updated_at as time']);

        if (count($res) == 0) {
            return false;
        }
        return ToolController::IdtoUrl($res);
    }
}
