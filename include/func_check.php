<?php
require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(WEBINC."/mysql.php");

//检查url是否被百度收录
function check_BD($url)
{
	$url='http://www.baidu.com/s?wd='.$url;
	$curl=curl_init();
	curl_setopt($curl,CURLOPT_URL,$url);
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
	$contents=curl_exec($curl);
	curl_close($curl);

 
	if(!stristr($rs,"很抱歉，没有找到"))  
		return true;//收录
	else
		return false;//未收录
	
}

//根据关键字是否被收录，执行相应的状态更新
function kw_check_suc($link)
{
	$str="select id path from basic_table where res='false'";
	$result=$link->get_sql($str);
	while($row=mysql_fetch_array($result))
	{
		if(check_BD($row['path']))
		{
			$q_str="UPDATE basic_table SET res='true' WHERE id='$row['id']'";
			$link->get_sql($q_str);
		}
	}
}

?>