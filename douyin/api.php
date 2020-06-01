<?php
/**
 * Created by PhpStorm
 * User: iqiqiya
 * Date: 2019/11/20
 * Time: 16:40
 * Blog: 77sec.cn
 */

error_reporting(0);
function get_content_url($url) {
    $ch = curl_init();
    //设置请求头
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4'
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    //启用时会将头文件的信息作为数据流输出
    curl_setopt($ch, CURLOPT_HEADER, False);
    //设置为FALSE 禁止 cURL 验证对等证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, False);
    //获取页面内容 不直接输出到页面
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //设置最大超时时间
    curl_setopt($ch, CURLOPT_TIMEOUT, 5000);
    $result = curl_exec($ch);
    return $result;
}
function zz_get_url($content){
    preg_match('/href="(.*?)">Found/', $content, $matches);
    $res = $matches[1];
    return $res;
}
function zz_item_id($content){
    preg_match('/itemId: "(.*?)",/', $content, $matches);
    $res = $matches[1];
    return $res;
}

function zz_video_url($content){
    preg_match("~https(.*?)\"~", $content, $matches);
    $item_ids = $matches[0];
    return $item_ids;
}

//$url = $_GET['url'];
$url = "http://v.douyin.com/xGSE7P/";
$str_r= '/(http:\/\/|https:\/\/)((\w|=|\?|\.|\/|&|-)+)/';
preg_match_all($str_r,$url,$arr);
$share_url=$arr[0][0];

$content1 =  get_content_url($share_url);//获得源码
$url_302 = zz_get_url($content1);//正则拿到跳转后的url

$content2 = get_content_url($url_302);
$item_id = zz_item_id($content2);

$url_pj = "https://www.iesdouyin.com/web/api/v2/aweme/iteminfo/?item_ids=".$item_id;//拼接url
$content3 = json_decode(get_content_url($url_pj),true);

$watermark_url = $content3['item_list'][0]['video']['play_addr']['url_list'][0];
$no_watermark_url = str_replace("playwm","play",$watermark_url);//这个得到的地址需要更改UA才可以正常显示

$content4 = get_content_url($no_watermark_url);
$youhua_url = zz_get_url($content4);
print_r($youhua_url);

?>