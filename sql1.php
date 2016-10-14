<?php

require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(WEBINC."/mysql.php");
require_once(WEBINC."/function.php");

$link=new My_Live_Query();
/*$str="select count(*) from basic_table where res='false'";
$result=$link->get_sql($str);
$row=mysql_fetch_array($result);
echo $row[0];

$str="UPDATE all_comer SET times=times+1 WHERE name='ALL'";
$link->get_sql($str);*/

$str="select * from basic_table";
$result=$link->get_sql($str);
while($row=mysql_fetch_array($result))
{
	print_r($row);
	echo "<br>";
}
?>