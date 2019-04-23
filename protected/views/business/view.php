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
				'第三方支付'=>$this->createUrl('/business/list'),
				$business->shortname => $this->createUrl('/business/index',array('id'=>$business->bid)),
				'新闻列表' => $this->createUrl('/business/news',array('id'=>$business->bid)),
				),
		)); ?><!-- breadcrumbs -->
		</div>
	</div>

	<div class="contentR">
		<div class="sideR">
			<!--第三方支付-->
			<div class="block block1 third_payment">
				<h3>第三方支付</h3>
				<dl>
					<dt>名称：</dt>
					<dd class="quote"><a href=""><?php echo $business->shortname;?></a></dd>
					<dt>网址：</dt>
					<dd><a href="<?php echo $business->business_info->siteurl?>"><?php echo $business->business_info->siteurl?></a></dd>
					<dt>电话：</dt>
					<dd><?php echo $business->business_info->telephone;?></dd>
				</dl>
			</div>


			<!--最新新闻-->
			<div class="block block1">
				<h3><cite><a href="">更多&gt;&gt;</a></cite>最新新闻</h3>
				<ul class="msgtitlelist">
					<?php if($lastestNews):?>
						<?php foreach($lastestNews as $v):?>
							<li><a href="<?php echo $this->createUrl('/business/view',array('id'=>$v->id));?>"><?php echo $v->title?></a></li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
			</div>

			<!--关注有惊喜-->
			<div class="block block1 third_weixing">
				<h3>关注有惊喜</h3>
				<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/third_weixing.png" /></p>
				<p>订阅号<em>qianbaomima</em></p>
			</div>
		</div>

		<div class="mainarea">
			<!--小组内容-->
			<div class="block newsbulletin">
				<h1><?php echo $news->title;?></h1>
				<div class="newsline grey">
					<?php echo $news->viewnum?>浏览&nbsp;｜&nbsp;<?php echo date('Y-m-d',$news->dateline);?>
				</div>
				<p><?php echo $news->content;?></p>
			</div>

		</div>
	</div>
</div>