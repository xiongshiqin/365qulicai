
<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
<!-- 		<div class="block position no_bg">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'第三方支付'=>$this->createUrl('/business/list'),
				),
			)); ?>
		</div> -->

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--第三方支付-->
			<div class="block ptwoplicai">
				<dl>
					<dt><a href="javascript:void(0)"><img src="<?php echo Yii::app()->request->baseUrl.$business->business_info->logo; ?>" /></a></dt>
					<?php if($business->business_service->uid == Yii::app()->user->id):?>
						<dd><span class="grey">管理员：</span><?php echo $business->business_service->username?></dd>
						<dd class="third_logo"><a href="<?php echo $this->createUrl('p/business/index', array('id'=>(int)Yii::app()->request->getParam('id')));?>">>进入管理</a></dd>
					<?php endif;?>
				</dl>
			</div>

			<!--业务资询-->
			<div class="block">
				<h3>业务资询<small><a style="color:#1c7abe" href="<?php echo $this->createUrl('/business/join',array('bid'=>$business->bid))?>">+申请加入</a></small></h3>
				<ul class="group">
					<?php if($members):?>
						<?php foreach($members as $v):?>
						<li>
							<div class="groupL"><a href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid));?>"><img src="<?php echo HComm::avatar($v->uid);?>" /></a></div>
							<div class="groupR">
								<h5><a href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid));?>"><?=$v->realname?></a></h5>
								<p class="grey"><small>手机：<?=$v->mobile?></small></p>
							</div>
						</li>
						<?php endforeach;?>
					<?php endif;?>
					
				</ul>
				<div class="clearboth"></div>
			</div>

			<!--相关新闻-->
			<?php if($news):?>
				<div class="block block1">
					<h3>相关新闻<!-- <small><a href="">（查看更多）</a></small> --></h3> 
					<ul class="msgtitlelist">
						<?php foreach($news as $v):?>
							<li><a target="_blank" href="<?php echo $this->createUrl('/business/view',array('id'=>$v->id));?>"><?=$v->title?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
			<?php endif;?>
		</div>
		<div class="mainarea">
			<!--双乾支付-->
			<div class="block newsbulletin" style="padding-top:0;">
				<h4><?php echo $business->shortname?>专区</h4>
				<p><?php echo $business->business_info->info?></p>
			</div>
			<!--第三方支付列表-->
			<div class="block">
				<h3><i>使用<?=$business->shortname?>的平台示例</i></h3>
				<ol class=" platform_logo">
					<?php foreach($companies as $v):?>
						<!-- <li><a target="_blank" href="<?php echo $this->createUrl('/p2p/index',array('cpid'=>$v->cpid))?>"><?php echo $v->name?></a></li> -->
						<li><a target="_blank" href="<?=$v->siteurl?>"><img src="<?php echo HComm::get_com_dir($v->cpid);?>" /></a></li>
					<?php endforeach;?>
					<?php if($business->bid == '23'):?>
						<li><a><img src="html/images/logo/logo1.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo2.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo3.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo4.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo5.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo6.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo7.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo8.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo9.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo10.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo11.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo12.jpg" /></a></li>
					<?php elseif($business->bid == '25'):?>
						<li><a><img src="html/images/logo/logo13.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo14.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo15.jpg" /></a></li>
						<li><a><img src="html/images/logo/logo16.jpg" /></a></li>
					<?php endif;?>
				</ol><div class="clearboth"></div>

				<div class="enter">
					<?php if($business->bid == '23'):?><!--双钱 -->
						<a href="http://www.licaipi.com/index.php?r=/index/reg&auth=6364eWV3dXl1YW4tV1BRVFpW">+立即入驻理财派，创建自己平台专属的宣传主页</a>
					<?php elseif($business->bid == '25'):?><!--环迅支付-->
						<a href="http://www.licaipi.com/index.php?r=/index/reg&auth=6ea9eWV3dXl1YW4tUUFNQU5T">+立即入驻理财派，创建自己平台专属的宣传主页</a>
					<?php endif;?>
				</div>

			</div>

			<!--己入驻的平台-->
			<div class="block" style="display:none;">
				<h3><i>己入驻的平台</i></h3>
				<ol class="third_list">
					<li><a href="">中大财富</a></li>
					<li><a href="">钱掌柜</a></li>
					<li><a href="">诚壹贷</a></li>
					<li><a href="">鑫天下财富</a></li>
					<li><a href="">壹宝贷</a></li>
				</ol>
				<div class="clearboth"></div>
			</div>

		</div>
	</div>
</div>
