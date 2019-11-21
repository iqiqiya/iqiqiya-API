<?php
/**
 * 网易云音乐解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2018/12/10
 * 博客: blog.77sec.cn
 */
error_reporting(0);
function getMusic($MusicUrl) {
    $temp = explode('=',$MusicUrl);
    $id = $temp[1];
    $MusicUrl = "http://music.163.com/api/song/enhance/player/url?id=".$id."&ids=[".$id."]&br=3200000";
    $result = file_get_contents($MusicUrl);
    header('Content-Type:application/json; charset=utf-8');
    print_r($result);
}
$MusicUrl = $_POST['url'];
//$MusicUrl = "https://music.163.com/#/song?id=450795499";
getMusic($MusicUrl);
?>