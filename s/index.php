<?php


session_start();  //启用 session
//定义路径、加径配置文件
require_once(dirname(dirname(__FILE__)).'/config.php');
require_once(WEBINC."/mysql.php");
require_once(WEBINC."/function.php");
require_once(WEBINC."/session.php");

$kw=$_GET['kw'];

//过滤页码
if(!empty($_GET['start']))
	$start=check_page($_GET['start']);
else
	$start=0;
	
//判断提交页码是否为第一页
if($start!=0)
		$now_page=$start/10+1;
	else
		$now_page=1;
		
$weburl=$_SERVER['SERVER_NAME'].'/s';
//查询关键字是否存在  --res
$livesql=new My_Live_Query();

//过滤关键字
$kw=check_kw_sql($kw);
$kw=check_kw_str($kw);
$kw_yema=urlencode($kw);//url转码

$qstr="select * from basic_table where keyword='$kw'";
$result=$livesql->getsql_andres($qstr);//查询此关键字是否已存在数据库
if($livesql->res===true)//如果存在
{	

	if($now_page===1)//判断是否是第一页
	{
		$row=mysql_fetch_array($result); 
		$nowtime=date("Y-m-d H:i:s");
		$oldtime=$row['time'];
		$reday=round((strtotime($nowtime)-strtotime($oldtime))/3600/24);
//		echo $reday;
		//判断关键字之前提交离现在是否大于7天
		if($reday<=7)//如果小于7天，则直接输出相应Html
		{
			$qstr="UPDATE basic_table SET counttime=counttime+1 WHERE id='$row[id]'";
			$livesql->get_sql($qstr);
			header("location: ".$row['path']);
		}
		else if($reday>7)//如果大于7天，则设置状态已过期，重新生成html
		{	
			
//			$row=mysql_fetch_array($result);
			$path=$row['path'];
			$path=substr(strrchr($path,'/'),1);
			$qstr="UPDATE basic_table SET counttime=counttime+1,time='$nowtime' WHERE id='$row[id]'";
//			$qstr="UPDATE basic_table SET time='$nowtime' WHERE id='$row[id]'";
			$livesql->get_sql($qstr);
			$livesql->outtime=true;  //设置状态已过期
		}
	}
	else 
		$livesql->otherpage=true;//设置页码状态，如果不是第一页，则访问google生成Html
		
}
//响应页码状态：res--false关键字未曾提交，outtime--true关键字已过期，otherpage--true页码非第一页
if($livesql->res===false || $livesql->outtime===true ||$livesql->otherpage===true)
{
	
	ob_myopen();//开启缓存
	
	//访问google,获取搜索结果
	$url=seturl($kw_yema,$start);
	$moument=get_url_file($url);
	
	//获取统计的搜索结果数量（数字形式）
	$num=get_num($moument,true);

	if($num)
	{
		$str_num=get_str_num(get_num($moument,false));//生成统计结果html代码
		//利用正则获取并生成搜索结果html代码
		$str_moument=get_str_moument(get_moument($moument));
		$str_moument=str_replace('"',"'",$str_moument);
		$str_moument=str_replace("\n","",$str_moument);
		
		//利用统计结果数量生成页码  mysql--页码类
		$data=array(
			'kw'=>$kw_yema,
			'total_rows'=>$num,
			'parameter'=>"/s",
			'now_page'=>$now_page
		);
	
		$str_page=get_str_page($data);
		$str_page=str_replace('"',"'",$str_page);
		
/*		//利用js输出结果
	//	show_str($str_num);
	//	show_str($str_moument,'content_text');
	//	show_str($str_page,'content_footer');*/
	
		include (WEBSEARCH.'/content.htm');//加载搜索结果页模板
		show_form_value($kw);//设置输入框
		
		//获取缓冲区内容并输出，结束缓冲区
		$content=get_ob_file();
		ob_myclose();
		
		//如果时间过期，则重新生成html，文件名不变
		if($livesql->outtime===true)
		{
			$path=WEBROOT.'/a_file/'.$path;
			make_html($path,$content);
		}
		
		//判断是否为第一页状态，以此判断是否保存文件、写入数据库
		if($livesql->otherpage===false && $livesql->outtime===false)//为第一页，保存文件，写入数据库
		{
			//------
		//设置文件存储路径
			$str_path="livecho_";
			$path=WEBROOT.'/a_file/'.$str_path;
			$path=make_path($path);
			
			//生成html
			$suc_html=make_html($path,$content);
			
			$name=substr(strrchr($path,'/'),1);//获取文件名
		//	echo $name;
			
			
			//写入数据库
			if($suc_html===true)
			{

				$path='http://'.$_SERVER['SERVER_NAME'].'/a_file/'.$name;
				$date=date('Y-m-d H:i:s');
				if(isset($_GET['res']))
					$str_add="INSERT INTO basic_table(keyword,path,time,res,counttime) VALUES('$kw','$path','$date','add','1')";
				else
					$str_add="INSERT INTO basic_table(keyword,path,time,res,counttime) VALUES('$kw','$path','$date','false','1')";
					
				$str_uptdate="UPDATE basic_table SET path='$path',time='$date' WHERE id='$row[id]'";
				if($livesql->res===false)
					$livesql->get_sql($str_add);
				if($livesql-outtime===true)
					$livesql->get_sql($str_update);
				
				
			}
	
		}
	}
	else//搜索结果为0
	{
		$str_num=get_str_num($num);
		$str_moument="";
		$str_page="";
		include (WEBSEARCH.'/content.htm');
		show_form_value($kw);
	}
}
$livesql->end_sql();

?>