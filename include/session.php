<?php

$retime=7200;
$nowtime=date("Y-m-d H:i:s");
$today=date("Y-m-d");

if(!isset($_SESSION['mytime']))
{

	$_SESSION['mytime']=$nowtime;

	$str="UPDATE all_comer SET times=times+1 WHERE name='ALL'";
	$live=new My_Live_Query;
	$live->get_sql($str);
	$strL="select * from date_comer where date='$today'";
	$result=$live->get_sql($strL);
	if(!mysql_num_rows($result))
	{

		$str_in="insert into date_comer (date,times) values ('$today','1')";
		$live->get_sql($str_in);
	}
	else
	{
		$str_in="update date_comer set times=times+1 where date='$today'";
		$live->get_sql($str_in);
	}
	
}
else
{

	if(strtotime($nowtime)-strtotime($_SESSION['mytime'])>$retime)
	{
		$str="UPDATE all_comer SET times=times+1 WHERE name='ALL'";
		$live=new My_Live_Query;
		$live->get_sql($str);
		$strL="select * from date_comer where date='$today'";
		$result=$live->get_sql($strL);
		if(!mysql_num_rows($result))
		{
			$str_in="insert into date_comer (date,times) values ('$today','1')";
			$live->get_sql($str_in);
		}
		else
		{
			$str_in="update date_comer set times=times+1 where date='$today'";
			$live->get_sql($str_in);
		}
		
	}
	$_SESSION['mytime']=$nowtime;
}



?>