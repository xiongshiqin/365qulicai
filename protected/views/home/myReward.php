<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<!--用户信息-->
		<?php $this->widget('HomeMenu', array(
			'_user'=> $this->_user,
			'_self'=> $this->_self,
			'selected' => 'myReward', 
		)); ?>
			
		<div class="mainarea eight">
			<!--我的奖励-->
			<div class="block">
				<h3><i><?php echo (Yii::app()->user->id == $this->_user->uid) ? '我' : $this->_user->username?>的奖励</i></h3>
				<ul class="user_praise">
					<?php foreach($awards as $v):?>
					<li>
						<p class="quote">
							<cite><?php echo date('Y-m-d H:i:s' , $v->dateline);?></cite>
							<span>获得的奖品：</span>
							<em>
								<?php echo $v->awardname;?>
							</em>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<span>来自：<a class="pingtai" href=""><?php echo $v->company->name;?></a></span>
						</p>
						<p><span>活动：</span><?php echo $v->event->title;?></p>
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