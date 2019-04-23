
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<!--用户信息-->
		<?php $this->widget('HomeMenu', array(
			'_user'=> $this->_user,
			'_self'=> $this->_self,
			'selected' => 'follownum'
		)); ?>

		<div class="mainarea eight">
			<!--我的平台-->
			<div class="block">
				<h3><i><?php echo (Yii::app()->user->id == $this->_user->uid) ? '我' : $this->_user->username?>的关注<small class="grey">&nbsp;(共<?php echo MemberCount::model()->findByPk($this->_uid)->follownum;?>个)</small></i></h3>
				<ul class="group">
					<?php foreach($follows as $v):?>
						<li class="review my_attention">
							<div class="groupL">
								<a href=""><img src="<?php echo HComm::avatar($v->fuid, 'm'); ?>" /></a>
							</div>
							<div class="groupR postC">
								<h5><a href="<?php echo $this->createUrl('/home/index' , array('uid' => $v->fuid));?>"><?php echo $v->fusername?></a>&nbsp;&nbsp;<i class="grey">@<?php echo $v->fmember_info->resideprovince . '  ' . $v->fmember_info->residecity?></i></h5>
								<div style="line-height:30px;">	
									<cite class="attention" style="margin:0; ">
										<?php if(Yii::app()->user->id != $v->fuid):?>
											<div class="relationship sixin" style="background:none; margin-left:0;">
												<a href="<?php echo Yii::app()->createUrl('/home/writeTalk' , array('fuid' => $v->uid));?>">发私信</a>
											</div>
										<?php endif;?>
										<div class="clearboth"></div>
									</cite>
									<span>关注平台：<?php echo $v->fmember_count->p2pnum?></span>
									<span>活动点赞：<?php echo $v->fmember_count->eventlikenum?></span>
									<span>获得奖励：<?php echo $v->fmember_count->awardnum?></span>
									<span>帖子：<?php echo $v->fmember_count->postnum?></span>
								</div>
							</div>
						</li>
					<?php endforeach;?>
				</ul>

				<!--分页-->
				<div class="pages clearboth">
					<ul class="pagelist">
						<?php   
							$_pager = Yii::app()->params->pager;
							$_pager['pages'] = $pages;
							$this->widget('CLinkPager', $_pager);
						?>
					</ul>
				</div>
				<!--分页End-->

			</div>
		</div>
	</div>
</div>

