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
				'发标列表' => '' ,
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
			<div class="block activities broadcast">
				<h3><i>发标列表</i></h3>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<?php if($biaos):?>
						<?php foreach($biaos as $biao):?>
						<tr>
							<td width="40%">
								<p class="wenzi_R">
									<a target="_blank" href="<?php echo $biao->company->siteurl?>">
										<?php echo $biao->cpname?>－<?php echo $biao->title;?>
									</a>
								</p>
								<p>年化：<em><?php echo $biao->profityear;?>%</em></p>
							</td>
							<td width="20%">
								<p><?php echo $biao->money;?><small>&nbsp;元</small></p>
								<p>奖励：<em><?php echo $biao->award;?>%</em></p>
							</td>
							<td width="20%">
								<p><?php echo Yii::app()->params['Biaos']['repaymenttype'][$biao->repaymenttype];?> </p>
								<p>期限：
									<em>
										<?php if($biao->itemtype == 1):?>
											秒标
										<?php elseif($biao->itemtype == 2):?>
											<?php echo $biao->timelimit;?>天
										<?php else:?>
											<?php echo $biao->timelimit;?>个月
										<?php endif;?>
									</em>
								</p>
							</td>
							<td width="20%">
								<p><?php echo date('m-d H:i',$biao->datelinepublish);?><small>&nbsp;发出</small></p>
								<p>万元收益：<?php echo $biao->expectprofit; ?></p>
								<!-- <p class="quote"><a target="_blank" href="<?php echo $biao->company->siteurl?>">进入平台</a></p> -->
							</td>
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