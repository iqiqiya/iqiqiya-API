<?php
/**
 * 微信步数修改
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/8/21
 */
error_reporting(0);
function curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/65.0.3325.181 Mobile Safari/537.36'
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;  
}

function getSteps($openid,$steps,$hashsalt) {
    $temp = "openid=".$openid."&steps=".$steps."&hashsalt=".$hashsalt;
    echo $temp;
    $get_url = "http://tool.chaojingxuan.com/wxsport/sport.php?".$temp;
    $contents = curl($get_url);
    echo $contents;
}
//$openid = $_POST['arg1'];
//$steps = $_POST['arg2'];
$openid = "";
$steps = "";
//getSteps($openid,$steps);
getHashSalt();
exit; ?>