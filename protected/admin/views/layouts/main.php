<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>理财派后台管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/css/base.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/css/page.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/css/module.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/css/common.css">
    
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/jquery-1.10.2.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/common.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/ui/jquery.easyui.min.js"></script>
 	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/ui/themes/default/easyui.css">
 	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/ui/themes/icon.css"> 
 	<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/ui/locale/easyui-lang-zh_CN.js"></script>
</head>

<body class="main_body" id="body">
	<!-- 头部 -->
	<div class="header clearfix">
    	<span class="logo fl"></span>
        <!-- 主导航 -->
        <ul class="main_nav fl">
        	<li><a href="#">首页</a></li>
            <li><a href="#">内容</a></li>
            <li class="main_current"><a href="#">会员</a></li>
            <li><a href="#">系统</a></li>
            <li><a href="#">扩展</a></li>
        </ul>
        <!-- /主导航 -->
        
        <!-- 用户栏 -->        
        <div class="user-bar fr">
            <a class="user-entrance" href="javascript:;"><i class="icon-user"></i></a>
            <ul class="nav-list user-menu dp_none">
                <li><a href="/admin.php?s=/User/updatePassword.html">修改密码</a></li>
                <li><a href="/admin.php?s=/User/updateNickname.html">修改昵称</a></li>
                <li><a href="<?php echo $this->createUrl('index/logout'); ?>">退出</a></li>
            </ul>
        </div>
        <div class="fr white mr15">你好，<em title="admin1"><?php echo Yii::app()->user->Name ; ?></em></div>
        <!-- /用户栏 -->
    </div>
    <!-- /头部 -->
    
    <!-- 左侧 -->
	<div class="sidebar">
    	<div class="subnav" id="subnav">
        	<h3><i class="icon"></i>审核管理</h3>
            <ul class="side-sub-menu">
        	    <li controller="member"><a class="item" href="<?php echo $this->createUrl('member/index')?>">会员信息</a></li>
                <li controller="company"><a class="item" href="<?php echo $this->createUrl('company/index')?>">平台管理</a></li>
                <li controller="post"><a class="item" href="<?php echo $this->createUrl('post/index')?>">帖子管理</a></li>
                <li controller="event"><a class="item" href="<?php echo $this->createUrl('event/index')?>">活动管理</a></li>
                <li controller="auth"><a class="item" href="<?php echo $this->createUrl('/auth/index')?>">实名认证</a></li>
                <li controller="news"><a class="item" href="<?php echo $this->createUrl('/news/index')?>">新闻</a></li>
            </ul>
            <h3><i class="icon icon-fold"></i>其它管理</h3>
            <ul class="side-sub-menu "><!-- 此处加class subnav-off可以缩起tab-->
                <li controller="business"><a class="item" href="<?php echo $this->createUrl('business/index')?>">支付平台</a></li>
                <li controller="business"><a class="item" href="<?php echo $this->createUrl('business/urlList')?>">支付平台生成url</a></li>
                <li controller="talk"><a class="item" href="<?php echo $this->createUrl('talk/index')?>">私信管理</a></li>
                <li controller="inviteCode"><a class="item" href="<?php echo $this->createUrl('inviteCode/index')?>">邀请码</a></li>
                <li controller="homePage"><a class="item" href="<?php echo $this->createUrl('homePage/index')?>">首页管理</a></li>
            </ul>
        </div>
    </div>
    <!-- /左侧 -->
    
    <!-- 主体部分 -->
	<div class="main">
    	<!-- 主体部分(内容) -->
    	<div class="main_content">
        	<div id="top-alert" class="fixed alert alert-error block" style="display: none;">
                <button class="close fixed" style="margin-top: 4px;">&times;</button>
                <div class="alert-content">这是内容</div>
            </div>
        	<?php echo $content;?>
        </div>
        <!-- /主体部分(内容) -->     
         
        <!-- 主体部分(底部信息) -->
        <div class="footer">
            <div class="copyright clearfix">
                <div class="fl">感谢使用 理财派 管理平台</div>
                <div class="fr">V1.0.141008</div>
            </div>
        </div>
        <!-- 主体部分(底部信息) -->    
                       
    </div>
    <!-- /主体部分 -->  
    
    <script>
		$(function(){
			/* 主体部分高度设置 */
			var w_hight=$(window).height();
			$('.main_content').css({'min-height':w_hight-130});
			
			/* 左边菜单高亮 */
			function getUrlParam(name){
			   var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
			   var r = window.location.search.substr(1).match(reg);  //匹配目标参数
			   if (r!=null) return unescape(r[2]); return null; //返回参数值
			} 
			var controller=getUrlParam('r').split('/');
			$('#subnav').find("li[controller='" + controller[0] + "']").addClass('current');
			
			/* 左边菜单显示收起 */
            $("#subnav").on("click", "h3", function(){
                var $this = $(this);
                $this.find(".icon").toggleClass("icon-fold");
                $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
                     prev("h3").find("i").addClass("icon-fold").end().end().hide();
            });
            $("#subnav h3 a").click(function(e){e.stopPropagation()});
			
			/* 头部管理员菜单 */
            $(".user-bar").mouseenter(function(){
                var userMenu = $(this).children(".user-menu ");
                userMenu.removeClass("dp_none");
                clearTimeout(userMenu.data("timeout"));
            }).mouseleave(function(){
                var userMenu = $(this).children(".user-menu");
                userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
                userMenu.data("timeout", setTimeout(function(){userMenu.addClass("dp_none")}, 100));
            });
		})
	</script>
       
</body>
</html>
