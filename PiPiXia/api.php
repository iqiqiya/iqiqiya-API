<?php
/**
 * 皮皮虾短视频无水印解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/9/2
 */
error_reporting(0);
function curl_pipiXia($id)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4'
    ));
    curl_setopt($ch, CURLOPT_URL, "https://h5.pipix.com/bds/webapi/item/detail/?item_id=".$id);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;
}
function getPiPiXiaId($VideoUrl)
{
    $temp = $VideoUrl."/";
    preg_match("~item/(.*?)/~", $temp, $matches);
    if (count($matches) == 0) {
        echo '无法解析此视频，请换个链接试一下。';
        exit;
    }
    $video_id = $matches[1];
    //echo $video_id;

    $contents = curl_pipiXia($video_id);
    print_r($contents);

    //支持两种链接形式
    //https://h5.hulushequ.com/item/6562792949205358861
    //https://h5.pipix.com/item/6562792949205358861
}
//$VideoUrl = "https://h5.hulushequ.com/item/6562792949205358861";
$VideoUrl = $_GET['url'];
getPiPiXiaId($VideoUrl);
?>