<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Keywords" content="网贷，p2p网贷，p2p理财，理财派">
  <meta name="Description" content="理财派是中国P2P网贷，P2P理财行业第一门户，专注于提供权威实时的网贷资讯，网贷平台数据，网贷工具等服务，同时汇集上千家网贷平台核心信息供您参考。理财派，为您网贷投资保驾护航！">
 <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery-1.9.1.min.js"></script>
  <title>我的平台</title>
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/style.css" rel="stylesheet"> 
  
<link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/financial.css?t=<?= rand();?>" rel="stylesheet"> 
<link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/admin.css?t=<?= rand();?>" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/user.css?t=<?= rand();?>" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/colorbox.css?t=<?= rand();?>" rel="stylesheet">
<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
<link rel="Bookmark" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">

  <script>
  	$(document).ready(function(){
  		// 导航光标
  		var curLocation = '<?php echo Yii::app()->controller->id;?>';
  		$('.' + curLocation).addClass('selected').siblings('li').removeClass('selected');

  		// 个人设置，私信下拉菜单
  		$('.index_dropdown').hover(function(){
  			$(this).find('dt').addClass('dthover');
  			$(this).find('dd').show();
  		},function(){
  			$(this).find('dt').removeClass('dthover');
  			$(this).find('dd').hide();
  		});
  	});
  </script>
  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery.validate.js"></script>
  </head>

 <body id="body" <?php if(in_array(strtolower(Yii::app()->controller->id.'/'.$this->getAction()->getId()) , Yii::app()->params['specialBody'])) echo " style='background:#f8f8f8;' ";?>>
  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/hrds.js"></script> 
<!--顶部-->
<div class="subnav_bg">
	<div class="user_top">
		<cite style="margin-right:20px;">
			
			<?php if (Yii::app()->user->isGuest): ?>
				<a href="<?php echo $this->createUrl('/index/login'); ?>" class="btn_login">登录</a>
				<a href="<?php echo $this->createUrl('/index/reg'); ?>" class="btn_login btn_regis">注册</a>
			<?php else : ?>
			<?php $memberCount = MemberCount::model()->findByPk(Yii::app()->user->id);?>
			<div style="width:240px; height:38px; _overflow:hidden;"> 
				<dl class="index_dropdown fy_message home_message">
					<dt>
						<a href="">
							<em class="home_mess">&nbsp;</em>
							<?php if(($total =$memberCount->talknum + $memberCount->message)>0):?>
								<cite><?php echo $total;?></cite>
							<?php endif;?>
						</a>
					</dt>
					<dd style="display:none;">
						<p><a href="<?php echo $this->createUrl('/home/msgList');?>">系统通知<em><?php echo $memberCount->message;?></em></a></p>
						<p><a href="<?php echo $this->createUrl('/home/talkList');?>">我的私信<em><?php echo $memberCount->talknum;?></em></a></p>
					</dd>
				</dl>

				<dl class="index_dropdown fy_user home_message">
					<dt>
						<a href="">
							<img src="<?php echo HComm::avatar(Yii::app()->user->id);?>" alt="" width="26" height="26"/>
							<cite>&nbsp;</cite>
							<em class="home_us"><?php echo Yii::app()->user->name ; ?></em>
						</a>
					</dt>
					<dd style="display:none;">
						<p><a href="<?php echo $this->createUrl('/home/index'); ?>"> 个人中心</a></p>
						<p><a href="<?php echo $this->createUrl('/home/myProfile')?>">个人设置</a></p>
						<?php if(Yii::app()->user->cpid):?>
							<p><a href="<?php echo $this->createUrl('/p/p2p/index' , array('cpid' => Yii::app()->user->cpid));?>">管理平台</a></p>
						<?php endif;?>
						<p><a href="<?php echo $this->createUrl('/index/logout'); ?>">退出</a></p>
					</dd>
				</dl>
			</div>
			<?php endif;?>
			
		</cite>
		<div class="subnav">
			<ul class="subnvali">
				<li class="index"><a href="<?php echo $this->createUrl('/'); ?>">首页</a></li>
				<li class="p2p"><a href="<?php echo $this->createUrl('/News/newsList'); ?>">新闻</a></li>
				<li class="p2p"><a href="<?php echo $this->createUrl('/P2p/list'); ?>">选平台</a></li>
				<li class="event"><a href="<?php echo $this->createUrl('/event/p2pEvents'); ?>">平台活动</a></li>
				<!-- <li class="p2p"><a href="<?php echo $this->createUrl('/P2p/choiceBiao'); ?>">选标</a></li> -->
				<li class="group"><a href="<?php echo $this->createUrl('/group/hot'); ?>">小组</a></li>
			</ul>
		</div>
	</div>
</div>


<!--内容区-->
<?php echo $content; ?>

<!--尾部-->
<div class="footerbg">
	<div id="footer">
		<!--左边-->
		<div class="footer_L">
			<p>©Copyright 2014 All Rights Reserved licaipi.com . All Rights Reserved. (<a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备1408304</a>)</p>
		</div>
	</div>
</div>
<?php include dirname(__FILE__) . "/common.php"?>
</body>
</html>
