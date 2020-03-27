<?php


namespace App\Http\Controllers\Utils;


use Illuminate\Support\Facades\Log;

class Tool
{
    //发送请求
    public function http_request($url,$data=''){
        //初始化
        $ch = curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        //这两行取消ssl验证,否则会校验证书。。。 这两个缺一不可
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);//设置内容返回或者输出 跟curl_exec()结合使用
        //判断是否有数据要发送
        if (!empty($data)) {
            curl_setopt($ch,CURLOPT_POST,1);     //设置提交方式为post
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data); //用post方法将数据提交
        }
        $output = curl_exec($ch);
        Log::info($output);
        if ($output == FALSE) {
            return "curl 错误信息：".curl_error($ch);
        }
        curl_close($ch);
        return $output;
    }

    //返回执行请求返回信息
    public function parse_data($url,$data='')
    {
        if (!empty($data)) {
            $res = $this->http_request($url,$data);
        } else {
            $res = $this->http_request($url);
        }
        if (!empty($res)) {
            return json_decode($res);
        }
    }

    //自定义随机数
    public static function random()
    {
        $str =  'faaofafjaiofjaoifaofnecahfereufjsdoin8924348nd7723d2hcafha2';
        $randstr = '';
        //生成六位随机数
        for ($i=0; $i<6; $i++) {
            $len = strlen($str);
            $num = mt_rand(0, $len-1);
            $randstr .= substr($str, $num, 1);
        }
        return $randstr;
    }
}
