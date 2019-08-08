<?php
/**
 * 网易云音乐解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2018/12/10
 */
error_reporting(0);
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
    curl_setopt($ch, CURLOPT_REFERER, 'http://www.cctv.com/');//修改Referer
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;  
}
function getMusic($MusicUrl) {
    $temp = explode('=',$MusicUrl);
    //echo $matches[1];
    $id = $temp[1];
    $MusicUrl = "http://music.163.com/api/song/enhance/player/url?id=".$id."&ids=[".$id."]&br=3200000";
    $contents = curl($MusicUrl);
    //echo $contents;
	preg_match("~http(.*?)\"~", $contents, $matches);
    if (count($matches) == 0) {
        echo '无法解析这首歌，请换个链接试一下。';
         exit;
    }
    $music_url = "http".$matches[1];
    echo $music_url;    //输出
//header("Location: http://player.77sec.cn/m3u8/?url=$music_url_parse");    //header跳转
}
$MusicUrl = $_GET['url'];
//$MusicUrl = "https://music.163.com/#/song?id=450795499";
getMusic($MusicUrl);
//{"data":[{"id":450795499,"url":"http://m10.music.126.net/20190807215713/224d44e3b4c0293dee14927d0fa9d30d/ymusic/8ae5/e063/1d74/9ae813168a4f921968579bf889528dbc.mp3","br":320000,"size":13881513,
//"md5":"9ae813168a4f921968579bf889528dbc","code":200,"expi":1200,"type":"mp3","gain":0.0,"fee":0,"uf":null,"payed":0,"flag":0,"canExtend":false,"freeTrialInfo":null,"level":"exhigh","encodeType":"mp3"}],"code":200}
exit; ?>