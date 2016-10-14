<?php


//检查首页显示的关键字是否合适
function check_kw($str)
{

	$res=true;
	$filename=WEBINC."/kw.txt";
	$lens=filesize($filename);
	$hand=fopen($filename,'r');
	$content=fread($hand,$lens);
	$string_a=explode("，",$content);	

	foreach($string_a as $value)
	{
		if(strstr($str,$value))
		{
			$res=false;
		}

	}
	return $res;	
}

//两个关键字是否相似
function check_like($str1,$str2) //相似返回true,否则返回false
{

	$len1=strlen($str1);
	$len2=strlen($str2);
	$len=($len1<=$len2) ? $len1 : $len2;

	$res=($len1>=$len2) ? @stristr($str1,$str2) : @stristr($str2,$str1);
	if($res)
	{
		return true;
	}
	else
	{
		$pair=similar_text($str1, $str2, $percent);
		if($pair>$len/2 && $percent>=50)
		{
			return true;
		}
	}
	return false;
	
	
}


//获取最近数据库记录true
function get_data($link,$res,$start,$num)  		//数据库连接对象，起始数据，数据条数
{	
	$list=array();//获取记录存放数组
	$n=0;//获取的记录数
	$pos=0;//数据库记录位置
	$str="select * from basic_table where res='$res'";
	$result=$link->get_sql($str);
	$cout=mysql_num_rows($result);
	if($cout)
	{
		while($start<=$cout)
		{
	
			$str="select keyword,path from basic_table where res='$res' order by time desc limit $start,1";
			$result=$link->get_sql($str);
			$row=mysql_fetch_array($result,MYSQL_ASSOC);
			if(check_kw($row['keyword'])===true)
			{
	
				$list[$n++]=$row;
				$pos=$start;
				break;
			}
			else
				$start=$start+1;
		}
		
		while($n<$num && $n<$cout && $pos<$cout-1)
		{	
			$pos=$pos+1;
			$d_res=true;
			$str="select keyword,path from basic_table where res='$res' order by time desc limit $pos,1";
			$result=$link->get_sql($str);
			
			$row=mysql_fetch_array($result,MYSQL_ASSOC);
	
			if(check_kw($row['keyword'])===true)
			{
				for($i=0;$i<count($list);$i++)
				{
					if(check_like($row['keyword'],$list[$i]['keyword'])===true)
					{
						$pos=$pos+1;
						$d_res=false;
					}	
				}
				if($d_res===true)
				{
					$list[$n++]=$row;	
				}
			}
			else
				$pos=$pos+1;
				
		}
		if(!empty($list))
		{
			return $list;
		}
		else
			return false;
	}//end if($result=$link->get_sql(str))
	else
		return false;
}

//获取随机数据库记录false
function get_rand_data($link,$num)
{	
	$list=array();//获取记录存放数组
	$n=0;//获取的记录数
	$remove=0;//记录被排除的记录数
	$remove_frist=0;//记录第一次取结果的记录数
//	$pos=0;//数据库记录位置
	$ran=array();//存储随机数数组
	$str="select * from basic_table where res='false'";
	$result=$link->get_sql($str);
	$cout=mysql_num_rows($result);
	if($cout>=$num)
	{
		$error_num=$cout-$num;//设置可以排除关键字的总数量
		$move_res=true;//数据库记录数大于等于$num
	}
	else
	{
		$error_num=$cout;
		$move_res=false;//数据库记录数小于$num
	}
	if($cout)
	{

		$start=rand(0,$cout-1);//获取随机记录数
		
		//随机获取第一个关键字
		while($remove_frist<$cout)
		{

			$str="select keyword,path from basic_table where res='false' limit $start,1";
			$result=$link->get_sql($str);
			$row=mysql_fetch_array($result,MYSQL_ASSOC);
			//检查关键字是否合适
			if(check_kw($row['keyword'])===true)
			{

				$list[$n]=$row;
				$ran[$n]=$start;
				$n++;
				break;
			}
			else
			{
				$remove_frist++;
				$start=rand(0,$cout-1);
			}
		}
		//获取其他关键字
		while($n<$num && $n<$cout)
		{	
		//获取不重复随机数，成功则跳出循环往下执行
			while(1)
			{
				$ran_res=true;
				$pos=rand(0,$cout-1);
				foreach($ran as $value)
				{
					if($pos==$value)
						$ran_res=false;
				}
				if($ran_res===true)
				{	
					$start=$pos;
					break;
				}
				
			}
			
			//查询关键字并获取
			$d_res=true;//判断随机取出的关键字是否和之前取出的相似 true--不相似，false--相似
			$str="select keyword,path from basic_table where res='false' limit $start,1";
			$result=$link->get_sql($str);
			$row=mysql_fetch_array($result,MYSQL_ASSOC);
			//----
			
			//检查关键字是否合适，是否与之前雷同
			if(check_kw($row['keyword'])===true)
			{
				for($i=0;$i<count($list);$i++)
				{
					if(check_like($row['keyword'],$list[$i]['keyword'])===true)
						$d_res=false;
				}
				if($d_res===true)//如果不雷同，则存储关键字到$list
				{
					$list[$n]=$row;
					$ran[$n]=$start;
					$n++;	
				}
				else
				{
					$remove++; //被排除数+1
					if($move_res)//数据库记录大于提取数量
					{
						if($remove>$error_num)//如果当前排除数大于可以排除的总数，提取记录数减1
							$num--;
					}
					else
						$num--;
				}
			}
			
				
		}

		if(!empty($list))
			return $list;
		else 
			return false;
	}
	else
		return false;			
}

//包装获取记录数html
function get_data_str($list)
{
	$str_qing="";
	if($list!=false)
	{
		foreach($list as $value)
		{
			$str_qing.="<li>";
	//		echo $str_qing;
			$str_qing.="<a href=\"".$value['path']."\" target=\"_blank\">";
			$str_qing.=$value['keyword'];
			$str_qing.="</a>";
			$str_qing.="</li>";
		}
	}
	else
		$str_qing="暂无数据";

	return $str_qing;
	
}


?>