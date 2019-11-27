<?php
/**
 * Created by PhpStorm
 * User: iqiqiya
 * Date: 2019/11/24
 * Time: 9:28
 */
error_reporting(0);
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
//https://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=9473736974
//先取出物流公司名称，如debang
function get_compary($text){
    $headerArray =array("Accept-Language: zh-CN,zh;q=0.8","Cache-Control: no-cache","Host:www.kuaidi100.com","Referer:https://www.kuaidi100.com/");
    $curl = curl_init();
    $url = "https://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=".$text;
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36");
    curl_setopt($curl, CURLOPT_POST, 0);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    //正常返回
    //{"comCode":"","num":"9473736974","auto":[{"comCode":"debangwuliu","lengthPre":10,"noCount":1550,"noPre":"947373"}]}
    //下面正则匹配名称(json也可以哦)
    preg_match_all('#"comCode":"(.*?)"#',$output,$match);
    $company = $match[1][1];
    return $company;
}
$id = "73122103506087";//可能需要更换 到快递100官网找一个就OK
//$id = $_POST['id'];
$type = get_compary($id);
//正常返回debangwuliu

//https://www.kuaidi100.com/query?type=debangwuliu&postid=9473736974&temp=0.7508453850932293&phone=
function get_data($text,$com){
    $rand = mt_rand(1111111111111111, 8888888888888888);
    $temp =  '0.' . $rand;
    $headerArray =array("Accept: application/json, text/javascript, */*; q=0.01","Cache-Control: no-cache","Host:www.kuaidi100.com","Referer:https://www.kuaidi100.com/?from=openv","Cookie: csrftoken=C8eAjWh2fyDqqOSMlSmKaJdMqtjW8iLLOIBsUmMsgHE; WWWID=WWW8A873C08880109D493D45E7B86FC5583; Hm_lvt_22ea01af58ba2be0fec7c11b25e88e6c=1574823124,1574827551; MOBID=B53E32216F579899AC3BF9579DF8E2C5; Hm_lpvt_22ea01af58ba2be0fec7c11b25e88e6c=1574827564");
    $curl = curl_init();
    $url = "https://www.kuaidi100.com/query?type=".$com."&postid=".$text."&temp=".$temp."&phone=";
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.Rand_IP(), 'CLIENT-IP:'.Rand_IP()));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);
    curl_setopt($curl, CURLOPT_USERAGENT,"Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36");
    curl_setopt($curl, CURLOPT_POST, 0);
    curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    //正常返回
    //{"comCode":"","num":"9473736974","auto":[{"comCode":"debangwuliu","lengthPre":10,"noCount":1550,"noPre":"947373"}]}
    //下面正则匹配名称(json也可以哦)
    return $output;
}
//print_r(get_data($id,$type));
$c= json_decode(get_data($id,$type));
$array = object_array($c);
//var_dump($array);
echo "你的快递运送情况"."<br>";
for ($i=0; $i <count($array['data']) ; $i++) {
    echo $array['data'][$i]["context"]."<br>";
}
function object_array($array)
{
    if(is_object($array))
    {
        $array = (array)$array;
    }
    if(is_array($array))
    {
        foreach($array as $key=>$value)
        {
            $array[$key] = object_array($value);
        }
    }
    return $array;
}