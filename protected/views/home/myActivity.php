<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<!--用户信息-->
		<?php $this->widget('HomeMenu', array(
			'_user'=> $this->_user,
			'_self'=> $this->_self,
			'selected' => 'myActivity', 
		)); ?>
			

		<div class="mainarea eight">
			<!--我点赞的活动-->
			<div class="block">
				<h3><i><?php echo (Yii::app()->user->id == $this->_user->uid) ? '我' : $this->_user->username?>点赞的活动</i></h3>
				<ul class="user_praise">
					<?php foreach($events as $v):?>
						<li>
							<p class="quote">
								<cite>
									<i><?php echo $v->event->likenum;?></i>人点赞&nbsp;&nbsp;&nbsp;
									<i><?php echo $v->event->viewnum;?></i>次浏览
								</cite>
								<a target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail' , array('eventid' => $v->eventid));?>"><?php echo $v->event->title;?></a>
								<span>(来自：<a class="pingtai" target="_blank" href="<?php echo $this->createUrl('/p2p/index', array('cpid' => $v->company->cpid));?>"><?php echo $v->company->name;?></a>)</span>
							</p>
							<p>
								<cite><?php echo date('Y-m-d H:i:s' , $v->dateline);?></cite>
								<span>获得的奖品：</span>
								<?php 
									$lottery = unserialize($v->log);
									if(is_array($lottery)){
										foreach($lottery as $award){
											echo '    ' . $award;
										}
									} else {
										echo $lottery;
									}
								?>
							</p>
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