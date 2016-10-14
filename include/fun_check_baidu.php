<?php
require_once(dirname(__FILE__)."mysql.php");

function check_baidu($link,$url)
{
    $url='http://www.baidu.com/s?wd='.$url;
    $curl=curl_init();
    curl_setopt($curl,CURLOPT_URL,$url);
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
    $rs=curl_exec($curl);
    curl_close($curl);

/*    if(!strpos($rs,"很抱歉，没有找到")){
        return 1;  //收录
    }else{
        return 0;  //未收录
    }*/
 
	if(!stristr($rs,"很抱歉，没有找到"))  	
		return 1;//收录
	else
		return 0;//未收录
}

$link=new My_Live_Qurey();
$str="select id,path form basic_table where res='false'";
$result=$link->get_sql($str);
if(mysql_num_rows($result))
{
	while($row=mysql_fetch_array($result))
	{
		
		if(check_baidu($link,$row['path']))
		{
			$str_change="update basic_table set res='true' where path='$row[path]'";
			$link->get_sql($str_change);
		}
	}
}






?>