<?php
error_reporting(0);
//获取302跳转后的url
function get_302_url($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    //curl_setopt($ch, CURLOPT_VERBOSE, true);// 报告每一件意外的事情
    curl_setopt($ch, CURLOPT_HEADER, true);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);//当根据Location:重定向时，自动设置header中的Referer:信息
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);//启用时会将服务器服务器返回的"Location: "放在header中递归的返回给服务器，使用CURLOPT_MAXREDIRS可以限定递归返回的数量。
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    // $ret 返回跳转信息
    $ret = curl_exec($ch);
    // $info 以 array 形式返回跳转信息
    $info = curl_getinfo($ch);
    // 跳转后的 URL 信息
    $retURL = $info['url'];
    // 记得关闭curl
    echo $retURL;
    curl_close($ch);
}
$url = "https://share.huoshan.com/hotsoon/s/RzkXwpYy700/";
get_302_url($url);

// https://share.huoshan.com/hotsoon/s/RzkXwpYy700/
// ꧁༺ 心上人_大漂亮༻꧂在火山分享了视频，快来围观！传送门戳我>>https://share.huoshan.com/hotsoon/s/RzkXwpYy700/ 复制此链接，打开【火山小视频】，直接观看视频~