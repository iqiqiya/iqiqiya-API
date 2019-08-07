<?php
/**
 * 58pic(千图网无水印解析下载)
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/7/10
 */
error_reporting(0);
function get58Pic($PicUrl) {
    $contents = file_get_contents($PicUrl);
    preg_match("~preview(.*?).jpg~", $contents, $matches);
    if (count($matches) == 0) {
        echo '无法转换成相应的无水印图片，请换个链接试一下。';
        exit;
    }
    $img_url = $matches[1];
    $img_url_no_watermark = "http://pic".$img_url.".jpg";
    echo $img_url_no_watermark;    //输出img_url
    //header("Location: $img_url_no_watermark");    //header跳转
}
$Pic_Url = $_GET['PicUrl'];
//$Pic_Url = "https://www.58pic.com/newpic/34816843.html";
get58Pic($Pic_Url);
exit; 
?>