<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">
			<div class="block">
				<img src="/images/ad1.jpg" />
			</div>
		</div>

		<div class="mainarea">
			<!--平台列表-->
			<div class="block">
				<div class="tab">
					<ul class="tab_menu">
						<?php foreach(Yii::app()->params['News']['category'][2] as $k=>$v):?>
							<li><a href="<?php echo $this->createUrl('/news/newsList' , array('type'=>$k))?>"><?=$v?></a></li>
						<?php endforeach;?>
						<li class="<?php echo $tab == 'all' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/newsNotice')?>">p2p平台</a></li>
						<li class="<?php echo $tab == 'my' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/newsNotice',array('tab'=>'my'))?>">我的</a></li>
					</ul>
					<div class="tab_content clearboth">
						<div class="test selected_div">
							<!--列表-->
							<table class="activities pingtai" width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th width="84%" class="wenzi_R" style="padding-left:15px;">标题</th>
									<!--th width="13%">分类</th-->
									<th width="16%">时间</th>
								</tr>
								<?php if($news):?>
									<?php foreach($news as $v):?>
										<tr>
											<td class="wenzi_R" style="color:#949494;">【<a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $v->cpid));?>"><?php echo $v->company->name;?></a>】<a style="color:#393939;" target="_blank" href="<?php echo $this->createUrl('/p2p/newsDetail' , array('id'=>$v->id));?>"><?=$v->title?></a></td>
											<!--td><?php echo Yii::app()->params['Company']['newsClass'][$v->class]?></td-->
											<!--td><?=$v->viewnum?><small>次</small></td-->
											<td class="grey"><?php echo date('y-m-d H:i',$v->dateline);?></td>
										</tr>
									<?php endforeach;?>
								<?php endif;?>			
							</table>

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
</div>
