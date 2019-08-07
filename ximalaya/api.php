<?php
/**
 * 喜马拉雅FM主播信息采集api
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/7/20
 */
function curl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4'
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;
}
function getXimalayaFans($pd,$ps,$ud) {
    $contents = curl('http://mobwsa.ximalaya.com/mobile/others/follower?device=android&pageId='.$pd.'&pageSize='.$ps.'&toUid='.$ud);
	echo $contents;
}
$PD = '1';
$PS = '100';
$UD = '1000667';
//$PD = $_GET['PD'];
//$PS = $_GET['PS'];
//$UD = $_GET['UD'];
getXimalayaFans($PD,$PS,$UD);
exit; ?>
