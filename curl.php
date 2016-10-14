<?php
require_once(dirname(__FILE__)."/config.php");
require_once(WEBINC."/excel/reader.php");

$fname=WEBINC."/excel/count.txt";
$handle=fopen($fname,'r+');
$lens=filesize($fname);
$content=fread($handle,$lens);
fclose($handle);
$stra=explode(",",$content);

$row=intval(trim($stra[0]));
$excel_b=intval(trim($stra[1]));

//$z=$row+10;
$n=0;
$sheetData=array();//存储excel文件的数据
$dir=WEBINC."/excel/$excel_b.xls";
$data=new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('utf-8');
$data->read($dir);
if($row+10>=$data->sheets[0]['numRows'])
{
	
	$z=$data->sheets[0]['numRows'];
	$excel_b++;
	$wshu=1;
}
else
{
	$z=$row+10;
	$wshu=$z;
}
	
for($row;$row<$z;$row++)
	{
		for($col=1;$col<=1;$col++)
		{
			$sheetData[$n++]=$data->sheets[0]['cells'][$row][$col];
		}	
	}
//echo $n;
print_r($sheetData);

$ch=curl_init();

foreach($sheetData as $kw)
{
	$url="http://www.gg404.com/s?kw=".$kw."&res=add";

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
	curl_exec($ch);
//	sleep(1);
}

curl_close($ch);

$content=$wshu.",".$excel_b;
echo $content;
//rewind($handle);
$handle=fopen($fname,'w');
@fwrite($handle,$content);
fclose($handle);

?>
<script type="text/javascript">
var hour;
var yun;
function yun1()
{
	var myDate = new Date();
	hour = myDate.getHours();
	if (hour > 9 & hour < 12)
	{
		document.write("时间："+hour+"即将刷新");
		setTimeout('window.location.reload()',7200000);
	}
	else
	{
		document.write("时间是："+hour+"点&nbsp;");
		setTimeout('yun1()',7200000);
	}
}
yun1();

</script>