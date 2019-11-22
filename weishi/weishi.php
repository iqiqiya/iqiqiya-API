<?php
/**
 * Created by PhpStorm
 * User: iqiqiya
 * Date: 2019/11/20
 * Time: 22:41
 */
function get_feedid($url){
    ini_set('user_agent', 'Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 4 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19');
    $content =  file_get_contents($url);
    preg_match("~feed/(.*?)/~", $content, $matches);
    $Feedid = $matches[1];
    return $Feedid;
}
function get_json($feedid,$refer){
    $crl = curl_init();
    $headers = array(
        'user-agent: Mozilla/5.0 (iPhone; CPU iPhone OS 10_3 like Mac OS X) AppleWebKit/602.1.50 (KHTML, like Gecko) CriOS/56.0.2924.75 Mobile/14E5239e Safari/602.1',
        'content-type: application/json',
        'accept: application/json',
        'authority: h5.weishi.qq.com',
        'referer: '.$refer
    );
    curl_setopt($crl, CURLOPT_URL, 'https://h5.weishi.qq.com/webapp/json/weishi/WSH5GetPlayPage?t=0.5261416173604099&g_tk=');

    curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);//绕过ssl验证
    curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);

    //设置头文件的信息作为数据流输出
    curl_setopt($crl, CURLOPT_HEADER, 0);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
    //设置post方式提交
    curl_setopt($crl, CURLOPT_POST, 1);
    //设置post数据
    /**$post_data = array(
     * "username" => "coder",
     * "password" => "12345"
     * );*/
    $post_data = "{\"feedid\":\"$feedid\",\"recommendtype\":0,\"datalvl\":\"all\",\"_weishi_mapExt\":{}}";
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    $rest = curl_exec($crl);
    curl_close($crl);
    return $rest;
}
function zz_get_video_url($content){
    preg_match("~video_url(.*?),~", $content, $matches);
    $video_url1 = $matches[1];
    return $video_url1;
}
function zz_video_url($content){
    //下面是正则去除中文字符保留http或者https链接
    $str_r= '/(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/';
    //preg_match_all函数自行百度什么意思
    preg_match_all($str_r,$content,$arr);
    //获得带http或者https链接
    $no_water_url=$arr[0][0];

    return $no_water_url;
}
//$url = "https://h5.weishi.qq.com/weishi/feed/76EaWNkEF1IqtfYVH/wsfeed?wxplay=1&id=76EaWNkEF1IqtfYVH&spid=7831768101950341120&qua=v1_and_weishi_4.0.0_88_push33_e&chid=100081014&pkg=3670&attach=cp_reserves3_1000370011";
//自己烤的串，果然比外面卖的便宜又好吃！>>https://h5.weishi.qq.com/weishi/feed/76EaWNkEF1IqtfYVH/wsfeed?wxplay=1&id=76EaWNkEF1IqtfYVH&spid=7831768101950341120&qua=v1_and_weishi_4.0.0_88_push33_e&chid=100081014&pkg=3670&attach=cp_reserves3_1000370011

$str1 = $_POST['url'];
$url = zz_video_url($str1);
$feedid = get_feedid($url);
$content1 = get_json($feedid,$url);
$content2 = zz_get_video_url($content1);
$no_water_url = zz_video_url($content2);
echo $no_water_url;
//curl ''  -H  -H  -H  -H  --data-binary '{"feedid":"7bRYpCNGf1IjvV7YY","recommendtype":0,"datalvl":"all","_weishi_mapExt":{}}' --compressed