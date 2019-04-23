<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position no_bg">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'第三方支付'=>$this->createUrl('/business/list'),
				),
			)); ?><!-- breadcrumbs -->
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--申请入驻-->
			<div class="block">
				<p class="btn1"  style="margin-top:27px;"><a href="<?php echo $this->createUrl('/business/apply'); ?>">+第三方支付免费申请入驻</a></p>
			</div>
		</div>

		<div class="mainarea">
			<!--第三方支付列表-->
			<div class="block">
				<h3><i>第三方支付列表</i></h3>
				<?php if ($list):?>
				<ol class="third_list">
					<?php foreach ($list as $value) { ?>
					<li><a href="<?php echo $value->getUrl();?>"><?php echo $value->shortname;?></a></li>
					<?php } ?>
				</ol>
				<?php endif;?>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
