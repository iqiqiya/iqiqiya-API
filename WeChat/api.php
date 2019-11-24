<?php
/**
 * 微信步数修改
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/8/21
 */
error_reporting(0);
function getOpenID($account) {
    $curl = curl_init();
    $url = "http://weixin.droi.com/health/phone/index.php/SendWechat/getWxOpenid";
    $salt='8061FD';//salt
    $timestamp = time();
    $sign = md5($account . $salt . $timestamp);
    $data = array(
            'accountId' => $account,
            'timeStamp' => $timestamp,
            'sign' => $sign
        );
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_USERAGENT,"Mozilla/5.0 (Linux; U; Android 2.3.6; zh-cn; GT-S5660 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MicroMessenger/4.5.255");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    //return $output;
    //正常输出
    //{"code":0,"openid":"o2cS9uFf_c90sm4qdKcsytkzykZk"}
    $rep = json_decode($output, true );
    if( $rep['code']!==0 ) {
        die( 'getWxOpenid:'.$rep['messsage']."\n" );
    }
    $openid=$rep['openid'];
    return $openid;
}
function stepSubmit($account,$steps,$openid) {
    $curl = curl_init();
    $url = "http://weixin.droi.com/health/phone/index.php/SendWechat/stepSubmit";
    $salt='8061FD';//salt
    $timestamp = time();
    $sign=md5($account.$salt.$steps.$salt.$timestamp.$salt.$openid);
    $data = array(
        'accountId' => $account,
        'jibuNuber'=>$steps,
        'timeStamp' => $timestamp,
        'sign' => $sign
    );
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_USERAGENT,"Mozilla/5.0 (Linux; U; Android 2.3.6; zh-cn; GT-S5660 Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1 MicroMessenger/4.5.255");
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    //return $output;
    //正常输出
    //{"errcode":0,"msg":"","code":0,"messsage":"\u6570\u636e\u63d0\u4ea4\u6210\u529f\uff01"}
    print_r($output);
    $rep = json_decode($output, true );
    return $rep['messsage'];
}
$account=$_POST['account'];//绑定微信的卓易账号
$steps=$_POST['steps'];//提交步数

//$account = "";
//$steps = "";
$openid = getOpenID($account);
echo stepSubmit($account,$steps,$openid);
?>