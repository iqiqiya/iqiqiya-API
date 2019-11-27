<?php
// 获取qq头像https外链
error_reporting(0);
header('Content-Type: text/html;charset=utf-8');
$QQ = $_GET["nk"];
$size = $_GET["s"];
$type = $_GET["b"];
$headimg = "http://q1.qlogo.cn/g?b=".$type."&nk=".$QQ."&s=".$size."";
$site_url = "blog.77sec.cn";//自行更改自己的域名
//将源码的q.qlogo.cn替换为$site_url
//新建g文件夹
function file_get_img($QQ,$url,$size,$site_url)
{
    $filename = $QQ.'_'.$size.'.jpg';//文件名称生成
    if (file_exists($filename)){
        //echo "https://api.77sec.cn/qq/".$filename;
        header("Location:"."https://".$site_url."/qq/".$filename);
        exit();
    }else{
        $state = @file_get_contents($url,0,null,0,1);//获取网络资源的字符内容
        if($state){

            ob_start();//打开输出
            readfile($url);//输出图片文件
            $img = ob_get_contents();//得到浏览器输出
            ob_end_clean();//清除输出并关闭
            $size = strlen($img);//得到图片大小
            $fp2 = @fopen($filename, "a");
            fwrite($fp2, $img);//向当前目录写入图片文件，并重新命名
            fclose($fp2);
            return 1;
        }
        else{
            return 0;
        }
    }
}
$flag = file_get_img($QQ,$headimg,$size,$site_url);
if ($flag == 1){
    //echo  "https://api.77sec.cn/qq/".$QQ.'_'.$size.'.jpg';
    header("Location:"."https://".$site_url."/qq/".$filename);
    exit();
}else{
    header("Location:"."https://blog.77sec.cn/usr/themes/Akina/images/akinadeaava.jpg");
    exit();
}
?>