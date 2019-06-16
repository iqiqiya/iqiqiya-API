<?php
// 存储数据的文件
$filename = 'data.dat';        
 
// 指定页面编码
header('Content-type: text/html; charset=utf-8');
 
if(!file_exists($filename)) {
    die($filename . ' 数据文件不存在');
}
 
$data = array();
 
// 打开文档
$fh = fopen($filename, 'r');
 
// 逐行读取并存入数组中
while (!feof($fh)) {
    $data[] = fgets($fh);
}
 
// 关闭文档
fclose($fh);
 
// 随机获取一行索引
$result = $data[array_rand($data)];
 
echo $result;