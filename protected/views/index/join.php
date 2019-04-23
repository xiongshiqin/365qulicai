<!--广告-->
<a href=""><div style="height:188px; background: url(<?php echo Yii::app()->request->baseUrl; ?>/html/images/banner.jpg) 50% 0 no-repeat;"></div></a>


<!--P2P平台-->
<div style="background:#f8f8f8;">
	<div class="advantage index_text">
		<div class="index_title">
			<h2><p class="biaoti">P2P平台</p><p>Advantage</p></h2>
		</div>

		<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/img1.jpg" style="float:right;" width="319" height="275" />
		<div class="index_textR" style="float:left; padding-left:50px;">
			<p>1、拥有自己独立的宣传主页</p>
			<p>2、自主发布平台新闻公告、活动、发标预告</p>
			<p>3、获得平台粉丝，第一时间推送信息给用户</p>
			<p>4、免费发布自助广告</p>
			<p class="index_btn">
				<?php if(! $bid):?>
					<a href="http://www.licaipi.com/index.php?r=business/index&id=23" class="btn_login">进入双乾专区</a>
					<a href="http://www.licaipi.com/index.php?r=business/index&id=25" class="btn_login btn_regis">进入环迅专区</a>
				<?php elseif($bid == '23'):?>
					<a href="http://www.licaipi.com/index.php?r=business/index&id=23" class="btn_login">进入双乾专区</a>
				<?php elseif($bid == '25'):?>
					<a href="http://www.licaipi.com/index.php?r=business/index&id=25" class="btn_login btn_regis">进入环迅专区</a>
				<?php endif;?>
			</p>
		</div><div class="clearboth"></div>
	</div>
</div>

<!--投资人-->
<div style="background:#f4f4f4;">
	<div class="advantage index_text">
		<div class="index_title" style="padding-left:552px;">
			<h2 style="background:#f4f4f4;"><p class="biaoti">投资人</p><p>Investment & Financing</p></h2>
		</div>

		<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/img2.jpg" width="427" height="239"/>
		<div class="index_textR" style="width: 467px;">
			<p>1、关注平台，第一时间可获得自己关注的平台的</p>
			<p style="text-indent:1.6em;">活动信息、发标预告、新闻公告</p>
			<p>2、在线全面了解平台，把握投资风险</p>
			<p>3、一站式理财平台，节约时间成本</p>
			<p>4、投资理财交流，获得最新幕后消息</p>

			<!--p class="index_btn">
				<a href="<?php echo $this->createUrl('/index/reg');?>" class="btn_login btn_regis">马上注册</a>
			</p-->
		</div><div class="clearboth"></div>
	</div>
</div>
