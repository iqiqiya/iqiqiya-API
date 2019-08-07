<?php
/**
 * 58pic(千图网无水印解析下载)
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/7/10
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
    curl_setopt($ch, CURLOPT_REFERER, 'https://www.58pic.com/c/15990160');//修改Referer
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;  
}
function get58Pic($PicUrl) {
    $contents = curl($PicUrl);
	preg_match("~preview(.*?).jpg~", $contents, $matches);
    if (count($matches) == 0) {
        echo '无法转换成相应的无水印图片，请换个链接试一下。';
        exit;
    }
    $img_url = $matches[1];
    $img_url_no_watermark = "http://pic".$img_url.".jpg";
    echo $img_url_no_watermark;    //输出img_url
    header("Content-Type: text/html; charset=utf-8");  
    $str="<a href=./showPic.php?img_url=$img_url_no_watermark>查看图片</a>";  
    echo $str;  
    echo "<br>";
	echo htmlentities($str,ENT_QUOTES,"UTF-8");  
    
}
$Pic_Url = $_GET['PicUrl'];
//curl("http://pic.qiantucdn.com/58pic/34/81/68/43g58PIC9ZK2GIjdy4Nff_PIC2018.jpg");
//$Pic_Url = "https://www.58pic.com/newpic/34816843.html";
get58Pic($Pic_Url);
//http://pic.qiantucdn.com/58pic/34/81/68/43g58PIC9ZK2GIjdy4Nff_PIC2018.jpg
exit; ?>