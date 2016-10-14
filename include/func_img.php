<?php

//过滤SQL字符
function check_kw_sql($value)
{
	// 去除斜杠
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	
	}
	// 特殊符号加反斜杠
	if (!is_numeric($value))
	{
		$value =mysql_real_escape_string($value);
	}
	//$value=(!get_magic_quotes_gpc())?addslashes($value):$value;
	return $value;
}

//限制长度，过滤空格等一些特殊字符串
function check_kw_str($str)     
{     
    $farr = array(     
        "/\s+/", //过滤多余空白     
         //过滤 <script>等可能引入恶意内容或恶意改变显示布局的代码,如果不需要插入flash等,还可以加入<object>的过滤     
 //       "/<(\/?)(script|i?frame|style|html|body|title|link|meta|\?|\%)([^>]*?)>/isU",    
 //       "/(<[^>]*)on[a-zA-Z]+\s*=([^>]*>)/isU",//过滤javascript的on事件 
 		"/^[\s]+/",
		"/<[\"|\']/",  
   );     
   $tarr = array(     
        " ",     
//        "＜\1\2\3＞",//如果要直接清除不安全的标签，这里可以留空     
//        "\1\2",   
		"",
		" ",  
   );     
  $str = preg_replace( $farr,$tarr,$str);
  if(strlen($str)>90)
  	$str=substr($str,0,90);     
   return $str;     
}  


function check_page($start)
{
	if(!is_numeric($start))
		$start=0;
	else
	{
		if($start<0 || $start >1000)
			$start=0;
		else
		{
			$start=intval($start);
			if(($start%20)!=0)
				$start=0;
		}
	}
	return $start;
}

function SetImgUrl($kw,$start=0,$url="https://ajax.googleapis.com/ajax/services/search/images")
{
	$url_change=$url."?q=".$kw."&v=1.0&rsz=8&start=".$start;
	return $url_change;
}
function GetImgJson($url)
{
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
	
	$body = curl_exec($ch);
	curl_close($ch);
	// now, process the JSON string
	$json = json_decode($body);
	return $json;
}

function GetImgResult($kw,$page)
{
	$result=array();
	$index=0;
	for($i=0;$i<$page;$i++)
	{
		$start=$i*8;
		$url=SetImgUrl($kw,$start);
		$json=GetImgJson($url);
		$num=count($json->responseData->results);
		foreach($json->responseData->results as $sob)
		{
			$result[$index][url]=$sob->url;
			$result[$index][width]=$sob->width;
			$result[$index][height]=$sob->height;
			$index++;
		}
		
	}
	return $result;
}

?>