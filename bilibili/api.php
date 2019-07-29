<?php
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
function getBilibiliAVCover($avNum) {
    $contents = curl('https://m.bilibili.com/video/' . $avNum . '.html');
    preg_match("~\"pic\":\"(.*?)\"~", $contents, $matches);
    if (count($matches) == 0) {
        echo '没有找到相应的封面图，请换个 av 号试一下。';
        exit;
    }
    $img_url = $matches[1];
    //保存图片
	//$img_url = file_get_contents($matches[1]);
    //file_put_contents('default.png', $img);
    //echo '<img src="default.png">';
	echo $img_url;    //输出img_url
}
$AV_number = $_GET['AV_number'];
getBilibiliAVCover($AV_number);
//调用方式
//http://127.0.0.1/?AV_number=av51455288
exit; ?>
