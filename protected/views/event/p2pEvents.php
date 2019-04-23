<!--内容区-->
<div id="wrap">
	<div class="contentR">
	<div class="sideR">
			<!--div class="block">
				<p class="btn1"  style="margin-top:27px;"><a href="<?php echo $this->createUrl('/p2p/apply');?>">+免费申请入驻平台</a></p>
			</div-->

			<div class="block">
			<!--	<img height="230px" src="/images/ad1.jpg"/>-->
			</div>
		</div>

		<div class="mainarea">
			<!--平台列表-->
			<div class="block">
				<div class="tab">
					<div class="search">
						<form id="form1" name="form1" method="post" action="" >
							<input type="text" placeholder="输入平台名称" name="cpname" value="<?php echo $cpname?>" />
							<input class="search_btn" type="submit" name="button" id="button" value="确&nbsp;定" />
						</form>
					</div>
					<ul class="tab_menu">
						<li class="<?php echo $tab == 'all' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/event/p2pEvents')?>">全部</a></li>
						<li class="<?php echo $tab == 'mine' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/event/p2pEvents',array('tab'=>'mine'))?>">我关注平台的活动</a></li>
						<?php if(isset($company->cpid)):?>
							<li class="selected_li"><a href="<?php echo $this->createUrl('/event/p2pEvents',array('tab'=>'one' , 'cpid'=>$company->cpid))?>"><?php echo $company->name?></a></li>
						<?php endif;?>
					</ul>
					<div class="tab_content clearboth">
						<div class="test selected_div">
							<!--类型-->
							<!--暂时去掉活动类型
							<dl class="activity_type">
								 <dt>活动类型：</dt>
								<dd>
									<a class="type_0" href="<?php echo $this->createUrl('/event/p2pEvents' , array('tab'=> $tab))?>">全部</a>
									<?php foreach(Yii::app()->params['Event']['type'] as $k=>$v):?>
										<a class="type_<?=$k?>" href="<?php echo $this->createUrl('/event/p2pEvents' , array('type'=>$k , 'tab' => $tab));?>"><?=$v?></a>
									<?php endforeach;?>
								</dd>
								<script>
									$(document).ready(function(){
										$('.type_' + <?=$type?>).addClass('selected');
									});
								</script>
							</dl> -->

							<!--列表-->
							<table class="activities pingtai" width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<th width="74%" class="wenzi_R" style="padding-left:15px;">标题</th>
									<!--th width="14%">平台</th-->
									<!--th width="11%">抽奖类型</th-->
									<th width="8%">人气</th>
									<!--th width="8%">关注</th-->
									<th width="18%">截止时间</th>
								</tr>
								<?php if($events):?>
									<?php foreach($events as $v):?>
										<tr>
											<td class="wenzi_R" style="color:#949494;">【<a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $v->p2pid))?>"><?php echo $v->company->name?></a>】<a style="color:#393939;" target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail',array('eventid'=>$v->eventid));?>"><?php echo $v->title;?></a></td>
											<!--td><?php echo Yii::app()->params['Event']['lotterytype'][$v->lotterytype]?></td-->
											<td><?php echo $v->viewnum;?></td>
											<!--td><?php echo $v->likenum;?></td-->
											<td class="grey"><?php echo date('Y-m-d H:i',$v->endtime);?></td>
										</tr>
									<?php endforeach;?>
								<?php else :?>
									<td class="grey" colspan='6'>暂无活动，请继续关注理财派!</td>
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
