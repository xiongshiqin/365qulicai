<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>404</title>
<style>
html,body{ margin:0; padding:0; height:100%; width:100%; overflow:hidden; font-size:14px; color:#999;}
.lcp_404{ position:absolute; top:50%; left:50%; margin-left:-294.5px; margin-top:-80px; height:160px; width:585px; background:url(<?php echo Yii::app()->request->baseUrl; ?>/images/404.jpg) no-repeat;}
.lcp_404 span{ display:block; text-align:center; padding-top:140px;}
.lcp_404 a{ text-decoration:none; color:#5E93CF;}
.lcp_404 a:hover{ text-decoration:underline;}
#time_404{ color:#f00;}
</style>
<script>
window.onload = function(){
	var i = 5;
	window.setInterval(function(){
		if(i <= 0){
			document.location.href="http://www.licaipi.com/";	
		}else{
			i-=1;
			document.getElementById("time_404").innerHTML = i;
		}
	},1000);
}
</script>
</head>
<body>

<div class="lcp_404">
	<span class="ts_404">
		<em style="padding-left:100px; font-style:normal;">
		<a href="http://www.licaipi.com/">返回首页</a>
		&nbsp;<b id="time_404">5</b>
		&nbsp;秒之后页面自动跳转...
		</em>
	</span>
</div>

</body>
</html>
