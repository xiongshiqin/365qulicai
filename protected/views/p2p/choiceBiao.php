<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--平台列表-->
		<div class="block">
			<div class="tab">
				<ul class="tab_menu">
					<li class="<?php echo $tab == 'all' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/choiceBiao');?>">全部新标</a></li>
					<li class="<?php echo $tab == 'my' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/choiceBiao' , array('tab'=>'my'))?>">我关注平台的标</a></li>
					<li class="<?php echo $tab == 'like' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/choiceBiao' , array('tab'=>'like'))?>">我感兴趣的标</a></li>
				</ul>

				<div class="tab_content clearboth">
					<div class="test selected_div">
						<!--列表-->
						<table class="activities pingtai" width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<th width="12%" class="wenzi_R" style="padding-left:15px;">平台名称</th>
								<th width="12%">标金额</th>
								<th width="10%">周期</th>
								<th width="9%">类型</th>
								<th width="10%">年化率</th>
								<th width="9%">奖励</th>
								<th width="9%">万元收益</th>
								<th width="11%">发出时间</th>
								<th width="9%">去看看</th>
								<th width="9%">操作</th>
							</tr>
							<?php if($biaos):?>
								<?php foreach($biaos as $v):?>
									<tr>
										<td class="wenzi_R"><a target="_blank" href="<?php echo $this->createUrl('/p2p/index'  , array('cpid'=>$v->cpid))?>"><?=$v->cpname;?></a></td>
										<td><?=$v->money?><small>元</small></td>
										<td>
											<?php if($v->itemtype == 1):?>
												秒标
											<?php elseif($v->itemtype == 2):?>
												<?php echo $v->timelimit;?>天
											<?php else:?>
												<?php echo $v->timelimit;?>个月
											<?php endif;?>
										</td>
										<td><?php echo Yii::app()->params['Biaos']['itemtype'][$v->itemtype]?></td>
										<td><?php echo $v->interestrate*12?>%</td>
										<td><?=$v->award?>%</td>
										<!--td><?php echo Yii::app()->params['Biaos']['repaymenttype'][$v->repaymenttype]?></td-->
										<td style="color:#FF7A25;"><?=$v->expectprofit?><small>元</small></td>
										<td class="grey"><?php echo date('m-d H:i' , $v->datelinepublish);?></td>
										<td><a target="_blank" style="text-decoration:underline;" href="<?=$v->company->siteurl?>">去平台看看</a></td>
										<td class="biaolike_<?=$v->id?>">
											<?php if($tab == 'like'):?>
												<a href="javascript:void(0)" data-action="remBiaoLike" data-params="<?php echo $v->id . ',' . $v->cpid?>">取消</a>
											<?php else:?>
												<a class="interest" href="javascript:void(0)" data-action="addBiaoLike" data-params="<?php echo $v->id . ',' . $v->cpid?>">感兴趣</a>
											<?php endif;?>
										</td>
									</tr>
								<?php endforeach;?>
							<?php endif;?>			
						</table>

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
	</div>
</div>
