<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position no_bg">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'P2P理财'=>$this->createUrl('/p2p/list'),
				$company->name => $this->createUrl('/p2p/list',array('cpid'=>$cpid)),
				),
			)); ?><!-- breadcrumbs -->
		</div>

	</div>

	<div class="contentR">
	<!-- 	<div class="sideR">
			<div class="block block1 third_weixing">
				<h3>关注有惊喜</h3>
				<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/third_weixing.png" /></p>
				<p>订阅号<em>qianbaomima</em></p>
			</div>
		</div> -->

		<div class="mainarea">
			<!--新闻公告-->
			<div class="block activities">
				<h3><i>新闻列表</i></h3>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th width="72%" style="padding-left:15px;">标题</th>
						<th width="15%">浏览</th>
						<th width="13%">时间</th>
					</tr>
					<?php if($news):?>
						<?php foreach($news as $v):?>
						<tr>
							<td class="wenzi_R"><a href="<?php echo $this->createUrl('/news/view',array('id'=>$v->newsid));?>"><?php echo $v->title;?></a></td>
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