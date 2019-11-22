<?php
//随机IP
function Rand_IP(){

    $ip2id= round(rand(600000, 2550000) / 10000); //第一种方法，直接生成
    $ip3id= round(rand(600000, 2550000) / 10000);
    $ip4id= round(rand(600000, 2550000) / 10000);
//下面是第二种方法，在以下数据中随机抽取
    $arr_1 = array("218","218","66","66","218","218","60","60","202","204","66","66","66","59","61","60","222","221","66","59","60","60","66","218","218","62","63","64","66","66","122","211");
    $randarr= mt_rand(0,count($arr_1)-1);
    $ip1id = $arr_1[$randarr];
    return $ip1id.".".$ip2id.".".$ip3id.".".$ip4id;
}
function getLocation($url) {
    $ch  = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
    curl_setopt($ch, CURLOPT_HEADER, true);        //返回头信息
    curl_setopt($ch, CURLOPT_NOBODY, true);        //不返回内容
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  //返回数据不直接输出
    $content = curl_exec($ch);
    curl_close($ch);//执行并存储结果
    return $content;
}
function getId($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5000);
    $user_agent = 'User-Agent: Mozilla/5.0 (Linux; Android 5.1.1; vivo X9 Plus Build/LMY48Z) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/39.0.0.0 Mobile Safari/537.36';
    // 使用上面定义的 ua
    curl_setopt($ch, CURLOPT_USERAGENT,$user_agent);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_REDIR_PROTOCOLS, -1);
    curl_setopt($ch, CURLOPT_REFERER, 'http://m.gifshow.com/s/bM7HaGyz');//修改Referer
    // 不用 POST 方式请求, 意思就是通过 GET 请求
    curl_setopt($ch, CURLOPT_POST, false);
    $contents = curl_exec($ch);
    curl_close($ch);
    return $contents;
}
function zz1($content){
    preg_match("~[a-zA-z]+://[^\s]*~", $content, $matches);
    if (count($matches) == 0) {
        echo '请重试哦';
        exit;
    }
    $Vid = $matches[0];
    return $Vid;
}
function zz2($content){
    preg_match("~kwai://work/(.*?)\"~", $content, $matches);
    if (count($matches) == 0) {
        echo '请重试哦1';
        exit;
    }
    $Vid = $matches[1];
    return $Vid;
}
function pinjie($content){
    $url = "https://api.gifshow.com/rest/n/photo/info?isp=CMCC&mod=".rand_phone()."&lon=".rand(73,175).".".rand(10000,9999)."&country_code=cn&kpf=ANDROID_PHONE&did=ANDROID_60e1f19906003454&kpn=KUAISHOU&net=".rand_net()."&app=0&oc=MYAPP%2C1&ud=0&hotfix_ver=&c=MYAPP%2C1&sys=".rand_android()."&appver=6.1.0.8039&ftt=&language=zh-cn&iuid=&lat=".rand(3,53).".".rand(10000,9999)."&did_gt=1564335646126&ver=6.1&max_memory=192&photoIds=".$content."&client_key=3c2cd3f3&os=android";
    $str = substr(strrchr($url, "?"), 1);
    $var=explode("&",$str);
    sort($var);
    $str2 =  implode(',',$var);
    $str3 = str_replace(",","",$str2);
    $str3 = str_replace("+","",$str3);
    $str4 = urldecode($str3)."382700b563f4";
    //echo $str4;
    $sig = md5($str4);
    //echo $sig;
    return $url."&sig=".$sig;
    //return $url;
}
function rand_net(){
    $net = [
        '4G',
        'WIFI'
    ];
    return $net[mt_rand(0, count($net) - 1)];
    //
}
function rand_phone(){
    $phone = [
        'SM-I9228',
        'SM-I9502',
        'HTC-Raider',
        'coolpad-8670SM-I9228',
        'HTC-Incredible',
        'HUAWEI-C8812',
        'Google-Nexus',
        'ZTE-N909P7-L07',
    ];
    return ($phone[mt_rand(0, count($phone) - 1)]);
}
function rand_android(){
    $android = [
        'ANDROID_5.6.3',
        'ANDROID_6.6.5',
        'ANDROID_5.6.3',
        'ANDROID_4.6.1',
        'ANDROID_6.7.6',
        'ANDROID_5.7.4'
    ];
    return ($android[mt_rand(0, count($android) - 1)]);
}
function zz3_video($content){
    preg_match("~main_mv_urls\":(.*?)}~", $content, $matches);
    if (count($matches) == 0) {
        echo '请重试哦2';
        exit;
    }
    $Vid = $matches[1];
    return $Vid;
}
function zz3_video2($content){
    preg_match("~url\":\"(.*?)\"~", $content, $matches);
    if (count($matches) == 0) {
        echo '请重试哦3';
        exit;
    }
    $Vid = $matches[1];
    return $Vid;
}
$url= 'http://m.gifshow.com/s/bM7HaGyz';
//$url='http://m.gifshow.com/s/s8HR5qXM';
$content1 = getLocation($url);
//echo $content1;
$url2 = zz1($content1);
//echo $url2;
$content2 = getId($url2);
//echo $content2;
$content3 =  zz2($content2);
//print $content3;

$url3 = pinjie($content3);
//print_r($url3);
$content4 = getId($url3);
//echo $content4;
$content5 = zz3_video($content4);
$download_url = zz3_video2($content5);
echo $download_url;

?>