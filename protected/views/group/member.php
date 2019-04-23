<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position">
			<h4>
				<i><a href="<?php echo $this->createUrl('group/hot'); ?>">小组</a>&nbsp;&gt;&nbsp;
					<a href="<?php echo $this->createUrl('group/index',array('gid'=>$this->_group->gid)); ?>"><?php echo $this->_group->name;?></a>&nbsp;&gt;&nbsp;
					所有成员
				</i>
			</h4>
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--本贴来自小组-->
			<div class="block block1">
				<h3>本贴来自小组</h3>
				<ul class="group">
					<li style="width:auto; margin:5px;">
						<div class="groupL"><a href=""><img src="<?php echo HComm::avatar($this->_group->gid); ?>" /></a></div>
						<div class="groupR">
							<h5><a href="">21天变财女</a></h5>
							<p class="grey">成员：5821  话题：6607</p>
						</div>
						<p class="grey" style="clear:both;">坚持读一本好书，坚持锻炼，，这里见证你每份坚持和成长</p>
					</li>
				</ul>
				<div class="join"><cite><a href="<?php echo $this->createUrl('group/loin'); ?>">+加入</a></cite>&nbsp;</div>
			</div>

			<!--最热话题-->
			<div class="block block1">
				<?php $this->widget('HottestTopics' , array(
					'gid' => $this->_group->gid,
				)); ?>
			</div>
		</div>

		<div class="mainarea">
			<!--组长-->
			<div class="block huiyuan">
				<h3><i>组长</i></h3>
				<ul class="member">
					<?php  if($manage && $teammate = array_shift($manage)): ?>
					<li style="margin-left:12px;">
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$teammate->uid)); ?>"><img src="<?php echo HComm::avatar($teammate->uid);?>" /></a>
						<p class="quote"><a href="<?php echo $this->createUrl('home/index',array('uid'=>$teammate->uid)); ?>"><?php echo $teammate->username; ?></a></p>
					</li>
					<?php endif; ?>
				</ul>
			</div>

			<!--副组长-->
			<?php if($manage): ?>
			<div class="block huiyuan">
				<h3><i>副组长</i></h3>
				<ul class="member">
					<?php foreach ($manage  as $key=>$value) {?>
					<li class="selected" style="margin-left:12px;">
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
						<p class="quote"><a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username; ?></a></p>
						<?php if($this->_identidy >= 8):?>
							<p><a href="<?php echo $this->createUrl('/group/remMember' , array('muid'=>$value->uid , 'gid' => $this->_group->gid));?>">踢出小组</a></p>
						<?php endif;?>
					</li>
					<?php } ?>
				</ul>
			</div>
			<?php endif; ?>
			
			<!--小组成员-->
			<?php if($member):?> 
			<div class="block huiyuan">
				<h3><i>小组成员</i></h3>
				<ul class="member">
					<?php foreach ($member  as $key=>$value) {?>
					<li class="selected" style="margin-left:12px;">
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
						<p class="quote"><a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a></p>
						<?php if($this->_identidy >=9 && $value->identidy <8):?>
							<p><a href="<?php echo $this->createUrl('/group/setDeputyLeader' , array('muid'=>$value->uid , 'gid' => $this->_group->gid))?>">设为副组长</a></p>
						<?php endif;?>
						<?php if($this->_identidy >= 8):?>
							<p><a href="<?php echo $this->createUrl('/group/remMember' , array('muid'=>$value->uid , 'gid' => $this->_group->gid));?>">踢出小组</a></p>
						<?php endif;?>
					</li>
					<?php } ?>
				</ul>
				<div style="clear:both;"></div>
			</div>
			<?php endif;?>

		</div>
		
	</div>
</div>

