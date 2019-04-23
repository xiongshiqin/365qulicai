<?php if($manage):?>
	<h3>活动管理：<?=$event->title?></h3><br/>
	<a style="float:right" href="<?php echo $this->createUrl('/p/event/eventList' , array('cpid' => $cpid));?>">返回活动列表</a>
	<!--莱单-->
	<div class="block menu_btn" >
		<?php if($event->lotterytype):?>
			<a class="awardIssue" href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid));?>">奖品发放</a>
			<a class="specialAwardIssue" href="<?php echo $this->createUrl('/p/event/specialAwardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">特别发奖</a>
			<a class="eventMemberSet" href="<?php echo $this->createUrl('/p/event/eventMemberSet',array('eventid'=>$event->eventid,'cpid'=>$cpid));?>">成员管理</a>
		<?php endif;?>
		<a class="addEvent" href="<?php echo $this->createUrl('/p/event/addEvent',array('eventid'=>$event->eventid,'cpid'=>$cpid,'manage'=>true));?>">基础信息</a>		
		<a class="setAward awardEdit" href="<?php echo $this->createUrl('/p/event/setAward',array('cpid'=>$cpid,'eventid'=>$event->eventid,'manage'=>true))?>">奖品库存</a>	
		<?php if($event->lotterytype):?>
			<a class="lotteryAward publishedLotteryAwardEdit" href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid,'manage'=>true));?>">抽奖设置</a>	
		<?php endif;?>
	</div>
<?php endif;?>
<script>
	$(function(){
		var curAction = '<?php echo $this->getAction()->getId();?>';
		$('.' + curAction).addClass('selected').siblings('a').removeClass('selected');
	})
</script>
