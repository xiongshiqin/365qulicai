<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position no_bg">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'第三方支付'=>$this->createUrl('/business/list'),
				$business->shortname => $this->createUrl('/business/index',array('id'=>$business->bid)),
				'新闻列表' => '',
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
					<dd class="quote"><a href="<?php echo $this->createUrl('/business/index',array('id'=>$business->bid));?>"><?php echo $business->shortname?></a></dd>
					<dt>网址：</dt>
					<dd><a href="<?php echo $business->business_info->siteurl;?>"><?php echo $business->business_info->siteurl;?></a></dd>
					<dt>电话：</dt>
					<dd><?php echo $business->business_info->telephone;?></dd>
				</dl>
			</div>

			<!--关注有惊喜-->
			<div class="block block1 third_weixing">
				<h3>关注有惊喜</h3>
				<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/third_weixing.png" /></p>
				<p>订阅号<em>qianbaomima</em></p>
			</div>
		</div>

		<div class="mainarea">
			<!--新闻公告-->
			<div class="block activities">
				<h3><i>平台活动</i></h3>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th width="72%" style="padding-left:15px;">标题</th>
						<th width="15%">浏览</th>
						<th width="13%">时间</th>
					</tr>
					<?php if($news):?>
						<?php foreach($news as $v):?>
						<tr>
							<td class="wenzi_R"><a href="<?php echo $this->createUrl('/business/view',array('id'=>$v->id));?>"><?php echo $v->title;?></a></td>
							<td><?php echo $v->viewnum?></td>
							<td class="grey"><?php echo date('Y-m-d',$v->dateline);?></td>
						</tr>
						<?php endforeach;?>
					<?php endif;?>
					
				</table>
				<!--分页-->
				<div class="pages clearboth">
					<?php   
						$_pager = Yii::app()->params->pager;
						$_pager['pages'] = $pages;
						$this->widget('CLinkPager', $_pager);
					?>
				</div>
				<!--分页End-->
			</div>
		</div>
	</div>
</div>