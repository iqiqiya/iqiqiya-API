<?php
/**
 * CCTV(央视网)视频解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2021/08/25
 */
error_reporting(0);

function curl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 8_0 like Mac OS X) AppleWebKit/600.1.3 (KHTML, like Gecko) Version/8.0 Mobile/12A4345d Safari/600.1.4',
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.cctv.com/'); // 修改 Referer
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;
}

function get_CCTV($video_url)
{
    $contents = curl($video_url);
    // var guid = "3ebb32c9a2474758b86d8a98f433c3b3";
    preg_match('~var guid = "([^"]+)";~', $contents, $matches);

    if (count($matches) == 0) {
        echo '无法解析此视频，请换个链接试一下。';
        exit;
    }

    $guid = $matches[1];

    $video_url_parse = "https://dh5.cntv.myalicdn.com/asp/h5e/hls/main/0303000a/3/default/" . $guid . "/main.m3u8?maxbr=2048";

    header("Location: $video_url_parse");
}

$video_url = $_GET['url'];
// $video_url = "https://tv.cctv.com/2017/03/04/VIDEhOELsnCYlUtKhOmfO4Qu170304.shtml";

get_CCTV($video_url);
// https://dh5.cntv.myalicdn.com/asp/h5e/hls/main/0303000a/3/default/3ebb32c9a2474758b86d8a98f433c3b3/main.m3u8?maxbr=2048

exit;
?>
