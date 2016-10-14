<?php
//数据库查询

class My_Live_Query
{
	public $servername;			//主机名
	public $user;				//用户名		
	public $password;			//pw
	public $my_sql;			//数据库名
	public $mytable;				//数据库表名
	public $link;				//数据库连接
	
	public $res=false;			//判断是否查询到结果
	public $outtime=false; 		//判断时间是否过期
	public $otherpage=false;	//判断是否为第一页，为true则不为第一页	
	//构造函数--初始化数据库
	public function __construct($table="basic_table")
	{
		$this->servername="localhost";
		$this->user="yp7mktzlbb_7087";
		$this->password="Pap2DbdGx6";
		$this->my_sql="yp7mktzlbb_7708";
//		$this->$mytable=isset($table)? $table : "basic_table";
		$this->mytable="basic_table";
		$this->link=mysql_connect($this->servername,$this->user,$this->password);
		if(!$this->link)
			die("初始化数据库失败，请重新尝试！".mysql_error());
		mysql_select_db($this->my_sql,$this->link);
		mysql_query("SET NAMES utf8");
		
	}
	
	//执行sql语句
	public function get_sql($str_sql)
	{
		$result=mysql_query($str_sql) or die("执行数据失败".mysql_error());
		if($result)
			return $result;
		else
			return false;


	}
	//执行sql语句，并改变状态
	public function getsql_andres($str_sql)
	{
		$result=mysql_query($str_sql);
		if(mysql_num_rows($result))
		{
			$this->res=true;
			return $result;
		}
		else
		{
			$this->res=false;
			return false;
		}

	}
	
	public function end_sql()
	{
		mysql_close($this->link);
	}
}

?>