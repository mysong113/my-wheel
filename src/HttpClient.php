<?php

namespace CStools;

class HttpClient
{
    /**
     * @param $url
     * @param string $header
     * @param string $method
     * @param array $post_data
     * @param bool $set_cookie 存储服务端发送的cookie,为文件路径
     * @param string $cookie 浏览器cookie,为字符串
     * @param string $cookie_file  文件cookie，为文件路径
     * @param int $time_out
     * @return mixed
     */
    public static function execCurl($url,$header='',$method='get',$post_data=[],$set_cookie='',$cookie='',$cookie_file='',$time_out=300)
    {
        $header = !empty($header)?$header:[
            "User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.132 Safari/537.36",
        ];
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ;
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_TIMEOUT,$time_out);
        if(strpos($url,'https')!==false)
        {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        }
        if($method=='post')
        {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data );
        }
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        //curl_setopt($ch,CURLOPT_VERBOSE,1);
        if(!empty($set_cookie))
        {
            curl_setopt($ch, CURLOPT_COOKIEJAR,  $set_cookie); //存储cookies
        }
        else if(!empty($cookie))
        {
            curl_setopt($ch,CURLOPT_COOKIE,$cookie);//使用浏览器cookie
        }
        else if(!empty($cookie_file))
        {
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file); //使用文件cookie
        }
        $output = curl_exec($ch);
        //$curl_info = curl_getinfo($ch);
        //var_dump($curl_info);
        curl_close($ch);
        return $output;
    }

}