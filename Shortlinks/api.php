<?php
/**
 * 短网址生成(搜狗api)
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/12/5
 */
error_reporting(0);
function curl_sg($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4'
    ));
    curl_setopt($ch, CURLOPT_URL, "https://sa.sogou.com/gettiny?url=".$url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;
}
$url = $_POST['$url'];
//$url = "https://www.baidu.com/";
echo curl_sg($url);