<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">
			<!--创建小组-->
			<div class="block">
				<p class="btn1"  style="margin-top:27px;"><a target="_blank" href="<?php echo $this->createUrl('/News/newsAdd');?>">我要投稿</a></p>
			</div>

			<!--广告-->
			<div class="block banner">
				<a href=""><img src="/images/ad1.jpg" /></a>
			</div>
		</div>

		<div class="mainarea">
			<!--平台列表-->
			<div class="block activities">
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
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th width="80%" style="padding-left:15px;">标题</th>
									<th width="20%">时间</th>
								</tr>
								<?php if($news):?>
									<?php foreach($news as $v):?>
									<tr>
										<td class="wenzi_R"><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$v->newsid));?>">【<?php echo $v->pname?>】<?php echo $v->title;?></a></td>
										<td class="grey"><?php echo date('Y-m-d',$v->dateline);?></td>
									</tr>
									<?php endforeach;?>
								<?php endif;?>
							</table>
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