<?php if($newses):?>
	<h3>
		<?php if($this->type == 'company'):?>
			平台新闻
		<?php else:?>
			热点新闻
		<?php endif;?>
	</h3>
	<ul class="industry_news">
		<?php foreach($newses as $news):?>
			<li class="index_news news_left">
				<div class="industry_newsL">
					<a target="_blank" href="<?php echo Yii::app()->createUrl('/news/view',array('id'=>$news->newsid))?>"/><img style="width:120px; height:78px;" src="<?=$news->pic?>" /></a>
				</div>
				<div class="industry_newsR">
					<h5><a target="_blank" href="<?php echo Yii::app()->createUrl('/news/view',array('id'=>$news->newsid))?>"><?=$news->title?></a></h5>
					<p><?php echo date('Y-m-d' , $news->dateline)?></p>
				</div>
			</li>
		<?php endforeach;?>
	</ul><div class="clearboth"></div>
<?php endif;?>	
