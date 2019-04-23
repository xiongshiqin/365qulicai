<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">
			<!--创建小组-->
			<div class="block">
				<p class="btn1"  style="margin-top:27px;"><a href="<?php echo $this->createUrl('/News/newsAdd');?>">我要投稿</a></p>

			</div>

			<!--广告-->
			<div class="block">
			<!--	<a href=""><img src="/images/ad1.jpg" /></a>  -->
			</div>
		</div>

		<div class="mainarea">
			<!--平台列表-->
			<div class="block">
				<div class="tab">
					<ul class="tab_menu">
						<?php foreach(Yii::app()->params['News']['category'][2] as $k=>$v):?>
							<li class="<?php echo ($type == $k)? 'selected_li' : '';?>"><a href="<?php echo $this->createUrl('/news/newsList' , array('type'=>$v))?>"><?=$v?></a></li>
						<?php endforeach;?>
						<li class="<?php echo ($type == 'all')? 'selected_li' : '';?>"><a href="<?php echo $this->createUrl('/news/newsList' , array('type'=>'all'))?>">p2p平台</a></li>
						<li class="<?php echo ($type == 'my')? 'selected_li' : '';?>"><a href="<?php echo $this->createUrl('/news/newsList',array('type'=>'my'))?>">我的</a></li>
					</ul>
					<div class="tab_content clearboth">
						<div class="test selected_div">
							<ul class="industry_news">
								<?php if($news):?>
									<?php foreach($news as $v):?>
										<li>
											<?php if($v->pic):?>
												<div class="industry_newsL">
													<a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$v->newsid));?>"/><img src="<?=$v->pic?>"/></a>
												</div>
											<?php endif;?>
											<div class="industry_newsR" style="<?php if(!$v->pic) echo 'width:700px;margin-left:10px';?>";>
												<h5><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$v->newsid));?>"><?=$v->title?></a></h5>
												<p><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$v->newsid));?>"><?=$v->summary;?></a><a target="_blank" class="with_blue" href="<?php echo $this->createUrl('/news/view' , array('id'=>$v->newsid));?>">[详细]</p>
												<div class="author">
													<a href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid));?>"><?=$v->username?></a>
													<em><?php echo date('m-d H:m' , $v->dateline);?></em>
												</div>
											</div>
										</li>	
									<?php endforeach;?>
								<?php endif;?>	
							</ul>
							<div class="clearboth"></div>
						</div>
						<!--分页-->
						<div class="pages" style="clear:both;">
							<?php   
								$_pager = Yii::app()->params->pager;
								$_pager['pages'] = $pages;
								$this->widget('CLinkPager', $_pager);
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
