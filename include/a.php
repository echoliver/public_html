<?php 
//require_once("pageL.php");
//开启与结束缓冲区
function ob_myopen()
{
	ob_start();
}
function ob_myclose()
{
	ob_end_clean(); 
}

//包装url
function seturl($url='http://www.google.com.hk/search',$kw,$start)
{
	$url_change=$url."?q=".$kw."&ie=utf-8&oe=utf-8&start=".$start;
	return $url_change;
}
//使用curl获取查询内容
function get_url_file($url)
{
	$ch=curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	
	$output=curl_exec($ch);
	curl_close($ch);
	return $output;
}
// 使用正则统计结果
function get_num($filevalue,$inta=false)
{
	$str_count='/id=\"resultStats\">[^\d]*([\d]+[,]?[\d]+)[^\d]*/';
	preg_match($str_count,$filevalue,$number);
	if($inta===false)
	{
		$num=$number[1]; 
	}
	else if($inta===true)
	{
		$num=intval(str_replace(",","",$number[1]));
	}
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
	$str_moument .="<ul>\n";
	for($i=0;$i<$cout;$i++)
	{
		$str_moument .="<li>\n";
		for($n=1;$n<$fix;$n++)
		{
			switch($n){
				case 1:
					$result[$n][$i]=urldecode($result[$n][$i]);//转换url字符
					$result[$n][$i]="<h3>\n<a href=\"".$result[$n][$i]."\">";	//输出链接地址<a>
				
					break;
				case 2:
					$result[$n][$i]=$result[$n][$i]."</a>\n</h3>\n";//输出标题
										
					break;
				case 3:	
				//输出描述地址
					break;
				case 4:
					$result[$n][$i]=str_replace("<br>","",$result[$n][$i]);//替换空格
					$result[$n][$i]="\n<div class=\"s\">\n<span>".$result[$n][$i]."</span>\n</div>\n";//输出描述字符
										
					break;
					  }
			$str_moument .=$result[$n][$i];
		}
		$str_moument .="</li>\n";
	}
	$str_moument.="</ul>\n";
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
	$str_out="<script>document.getElementById($id).innerHTML=$str;</script>";
	echo  $str_out;
}




?>