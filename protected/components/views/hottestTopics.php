<h3>最热话题<small><a target="_blank" href="<?php echo Yii::app()->createUrl('/group/index',array('gid'=>$this->gid));?>">（查看更多）</a></small></h3>
<ul class="msgtitlelist">
	<?php if($topics):?>
		<?php foreach($topics as $t):?>
			<li><a target="_blank" href="<?php echo Yii::app()->createUrl('/group/view',array('id'=>$t->topicid))?>"><?php echo $t->title?></a></li>
		<?php endforeach;?>
	<?php endif;?>	
</ul>
