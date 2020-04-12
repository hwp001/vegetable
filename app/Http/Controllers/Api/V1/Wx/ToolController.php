<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use EasyWeChat\Factory;

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
            $pattern = '/"(.*?)"/';
            preg_match($pattern,$img_ids,$match);
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
}
