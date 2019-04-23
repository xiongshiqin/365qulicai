<div class="sideL">
	<!--用户信息-->
	<div class="block users">
		<p>beyond_dream</p>
		<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/touxiang1.png" /></p>
		<p>财富：2340<span class="grey">（贫农）</span></p>

		<ol>
			<li style="border-left:0;">
				<p><a href=""><em>78</em></a></p>
				<p>平台</p>
			</li>
			<li>
				<p><a href=""><em>6</em></a></p>
				<p>活动</p>
			</li>
			<li>
				<p><a href=""><em>78</em></a></p>
				<p>奖励</p>
			</li>
		</ol>
		<div class="clearboth"></div>
	</div>

	<!--左导航-->
	<div class="block">
		<ul class="leftsidebar">
			<li class="selected"><a href="<?php echo $this->createUrl('/home/index'); ?>">我关注的平台</a></li>
			<li><a href="<?php echo $this->createUrl('/home/myActivity'); ?>">我点赞的活动</a></li>
			<li><a href="<?php echo $this->createUrl('/home/myReward'); ?>">我的奖励</a></li>
			<li><a href="<?php echo $this->createUrl('/home/myPosts'); ?>">我的帖子</a></li>
			<li><a href="<?php echo $this->createUrl('/home/inviteFriends'); ?>">邀请好友</a></li>
			<li><a href="">个人资料</a></li>
		</ul>
		<div class="clearboth"></div>
	</div>
			
</div>