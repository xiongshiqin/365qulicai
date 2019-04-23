<?php /* @var $this Controller */ ?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Keywords" content="网贷，p2p网贷，p2p理财，理财派">
  <meta name="Description" content="理财派是中国P2P网贷，P2P理财行业第一门户，专注于提供权威实时的网贷资讯，网贷平台数据，网贷工具等服务，同时汇集上千家网贷平台核心信息供您参考。理财派，为您网贷投资保驾护航！">
  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery-1.9.1.min.js"></script>
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/style.css?t=<?= rand();?>" rel="stylesheet">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/financial.css?t=<?= rand();?>" rel="stylesheet">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/admin.css?t=<?= rand();?>" rel="stylesheet">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/user.css?t=<?= rand();?>" rel="stylesheet">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/colorbox.css?t=<?= rand();?>" rel="stylesheet">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/financial.css?t=<?= rand();?>" rel="stylesheet"> 
  <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">
  <link rel="Bookmark" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico">

  <!--<script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery-ui.js"></script>-->
  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  <script>
  	$(document).ready(function(){
  		// 一级导航光标
  		var curLocation = '<?php echo Yii::app()->controller->id;?>';
  		$('.' + curLocation).addClass('selected').siblings('li').removeClass('selected');

  		// 子导航光标
  		var curAction = '<?php echo $this->getAction()->getId();?>';
  		$('.' + curLocation + '_' + curAction).addClass('selected').siblings('li').removeClass('selected');

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
  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/hrds.js"></script> <!--部分js会冲突，所以放下面-->
 <!--顶部-->
<div id="header">
	<div id="top">
		<div class="right">
			<?php if (Yii::app()->user->isGuest): ?>
				<a href="<?php echo $this->createUrl('/index/login'); ?>" class="btn_login">登录</a>
				<a href="<?php echo $this->createUrl('/index/reg'); ?>" class="btn_login btn_regis">注册</a>
			<?php else : ?>
				<?php $memberCount = MemberCount::model()->findByPk(Yii::app()->user->id);?>
				<div style="width:240px; height:34px; _overflow:hidden;"> 
					<dl class="index_dropdown fy_message">
						<dt>
							<a href="<?php echo $this->createUrl('/home/msgList');?>">
								<em>&nbsp;</em>
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

					<dl class="index_dropdown fy_user">
						<dt>
							<a href="<?php echo $this->createUrl('/home/index' , array('uid' => Yii::app()->user->id));?>">
								<img src="<?php echo HComm::avatar(Yii::app()->user->id);?>" alt="" width="26" height="26"/>
								<cite>&nbsp;</cite>
								<em><?php echo Yii::app()->user->name ; ?></em>
							</a>
						</dt>
						<dd style="display:none;">
							<p><a href="<?php echo $this->createUrl('/home/index'); ?>">个人中心</a></p>
							<p><a href="<?php echo $this->createUrl('/home/myProfile')?>">个人设置</a></p>
							<?php if(Yii::app()->user->cpid):?>
								<p><a href="<?php echo $this->createUrl('/p/p2p/index' , array('cpid' => Yii::app()->user->cpid));?>">管理平台</a></p>
							<?php endif;?>
							<p><a href="<?php echo $this->createUrl('/index/logout'); ?>">退出</a></p>
						</dd>
					</dl>
				</div>
			<?php endif;?>
		</div>

		<div class="left">
			<a href="javascript:void(0)" class="white" onclick="addFavorite()"><span>添加收藏</span></a>  
			<span class="qq">投资交流群 230341007</span>
			<!--a href="javascript:void(0)" class="white" onclick="SetHome(this)">设为主页</a-->  
			<script type="text/javascript">
			function SetHome(obj){
				var url = "http://" + getHost(document.URL);
				try{
					obj.style.behavior='url(#default#homepage)';
					obj.setHomePage(url);
				}catch(e){
					if(window.netscape){
						try{
							netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
						}catch(e){
							alert("非 IE 浏览器请手动将本站设为首页");
						}
					}else{
						alert("非 IE 浏览器请手动将本站设为首页");
					}
				}
			}

			function addFavorite(title) {
				var url = "http://" + getHost(document.URL);
				try {
					window.external.addFavorite(url, title);
				}
				catch (e) {
					try {
						window.sidebar.addPanel(title, url, "");
					}
					catch (e) {
						alert("请按 Ctrl+D 键添加到收藏夹");
					}
				}
			}

			var getHost = function (url) {
				var host = "null";
				if (typeof url == "undefined" || null == url)
					url = window.location.href;
				var regex = /.*\:\/\/([^\/]*).*/;
				var match = url.match(regex);
				if (typeof match != "undefined" && null != match)
					host = match[1];
				return host;
			}
			</script>
		</div>
	</div>
</div>

<!--导航-->
<div id="nav" style="background:#fff;">
	<div class="mainbav">
		<div class="left logo">
			<a href=""><img alt="<?php echo CHtml::encode(Yii::app()->name); ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/logo.png" /></a>
		</div>
		
	
		<div class="searchs">
			<form id="form1" name="form1" method="post" action="" style="float:left;">
				<input type="text" placeholder="输入平台名称" name="cpname" value="" />
				<input class="search_btn" type="submit" name="button" id="button" value="搜&nbsp;索" />
			</form>
			<div class="searchs_text">
				<a href="#">钱根源</a>
				<a href="#">理财派</a>
				<a href="#">P2P活动</a>
				<a href="#">送话费</a>
			</div>
		</div>

		<!--
		<ul class="nav_right">
			<li class="index"><a href="<?php echo $this->createUrl('/'); ?>">首页</a></li>
			<li class="p2p"><a href="<?php echo $this->createUrl('/P2p/list'); ?>">P2P理财</a></li>
			<li class="event"><a href="<?php echo $this->createUrl('/event/p2pEvents'); ?>">平台活动</a></li>
			<li class="group"><a href="<?php echo $this->createUrl('/group/hot'); ?>">小组</a></li>			
		</ul>
		-->
	</div>

	<!--子导航-->
	<div class="subnav_bg">
		<div class="subnav">
		<ul class="subnvali"  style="float:left;">
		<!-- 	<?php if($this->id == 'group'): ?>
				<li class="group_hot selected"><a href="<?php echo $this->createUrl('/group/hot'); ?>">小组首页</a></li>
				<li class="group_mygroup"><a href="<?php echo $this->createUrl('/group/mygroup'); ?>">我的小组</a></li>
			<?php elseif ($this->id == 'p2p' || $this->id == 'business') : ?>
				<li class="p2p_list p2p_myP2p"><a href="<?php echo $this->createUrl('/p2p/list'); ?>">选平台</a></li>
			    	<li class="p2p_choiceBiao"><a href="<?php echo $this->createUrl('/p2p/choiceBiao'); ?>">新标播报</a></li>
				<li class="p2p_newsNotice"><a href="<?php echo $this->createUrl('/p2p/newsNotice')?>">新闻公告</a></li>
			<?php elseif ($this->id == 'event'):?>
				<li class="selected"><a href="<?php echo $this->createUrl('/event/p2pEvents'); ?>">线上活动</a></li>
			<?php elseif ($this->id == 'index'):?>
			<?php endif;?> -->
			<li class="index_index"><a href="<?php echo $this->createUrl('/'); ?>">首页</a></li>
			<li class="p2p_newsNotice news_newsAdd news_newsList news_view"><a href="<?php echo $this->createUrl('/news/newsList'); ?>">新闻</a></li>
			<li class="p2p_list p2p_myP2p"><a href="<?php echo $this->createUrl('/P2p/list'); ?>">选平台</a></li>
			<li class="event_p2pEvents event_p2pEventDetail"><a href="<?php echo $this->createUrl('/event/p2pEvents'); ?>">平台活动</a></li>
			<!-- <li class="p2p_choiceBiao"><a href="<?php echo $this->createUrl('/P2p/choiceBiao'); ?>">选标</a></li>
			<li class="group_hot group_index group_add group_view"><a href="<?php echo $this->createUrl('/group/hot'); ?>">小组</a></li>-->	
			<li><a href="<?php echo $this->createUrl('/index/join');?>">入驻平台</a></li>	
		</ul>

		</div>
	</div>
</div>

	<?php echo $content; ?>

<!--尾部-->
<div class="footerbg">
	<div id="footer">

		<!--左边-->
		<div class="footer_L">
			<p>©Copyright 2017 All Rights Reserved 365qulicai.com . All Rights Reserved. (<a href="http://www.miitbeian.gov.cn/" target="_blank">粤ICP备1408304</a>)</p>
		</div>
	</div>
</div>
<?php include dirname(__FILE__) . "/common.php"?>
</body>
</html>
