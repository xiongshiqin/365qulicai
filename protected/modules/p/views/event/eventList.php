
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'event', //选中状态
		)); ?>


		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected"  href="<?php echo $this->createUrl('/p/event/eventList',array('cpid'=>$cpid));?>">活动列表</a>		
				<a href="<?php echo $this->createUrl('/p/event/addEvent',array('cpid'=>$cpid));?>">发起活动</a>		
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="7">活动列表</th>
						
					</tr>
					<tr>
						<th style="width:38%;">活动标题</th>
						<th>抽奖</th>
						<th>时间</th>
						<th>浏览</th>
						<th>点赞</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
					<?php if($events):?>
						<?php foreach($events as $key=>$v):?>
							<tr class="<?php echo $key%2?'tr_bg':''?>">
								<td><a target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail' , array('eventid'=>$v->eventid));?>"><?php echo $v->title;?></a></td>
								<td><?php echo Yii::app()->params['Event']['lotterytype'][$v->lotterytype];?></td>
								<td><?php echo date('m-d H:i',$v->starttime) . '到' .  date('m-d H:i',$v->endtime);?></td>
								<td><?php echo $v->viewnum;?></td>
								<td><?php echo $v->likenum;?></td>
								<td><?php echo Yii::app()->params['Event']['status'][$v->status];?></td>
								<td class="zuzhang">
									<a href="<?php echo $this->createUrl('/p/event/addEvent',array('eventid'=>$v->eventid,'cpid'=>$cpid,'manage'=>true));?>">管理活动</a>
									<?php if($v->status == 0):?>
										/
										<a href="<?php echo $this->createUrl('/p/event/eventRelease',array('eventid'=>$v->eventid,'cpid'=>$cpid));?>">发布</a>
										<!--
										<a href="javascript:void(0)" onClick="remEvent(<?php echo $v->eventid . ',' . $cpid?>);">删除</a>
										-->
									<?php endif;?>
								</td>
							</tr>
						<?php endforeach;?>
					<?php endif;?>
				</table>
				<!--分页-->
				<div class="pages">
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
<script>
	// 删除新闻
	function remEvent(eventid,cpid){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/event/eventDel')?>",{'eventid':eventid , 'cpid':cpid},function(result){
			if(result.status == true){
				window.location.reload();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>