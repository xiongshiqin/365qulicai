<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position no_bg">
			<h4>
				<i><a href="">汉荣鼎盛</a>&nbsp;&gt;&nbsp;视频列表</i>
			</h4>
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--最新新闻-->
			<div class="block block1">
				<?php $this->widget('LastestNews',array('cpid'=>$cpid))?>
			</div>

		</div>

		<div class="mainarea">
			<!--企业视频-->
			<div class="block">
				<h3><i>企业视频</i></h3>
				<ul class="video">
					<?php if($videos):?>
						<?php foreach($videos as $v):?>
						<li><embed id="movie_player" allowfullscreen="true" width="330" height="240" type="application/x-shockwave-flash" src="<?php echo $v->url;?>" quality="high">
							<p><a href=""><?php echo $v->title;?></a></p>
						</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
				<!--分页-->
				<div class="pages clearboth">
					<?php   
						$_pager = Yii::app()->params->pager;
						$_pager['pages'] = $pages;
						$this->widget('CLinkPager', $_pager);
					?>
				</div>
				<!--分页End-->
			</div>

		</div>
	</div>
</div>
