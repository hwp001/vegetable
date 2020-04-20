<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use DB;
class ToolController extends Controller
{
    public static function wxapp()
    {
        $appConfig = config('wechat.mini_program.default');
        $config = [
            'app_id' => $appConfig['app_id'],
            'secret' => $appConfig['secret'],
        ];
        return  Factory::miniProgram($config);
    }

    //转换图片id => 路径
    public static function IdtoUrl($res)
    {
        for ($i=0; $i<count($res); $i++){
            $img_ids = $res[$i]->img;
            if (strpos($img_ids,'"')) {}
            $pattern = '/"(.*?)"/';
            preg_match($pattern,$img_ids,$match);
            $match[1] = (!empty($match[1])) ? $match[1] : $img_ids;
            //是否存在 “,”
            $imgIds = strpos($match[1],',') ? explode(',',$match[1]) : [$match[1]];
            //取出图片id
            $imgID = [];
            for ($j = 0; $j < count($imgIds); $j++) {
                $img = Image::where('id', $imgIds[$j])->get('imgUrl');
                if (count($img) == 1) {
                    $imgID[] = $img[0]->imgUrl;
                }
            }
            $res[$i]->img = $imgID;
            unset($imgID);
        }
        return $res;
    }

    //根据 openid 获得 cid
    public static function getCid($data)
    {
        $cid = DB::table('bs_clients')
            ->leftJoin('bs_mps','bs_clients.id','bs_mps.cid')
            ->where('bs_mps.wx_openid',$data['openId'])
            ->get('bs_clients.id');
        return $cid[0]->id;
    }
}
