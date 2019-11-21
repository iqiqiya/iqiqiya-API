<?php
/**
 * 蓝奏云lanzou直链解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/9/6
 */
function curl_get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'
    ));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;
}
function post_test($arg3,$arg2){
    $sign = $arg3;
    $refer = $arg2;
    $data = array(
        'action'=>'downprocess',
        'sign'=> $sign
    );

    $query = http_build_query($data);

    $options['http'] = array(
        'timeout'=> 60,
        'method' => 'POST',
        'header' => 'Content-type:application/x-www-form-urlencoded',
        'content' => $query,
        'Referer' => $refer
    );

    $url = "https://www.lanzous.com/ajaxm.php";
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
function getTrueUrl($succ_url){
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'User-Agent: Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)',
        'Accept-Language', 'zh-cn',
        'Connection', 'Keep-Alive',
        'Accept', 'image/gif, image/x-xbitmap, image/jpeg, image/pjpeg, application/x-shockwave-flash, application/x-silverlight, */*'
    ));

    curl_setopt($ch, CURLOPT_URL, $succ_url);
    // 不需要页面内容
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    // 不直接输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // 返回最后的Location
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_exec($ch);
    $info = curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    echo '真实url为：'.$info;
}
function getLanZou($pan_url){
    $temp = curl_get($pan_url);
    $temp2 = strstr($temp,"</iframe>-->");
    //echo $temp2;

    preg_match("~src=\"(.*?)\"~", $temp2, $matches);
    if (count($matches) == 0) {
        echo '无法解析此链接，请更换其他试一下。';
        exit;
    }
    $arg1 = $matches[1];
    $arg2 = "https://www.lanzous.com".$arg1;//1.得到referer
    //echo $arg2;

    $temp3 = curl_get($arg2);
    //print_r($temp3);
    //sign':'(.*?)'
    preg_match("~sign':'(.*?)'~", $temp3, $matches);
    if (count($matches) == 0) {
        echo '无法解析此链接，请更换其他试一下。';
        exit;
    }
    $arg3 = $matches[1];
    //echo $arg3;//2.得到sign

    $temp4 = post_test($arg3,$arg2);
    preg_match("~url\":\"(.*?)\"~", $temp4, $matches);
    if (count($matches) == 0) {
        echo '无法解析此链接，请更换其他试一下。';
        exit;
    }
    $arg4 = $matches[1];
    $succ_url = "https://vip.d0.baidupan.com/file/".stripslashes($arg4);
    getTrueUrl($succ_url);
}
$pan_url = "https://www.lanzous.com/i2xrmcb";
getLanZou($pan_url);
?>