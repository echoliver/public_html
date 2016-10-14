<?php 
require_once(dirname(dirname(dirname(__FILE__)))."/config.php");
require_once(WEBINC."/func_img.php");
$kw=$_GET['kw'];
$kw=urlencode($kw);
/*$kw_yema=urlencode($kw);//url转码,用于设置页码链
//过滤关键字
$kw=check_kw_sql($kw);
$kw=check_kw_str($kw);
//设置翻页	
if(!empty($_GET['start']))
	$start=check_page($_GET['start']);
else
	$start=0;

if($start!=0)
		$now_page=$start/10+1;
	else
		$now_page=1;*/
		
//获取查询结果，以JSON方式返回
$re=GetImgJson(SetImgUrl($kw));
//获取页码长度
$page=count($re->responseData->cursor->pages);
//获取查询结果数量
$num=$re->responseData->cursor->resultCount;
$num=intval(str_replace(",","",$num));

$img_result=GetImgResult($kw,$page);
echo count($img_result);
/*echo "<br>";
foreach($img_result as $value)
{
	print_r($value);
}
echo "////////////////////////////////////////////////////////////////";
echo "<br>";*/
$data=json_encode($img_result);
//echo $data;
include("content.htm");
//include(dirname(dirname(__FILE__))."/js/img.js");
//echo "<script>var de=123;ceshi(de);</scirpt>";







?>