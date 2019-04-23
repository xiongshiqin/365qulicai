<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">

			<!--广告-->
			<div class="block banner">
				<img src="/images/ad1.jpg" />
			</div>
		</div>

		<div class="mainarea">
			<!--推荐小组-->
			<div class="block">
				<h3><i>我管理的小组</i></h3>
				<?php if($manageGroup):?>  
				<ul class="group">
					<?php foreach ($manageGroup  as $key=>$value) {?>
					<li>
						<div class="groupL"><a href="<?php echo $this->createUrl('group/index',array('gid'=>$value->gid));?>"><img src="<?php echo HComm::get_group_dir($value->gid)?>" /></a></div>
						<div class="groupR">
							<h5><a href="<?php echo $this->createUrl('group/index',array('gid'=>$value->gid));?>"><?php echo $value->group->name;?></a></h5>
							<p class="grey">成员：<?php echo $value->group->follownum;?>  话题：<?php echo $value->group->topicnum;?></p>
						</div>
						<p class="grey" style="clear:both;"><?php echo CHtml::encode($value->group->info);?></p>
					</li>
					<?php };?>	
				</ul>		
				<?php endif;?>
				<div style="clear:both;"></div>
			</div>
			
			<div class="block">
				<h3><i>我加入的小组</i></h3>
				<ul class="group">
					<?php foreach ($list  as $key=>$value) {?>
					<li>
						<div class="groupL"><a href="<?php echo $this->createUrl('group/index',array('gid'=>$value->gid));?>"><img src="<?php echo HComm::get_group_dir($value->gid)?>" /></a></div>
						<div class="groupR">
							<h5><a href="<?php echo $this->createUrl('group/index',array('gid'=>$value->gid));?>"><?php echo $value->group->name;?></a></h5>
							<p class="grey">成员：<?php echo $value->group->follownum;?>  话题：<?php echo $value->group->topicnum;?></p>
						</div>
						<p class="grey" style="clear:both;"><?php echo CHtml::encode($value->group->info);?></p>
					</li>
					<?php };?>	
				</ul>				
			</div>
		</div>
		
	</div>
</div>