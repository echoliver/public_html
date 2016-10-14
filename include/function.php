<?php



require_once(WEBINC.'/pageLL.php');
//开启与结束缓冲区，获取缓冲区内容
function ob_myopen()
{
	ob_start();
}
//获取缓存数据
function get_ob_file()
{
	$gethtml=ob_get_contents();
	return $gethtml;
}
function ob_myclose()
{
	ob_end_flush();
	ob_end_clean(); 
}
//包装url，将关键字转码成Url编码
function seturl($kw,$start,$url='http://www.google.com.hk/search')
{
	$url_change=$url."?q=".$kw."&oe=utf-8&safe=active&start=".$start;
	return $url_change;
}
//使用curl获取查询内容
function get_url_file($url)
{
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	
	
	$output=curl_exec($ch);
	curl_close($ch);
	return $output;
}
// 使用正则统计结果
function get_num($filevalue,$inta=false)
{
//	$str_count='/id=\"resultStats\">[^\d|<]*([\d]+[,]?[\d]+[,0-9]+)[^\d]*/';
	$str_count='/id=\"resultStats\">[^\d|<]*([\d,]+)[^\d]*/';
	preg_match($str_count,$filevalue,$number);
	if($inta===false)
	{
		$num=$number[1]; 
	}
	else if($inta===true)
	{
		$num=intval(str_replace(",","",$number[1]));
	}
//	print_r($number);
//	echo $num;
	return $num;
	
}
//生成统计结果字符串
function get_str_num($num)
{
	$str_num="<span>共找到约".$num."个结果</span>";
	return $str_num;
}

//正则获取各项值：链接地址--链接标题---显示地址---搜索简介
function get_moument($filevalue)
{
	$str_moument='/<[h|H]3[\s]?class=\"r\"><[a|A][^\?]*\?q\=([^&]*?)&[^>]*>(.*?)<\/a>.*<div[\s]?class\=\"kv\"[^>]*>(<cite>.*<\/cite>)<[\s\S]*?<span[\s]class\=\"st\">([\s\S]*?)<\/span>/';
	preg_match_all($str_moument,$filevalue,$result);
	return $result;
}

//生成搜索结果字符串
function get_str_moument($result)
{
	$cout=count($result[0]);
	$fix=5;
	$str_moument="";
	$str_moument .="<ul>";
	for($i=0;$i<$cout;$i++)
	{
		$str_moument .="<li>";
		for($n=1;$n<$fix;$n++)
		{
			switch($n){
				case 1:
					$result[$n][$i]=urldecode($result[$n][$i]);//转换url字符
					$result[$n][$i]="<h3><a href=\"".$result[$n][$i]."\" target=\"_blank\">";	//输出链接地址<a>
				
					break;
				case 2:
					$result[$n][$i]=$result[$n][$i]."</a></h3>";//输出标题
										
					break;
				case 3:	
				//输出描述地址
					break;
				case 4:
					$result[$n][$i]=str_replace("<br>","",$result[$n][$i]);//替换空格
					$result[$n][$i]="<div class=\"s\"><span>".$result[$n][$i]."</span></div>";//输出描述字符
										
					break;
					  }
			$str_moument .=$result[$n][$i];
		}
		$str_moument .="</li>";
	}
	$str_moument.="</ul>";
	return $str_moument;
}

//获取页码字符串
function get_str_page($data)
{
	$str_page="";
	$page=new Core_Lib_Page($data);
	$str_page .=$page->show(1);
	return $str_page;
}

//输出统计字符串
function show_str($str,$id='content_num')
{
	$str_out="<script>var str=\"$str\";document.getElementById('$id').innerHTML=str;</script>";
	echo  $str_out;
}
function show_form_value($str,$id='text_in')
{
	$str_out="<script>var str=\"$str\";document.getElementById('$id').value=str</script>";
	echo $str_out;
}

//生成html路径
function make_path($name)
{
	$count=5456;
	$filename=$name.$count.".html";
	while(file_exists($filename))
	{
		$count++;
		$filename=$name.$count.".html";
	}
	return $filename;
}
/*
 *过滤提交的关键字
 *
*/
//过滤SQL字符
function check_kw_sql($value)
{
	// 去除斜杠
	if (get_magic_quotes_gpc())
	  {
	  $value = stripslashes($value);
	
	  }
	// 如果不是数字则加引号
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

/*
 *过滤页码页
*/
function check_page($start)
{
	if(!is_numeric($start))
		$start=0;
	else
	{
		if($start<0 || $start >500)
			$start=0;
		else
		{
			$start=intval($start);
			if(($start%10)!=0)
				$start=0;
		}
	}
	return $start;
}

//生成html文件
function make_html($name,$file)
{
	$suc_html=FALSE;

	if(!$fp=@fopen($name,'w'))
	{
		echo "shibai";
		return $suc_html;
	}	
	$suc_html=@fwrite($fp,$file)===FALSE ? FALSE : TRUE;
	@fclose($fp);
	
	return $suc_html;
}
?>