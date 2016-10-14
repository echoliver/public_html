<?php
//$url="http://php.net/manual/zh/function.parse-url.php";
//print_r(parse_url($url));

//$url="192.168.0.106/s?kw=乒乓球";
/*$put=file_get_contents($url);*/
//$url="http://www.google.com.hk/search?q=%E9%BE%99%E5%8A%B2%E8%88%9F&oe=utf-8&sa=p&hl=zh-CN&pref=hkredirect&pval=yes";
//$url="http://www.google.com.hk/search?#safe=strict&q=%E9%BE%99%E5%8A%B2%E8%88%9F";

//$url="http://www.google.com.hk/search?hl=zh-CN&biw=1366&bih=649&q=ajax&oq=ajax+comment&aq=f&aqi=g9g-m1&aql=&gs_sm=e&gs_upl=5916l9958l0l10319l16l14l1l0l0l0l267l1925l0.6.4l10l0";
//$url="http://www.google.com.hk/search?q=LOL&hl=zh-CN&oe=utf-8";
$url="http://www.google.com";

//$header = array( 'CLIENT-IP:103.31.20.207' ); 
$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER,0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
//	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5');
	$put=curl_exec($ch);
	curl_close($ch); 
echo $put;

/*$fh=fopen("c.html","w");    
fwrite($fh,$put);    //写入html,生成html  
fclose($fh);*/
?>