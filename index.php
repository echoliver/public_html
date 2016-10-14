<?php session_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="gg404.com为您提供最稳定的谷歌搜索镜像服务，想用谷歌搜索却发现404无法访问了，那就快用gg404.com吧。让您快速的搜索到想要的网站。" />
<mata name="keywords" content="谷歌,谷歌搜索,谷歌404,gg404,GG404,搜索引擎" />
<link href="style/style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/goo.js"></script>

<title>谷歌搜索 404打不开 就用 GG404.COM</title>
<?php 
require_once(dirname(__FILE__).'/config.php');
require_once(WEBINC."/mysql.php");
require_once(WEBINC."/func_sy.php");
require_once(WEBINC."/session.php");
?>
</head>

<body>
<div id="container">
	<div id="moument" style="pading-top:150px;">
		<div id="logo_imgbox">	
			<div id="logo_img">
				<a href="http://www.gg404.com"><img width="450px" height="130px" alt="liver谷歌搜索" src="image/404_2.jpg" /></a>			</div>
			<form name="form1" action="/s" method="GET" onsubmit="return checkText();">
			<div class="input_set" style="margin-top:10px;">
				<input type="text" name="kw" id="text_in" style="height: 30px; width:600px;font-size:18px; max-width: 605px;float:left;"/>
				<input style="height:32px;width:76px;font-size:18px;float:right;margin-left:0;" type="submit" value="搜 索"/>
			</div>
			</form>		
		</div>
	</div>
	<div id="list_box" class="solist_box">
		<div class="list_left">
			<div class="list_title"><p>最近搜索</p><hr></div>
			<div class="list">
				<ul>
					<?php
						$live=new My_Live_Query();
						$list=get_data($live,'add',0,10); 
						$str_list=get_data_str($list);
						echo $str_list;
					?>
				</ul>
			</div>
		</div>
			
		<div class="list_right">
			<div class="list_title"><p>看看其他人还搜些什么</p><hr></div>
			<div class="list">
				<ul>
					<?php 
						$list=get_rand_data($live,10);
						$str_list=get_data_str($list);
						echo $str_list;
					?>
				</ul>
			</div>
		</div>
	</div>
	<div class="footer">
    友情链接：<a href="http://1asd.com" target="_blank">成都网站优化</a><br/>
    Copyright ©2015 www.gg404.com
	<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1255575683'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s11.cnzz.com/z_stat.php%3Fid%3D1255575683%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>

	</div>
</div>

<script type="text/javascript" src="js/jquery-1.4.2.js"></script>
<script type="text/javascript">
//$('list').hover(function(){ $(this).height(400)});

</script>

</body>



</html>


