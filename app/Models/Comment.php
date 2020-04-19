<?php

namespace App\Models;

use App\Http\Controllers\Api\V1\Wx\ToolController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ixudra\Curl\Facades\Curl;

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

    public function addComment($data)
    {
        //用openid 换取 cid
        $cid = DB::table('bs_clients')
            ->leftJoin('bs_mps','bs_clients.id','bs_mps.cid')
            ->where('bs_mps.wx_openid',$data['openId'])
            ->get('bs_clients.id');
        $cid = $cid[0]->id;
        $comment_data = [];
        $commentList = json_decode($data['commentList'],true);
        //循环存储评论信息
        for ($i=0; $i<count($commentList); $i++){
            $imgArr = $commentList[$i]['img'];
            $imgId = '';
            //将图片存储到本地 再 存入数据库 并提取 图片id
            for ($j=0; $j<count($imgArr); $j++){
                $pattren = "/upload\/(.*)/";
                preg_match($pattren,$imgArr[$j],$match);
                $imgId .= Image::create(['imgUrl'=>$match[1]])->id.',';
            }

            $imgUrl = substr($imgId,0,strrpos($imgId,','));
//            return $imgUrl;
            $comment_data[$i] = [
                'cid' => $cid,
                'gid' => $commentList[$i]['gid'],
                'star' => $commentList[$i]['star'],
                'description' => $commentList[$i]['description'],
                'imgUrl' => $imgUrl,
                'orderNum' => $data['orderNum']
            ];
            if (empty(Comment::create($comment_data[$i]))) {
                return false;
            }
        }
        return true;
    }
}
