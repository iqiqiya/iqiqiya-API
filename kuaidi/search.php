<?php
//http://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=73107853468716
//http://www.kuaidi100.com/query?type=zhongtong&postid=73107853468716&temp=0.5697053744006431&phone=
$numbe = $_GET['firstname'];
$company = file_get_contents("http://www.kuaidi100.com/autonumber/autoComNum?resultv2=1&text=".$numbe);
//echo($company);
//{"comCode":"","num":"73107853468716","auto":[{"comCode":"zhongtong","id":"","noCount":56573,"noPre":"73107","startTime":""}]}
//$pattern = '\u0022auto\u0022[{\u0022comCode\u0022:\u0022(.*?)\u0022,';
preg_match_all('#"comCode":"(.*?)"#',$company,$match);
$company = $match[1][1];
//echo $company;
//$company = file_get_contents("http://www.kuaidi100.com/query?type=".$company."&postid=".$numbe."&phone=");


ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 2.0.50727;)');
$company = file_get_contents('http://www.kuaidi100.com/query?type='.$company.'&postid='.$numbe.'&phone=');
//echo($company);



$c= json_decode($company); 
$array = object_array($c);
//var_dump($array);
echo "你的快递运送情况"."<br>";
for ($i=0; $i <count($array['data']) ; $i++) { 
	echo $array['data'][$i]["context"]."<br>";
}
/*preg_match_all('/"(.*?)"/',$company,$match);
/*for ($i=20; $i <count($match[1]) ; $i=$i+8) { 
	echo $match[1][$i]."=====".$match[1][$i+4]."=====".$match[1][$i+8]."\n";
}*/
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
?>