<?php

namespace App\Http\Controllers\Api\V1\Wx;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use DB;
use Illuminate\Support\Facades\Mail;

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

    /**
     * @param 输入多维数组 转换图片id => 路径
     * @return mixed
     */
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
    //输入字符串图片编号 =》地址
    public static function IdToUrlStr($res)
    {
        $pattern = '/"(.*?)"/';
        preg_match($pattern,$res,$match);
        $match[1] = (!empty($match[1])) ? $match[1] : $res;
        //是否存在 “,”
        $imgIds = strpos($match[1],',') ? explode(',',$match[1]) : [$match[1]];
        $imgID = [];
        for ($j = 0; $j < count($imgIds); $j++) {
            $img = Image::where('id', $imgIds[$j])->get('imgUrl');
            if (count($img) == 1) {
                $imgID[] = $img[0]->imgUrl;
            }
        }
        return $imgID;
    }
    //数组图片地址 =》 转为字符串编号
    public static function UrlToId($arr)
    {
        $ImgId = '';
        for ($i=0; $i<count($arr); $i++){
            $res = Image::where('imgUrl',$arr[$i])->get('id');
            $ImgId .=  $res[0]->id . ',';
        }
        return substr($ImgId,0,strrpos($ImgId,','));
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

    //发送邮箱
    public static function sendEmail($to,$content)
    {
        //主题
        $subject = '预订商城平台';
        Mail::send('success',['content'=>$content],function($message) use ($to,$subject) {
            $message->to($to)->subject($subject);
        });
    }

    //适用于两个表，另一个表包含用户id
    public static function getEmailById($id,$two)
    {
        $emailArr = DB::table('bs_clients')
            ->leftJoin($two,"bs_clients.id","{$two}.cid")
            ->where("{$two}.id",$id)
            ->get('email');
        $mail =  $emailArr[0]->email;
        $pattern = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
        //正则验证邮箱
        preg_match($pattern, $mail, $matches);
        if (count($matches) > 0) {
            return $matches[1];
        } else {
            return 'hwpoo1@163.com';
        }
    }
}
