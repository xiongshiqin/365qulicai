<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<!--<div class="block position">
			<h4>
				<i><a href="<?php echo $this->createUrl('group/hot'); ?>">小组</a>&nbsp;&gt;&nbsp;<?php echo $this->_group->name;?></i>
			</h4>
		</div>-->
	</div>

	<div class="contentR">
		<div class="sideR">
			<!--广告-->
		<!-- 	<div class="block banner">
				<a href=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/banner.png" /></a>
			</div> -->


			<!--组长-->
			<div class="block">
				<h3>组长</h3>
				<ul class="member">
					<li>
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$manage[0]->uid)); ?>"><img src="<?php echo HComm::avatar($manage[0]->uid);?>" /></a>
						<p><a href="<?php echo $this->createUrl('home/index',array('uid'=>$manage[0]->uid)); ?>"><?php echo $manage[0]->username;?></a></p>
					</li>
				</ul>
			</div>
			<!--副组长-->
			<?php if(count($manage) > 1): ?>					
				<div class="block clearboth">
					<h3>副组长</h3>
					<ul class="member">
						<?php foreach ($manage  as $key=>$value) { if($key==0) continue;?>
						<li>
							<a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
							<p><a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a></p>
						</li>
						<?php };?>
					</ul>
				</div>
			<?php endif;?>

			<!--活跃成员-->
			<div class="block clearboth">
				<h3><cite></cite>最新成员</h3>
				<?php if($member):?>  
				<ul class="member">
					<?php foreach ($member  as $key=>$value) {?>
					<li>
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
						<p><a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a></p>
					</li>
					<?php };?>
				</ul>
				<?php endif;?>
			</div>
		</div>

		<div class="mainarea">

			<!--小组内容-->
			<div class="block">
				<ul class="group">
					<li style="width:718px; _width:716px; margin-bottom:5px;">
						<?php if($this->_identidy == 9 ):?><cite><a href="<?php echo $this->createUrl('group/manage',array('gid'=>$this->_group->gid));?>">管理小组</a></cite><?php endif;?>
						<div class="groupL"><a href=""><img src="<?php echo HComm::get_group_dir($this->_group->gid); ?>" /></a></div>
						<div class="groupR">
							<h5><a href="<?php echo $this->createUrl('group/index',array('gid'=>$this->_group->gid));?>"><?php echo $this->_group->name;?></a></h5>
							<p class="grey">成员：<?php echo $this->_group->follownum;?>  话题：<?php echo $this->_group->topicnum;?></p>
						</div>
					</li>
				</ul>
				
				<div class="clearboth group_bg">
					<div class="establish">
						创建于<?php echo date("Y-m-d" , $this->_group->dateline)?> 
						<span>组长：<a target="_blank" href="<?php echo $this->createUrl('home/index',array('uid'=>$manage[0]->uid)); ?>"><?php echo $manage[0]->username;?></a></span>
					</div>
					<p><?php echo nl2br(CHtml::encode($this->_group->info))?></p>
					<p>
						<?php if ( $this->_identidy > 0 && $this->_identidy < 9 ) {
							echo '<cite class="join ok_join"><a href="'.$this->createUrl('group/unjoin',array('gid'=>$this->_group->gid)).'">取消加入</a></cite>';
						}elseif ( $this->_identidy == 0) {
							echo '你正在申请加入这个小组';
						}elseif ( $this->_identidy == -2) {
							echo '<cite class="join"><a href="'.$this->createUrl('group/join',array('gid'=>$this->_group->gid)).'">+加入</a></cite>';
						}?>
						&nbsp;
					</p>
				</div>
			</div>

			<!--小组内容
			<div class="block xiaozuC">
				<dl class="zuzhang">
					<dt>组长：</dt>	
					<dd><a href="<?php echo $this->createUrl('home/index',array('uid'=>$manage[0]->uid)); ?>"><?php echo $manage[0]->username;?></a></dd>
					<?php if(count($manage) > 1): ?>					
					<dt>副组长：</dt>	
					<dd>
						<?php unset($manage[0]); foreach ($manage  as $key=>$value) {?>
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a>
						<?php };?>
					</dd>
					<?php endif;?>
				</dl>
				<div style="clear:both;"></div>
			</div>-->
			

			<!--全部帖子-->
			<div class="block">
				<h3>
					<cite class="teizi">
						<a href="<?php echo $this->createUrl('group/add', array('gid'=>$this->_group->gid)); ?>">
							+发新贴
						</a>
					</cite>
					<i>全部帖子</i>
				</h3>
				<?php if($topic):?>  
				<ul class="gclear">
					<li class="th">
						<h4>话题</h4>
						<div class="postR post-author">作者</div>
						<div class="postR">查看</div>
						<div class="postR">回复</div>
						<div class="postR gclear_date">最后回应</div>
					</li>

					<?php foreach ($topic  as $key=>$value) {?>
					<li>
						<h4><a href="<?php echo $this->createUrl('group/view', array('id'=>$value->topicid)); ?>"><?php echo $value->title;?></a></h4>
						<div class="postR post-author"><a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a></div>
						<div class="postR"><?php echo $value->viewnum;?></div>
						<div class="postR"><span></span><?php echo $value->replynum;?></div>
						<div class="postR gclear_date"><?php echo date('m-d H:m' , $value->dateline)?></div>
					</li>
					<?php };?>
				</ul>
				<?php endif;?>
				<!--分页-->
				<div class="pages" style="clear:both;">
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