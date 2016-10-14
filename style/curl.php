<?php

$url="https://www.google.com/search?q=%E7%9F%A5%E4%B9%8E&biw=1440&bih=714&source=lnms&tbm=isch&sa=X&ved=0CAYQ_AUoAWoVChMIjeSn1Yz9xgIVgi-ICh0wGwsr";
$header=array("Content-Type:json");
$ch=curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
//	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5.11');
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
//	curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
//	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
//	curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
//	curl_setopt($ch,CURLOPT_COOKIEFILE,"R0U6GWJ7.txt");
$output=curl_exec($ch);
	curl_close($ch);
//$url="http://www.google.com.hk/search?q=小鸡&oe=utf-8&start=0";


//$str_count='/id=\"resultStats\">[^\d|<]*([\d]+[,]?[\d]+[,0-9]+)?[^\d]*/';
//$str_count='/id=\"resultStats\">[^\d|<]*([\d,]+)[^\d]*/';
//	preg_match($str_count,$output,$number);

//$output=file_get_contents($url);
//print_r($number);*/

//$output=file_get_contents($url);
//echo $output;
?>


