	<div class="sideL" style="width:194px;">
		<div class="block users">
				
			<p><img src="<?php echo HComm::avatar($this->_user->uid, 'm'); ?>" /></p>
			<p><strong><?php echo $this->_user->username;?></strong></p>
			<!--p>财富：<?php echo $this->_user->count->gold;?><span class="grey">（贫农）</span></p!-->
			<?php if($this->_user->uid != Yii::app()->user->id):?>
				<div class="attention">
					<?php  $this->widget('Relationship' , array(
						'fuid' => $this->_user->uid,
					))?>
					<div class="relationship sixin">
						<a href="<?php echo Yii::app()->createUrl('/home/writeTalk' , array('fuid' => $this->_user->uid));?>">发私信</a>
					</div>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
			<?php if($this->_user->realstatus == 2):?>
				实名认证
			<?php endif;?>
			<ol>
				<li style="border-left:0;">
					<a href="">
						<p><em><?php echo $this->_user->count->gold;?></em></p>
						<p>金币</p>
					</a>
				</li>
				<li>
					<a href="">
						<p><em><?php echo $this->_user->count->credit;?></em></p>
						<p>积分</p>
					</a>
				</li>
				<li>
					<a href="">
						<p><em><?php echo HComm::creditLevel($this->_user->uid)?></em></p>
						<p>等级</p>
					</a>
				</li>
			</ol>
			<div class="clearboth"></div>
		</div>

		<!--左导航-->
		<div class="block">
			<ul class="leftsidebar">
				<li<?php echo $this->selectedArr['index'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/index', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->p2pnum;?>个</cite>
						关注的平台
					</a>
				</li>
				<li<?php echo $this->selectedArr['myActivity'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/myActivity', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->eventlikenum;?>个</cite>
						点赞的活动
					</a>
				</li>
				<li<?php echo $this->selectedArr['myReward'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/myReward', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->awardnum;?>个</cite>
						获得的奖励
					</a>
				</li>
				<li<?php echo $this->selectedArr['myPosts'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/myPosts', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->postnum;?>个</cite>
						发的帖子
					</a>
				</li>
				<li<?php echo $this->selectedArr['follownum'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/follows', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->follownum;?>个</cite>
						关注
					</a>
				</li>
				<li<?php echo $this->selectedArr['following'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/followers', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->following;?>个</cite>
						粉丝
					</a>
				</li>
				<?php if ($this->_self):?>
				<li <?php echo $this->selectedArr['inviteFriends'];?>>
					<a href="<?php echo Yii::app()->createUrl('/home/inviteFriends', array('uid'=>$this->_user->uid))?>">
						<cite><?php echo $this->_user->count->invite;?>个</cite>
						邀请好友
					</a>
				</li>
				<!-- <li<?php echo $this->selectedArr['myProfile'];?>><?php echo CHtml::link('个人资料', array('/home/myProfile', 'uid'=>$this->_user->uid));?></li> -->
				<?php endif;?>
			</ul>	
			<div class="clearboth"></div>
		</div>		
	</div>	