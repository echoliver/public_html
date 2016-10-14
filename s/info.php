<?php
//定义路径、加径配置文件
//define('WEBROOT',str_replace("\\",'/',dirname(__FILE__)));//定义网站根路

require_once(dirname(dirname(__FILE__)).'/config.php');

$kw=$_GET['kw'];
$kw_yema=urlencode($kw);//url转码
$start=!empty($_GET['start']) ? $_GET['start'] : 0;

include('WEBSEARCH'.'/content.htm');
include('WEBSEARCH'.'/result.php');

?>