<?php if($newses):?>
	<h3>
		<?php if($this->type == 'company'):?>
			平台新闻
		<?php else:?>
			热点新闻
		<?php endif;?>

		<?php if(isset($this->cpid)):?>
			<small><a target="_blank" href="<?php echo Yii::app()->createUrl('/p2p/newsList',array('cpid'=>$this->cpid));?>">（查看更多）</a></small>
		<?php endif;?>
	</h3>
	<ul class="msgtitlelist">
			<?php foreach($newses as $news):?>
				<li><a target="_blank" href="<?php echo Yii::app()->createUrl('/news/view',array('id'=>$news->newsid))?>"><?php echo $news->title?></a></li>
			<?php endforeach;?>
	</ul>
<?php endif;?>	