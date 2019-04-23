<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<!-- <div class="block position no_bg">
			<h4>
				<i><a href="">汉荣鼎盛</a>&nbsp;&gt;&nbsp;第三方支付</i>
			</h4>
		</div> -->
		<div class="block position no_bg">
			<!--主导航-->
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'P2P理财'=>$this->createUrl('/p2p/list'),
				$company->name => $this->createUrl('/p2p/index',array('cpid'=>$company->cpid)),
				'新闻列表' => $this->createUrl('/p2p/newsList',array('cpid'=>$company->cpid)),
				),
		)); ?><!-- breadcrumbs -->
		</div>
	</div>

	<div class="contentR">
		<div class="sideR">

			<!--最新新闻-->
			<div class="block block1">
				<?php $this->widget('LastestNews',array('cpid'=>$company->cpid));?>
			</div>

			<!--关注有惊喜-->
			<?php if($company->weixin):?>
				<div class="block block1 third_weixing">
					<h3>关注有惊喜</h3>
					<p><img src="<?php echo Yii::app()->request->baseUrl . $company->weixin; ?>" /></p>
					<p>关注<em><?=$company->name?></em>订阅号</p>
				</div>
			<?php endif;?>
		</div>

		<div class="mainarea">
			<!--小组内容-->
			<div class="block newsbulletin">
				<h1><?php echo $news->title;?>11</h1>
				<div class="newsline grey">
					<a href="">网谈</a>
					<?php echo $news->viewnum?>浏览&nbsp;｜鼎盛财富&nbsp;<?php echo date('Y-m-d H:i',$news->dateline);?>
				</div>
				<blockquote>
					<span style="color:#999;">摘要 : </span>
					在智能机发展至成熟的规则体系下，如果依然没有走出低价、性价比，饥饿营销，软硬结合的小米模式，那么谈成功就很渺茫。360如今携手酷派重操手机旧业还有胜算吗？
				</blockquote>
				<p><?php echo $news->content;?></p>
			</div>

		</div>
	</div>
</div>