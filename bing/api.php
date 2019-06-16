<?php
$str = file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1'); //读取必应api，获得相应数据
$str = json_decode($str,true);
$imgurl = 'http://cn.bing.com'.$str['images'][0]['url'];    //获取图片url
header("Location: $imgurl");    //header跳转