<?php
/**
 * 58pic(千图网无水印解析下载)
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/7/10
 */
error_reporting(0);
$img_url=$_GET['img_url'];
//$img_url="http://pic.qiantucdn.com/58pic/34/81/68/43g58PIC9ZK2GIjdy4Nff_PIC2018.jpg";
header('Content-type: image/jpeg');
$context=array('http' => array ('header'=> 'Referer: https://www.58pic.com/c/1599016',),);
$xcontext = stream_context_create($context);
echo $str=file_get_contents($img_url,FALSE,$xcontext);
?>