<?php
/**
 * 皮皮搞笑APP短视频无水印解析
 * 作者：iqiqiya (77sec.cn)
 * 日期：2019/8/28
 */
error_reporting(0);
function curl_pipigaoxiao($id)
{
    //初始化
    $cl = curl_init();
    //设置抓取的url
    curl_setopt($cl, CURLOPT_URL, 'http://h5.ippzone.com/ppapi/share/fetch_content');
    //设置头文件的信息作为数据流输出
    curl_setopt($cl, CURLOPT_HEADER, 1);
    //设置获取的信息以文件流的形式返回，而不是直接输出。
    curl_setopt($cl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($cl, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json;charset=utf-8',
        'Origin: http://h5.ippzone.com',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36'
    ));
    curl_setopt($cl, CURLOPT_REFERER, 'http://h5.ippzone.com/pp/post/78266943052');//修改Referer
    //设置post方式提交
    curl_setopt($cl, CURLOPT_POST, 1);
    $video_id = $id;
    //设置post数据
    $post_data = "{\"pid\":".$video_id.",\"type\":\"post\",\"mid\":null}";
    //var_dump($post_data);
    //$data = http_build_query($post_data);
    curl_setopt($cl, CURLOPT_POSTFIELDS, $post_data);
    //执行命令
    $data = curl_exec($cl);
    //关闭URL请求
    curl_close($cl);
    //显示获得的数据
    return $data;
}
function getPiPiId($VideoUrl)
{
    $temp = $VideoUrl."/";
    preg_match("~post/(.*?)/~", $temp, $matches);
    if (count($matches) == 0) {
        echo '无法解析此视频，请换个链接试一下。';
        exit;
    }
    $video_id = $matches[1];
    //echo $video_id;

    $contents = curl_pipigaoxiao($video_id);
    print_r($contents);

    //两种链接形式
    //http://share.ippzone.com/pp/post/83149094856
    //http://h5.ippzone.com/pp/post/78266943052
}
//$VideoUrl = "http://h5.ippzone.com/pp/post/78266943052";
$VideoUrl = $_POST['url'];
getPiPiId($VideoUrl);
?>