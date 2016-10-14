<?php 
$url="https://www.google.com.hk/search?q=柳岩不照雅照片原图&newwindow=1&oe=utf-8&sa=3&xhr=t";

$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_HEADER,0);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
//curl_setopt($ch,);
$outputs=curl_exec($ch);
curl_close($ch);
//$str_count="/id=\"resultStats\">[^\d|<]*([\d,]+)[^\d]*/";//匹配搜索统计结果
//$str='/div[\s]id=\" center_col\">([.\n]*)<div[\s]id=\"foot\">/';
//$str='/div[\s]id=\"res\">(.*)<div[\s]id=\"foot\">/';//成功匹配图像内容
//preg_match($str_count,$outputs,$out);
//preg_match($str,$outputs,$out);
//echo $outputs;
//print_r($out);
//-------------------google文档---------------------------------
/*$url = "https://ajax.googleapis.com/ajax/services/search/images?" .
       "v=1.0&q=flower&userip=103.230.122.176";
//$url="https://www.google.com.hk/search?q=知乎&tbm=isch&newwindow=1&oe=utf-8&sa=3&xhr=t";
// sendRequest
// note how referer is set manually
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
//curl_setopt($ch, CURLOPT_REFERER,"www.gg404.com");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
$body = curl_exec($ch);
curl_close($ch);
print_r($body);
// now, process the JSON string
$json = json_decode($body);*/





?>