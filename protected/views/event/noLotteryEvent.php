<!--内容区-->
<div id="wrap">
	<!--<div class="content">
		我的位置
		<div class="block position no_bg">
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'优惠活动'=>$this->createUrl('/event/p2pEvents'),
				$event->title => $this->createUrl('/event/p2pEventDetail',array('eventid'=>$event->eventid)),
				),
		)); ?>
		</div>

	</div>-->

	<div class="contentR">
		<div class="sideR">
			<!--第三方支付-->
			<div class="block ptwoplicai">
				<dl>
					<dt><a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $event->p2pid));?>"><img src="<?php echo HComm::get_com_dir($event->p2pid);?>" /></a></dt>
					<dd class="third_logo" style="margin-top:12px;">
						<?php $this->widget('CompanyRelationship' , array('cpid' => $event->p2pid))?>
					</dd>
				</dl>
			</div>

			<!--最近点赞的人-->
			<div class="block block1">
				<h3>最近点赞的粉丝<!--small><a href="">（查看更多）</a></small--></h3>
				<ul class="member">
					<?php if($eventLike):?>
						<?php foreach($eventLike as $v):?>
							<li>
								<a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><img src="<?php echo HComm::avatar($v->uid)?>" /></a>
								<p><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><?php echo $v->username;?></a></p>
							</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
				<div style="clear:both;"></div>
			</div>

			<?php if($eventAwardLog):?>
				<!--奖励发放记录-->
				<div class="block block1">
					<h3>奖励发放记录<!--small><a href="">（查看更多）</a></small--></h3>
					<ul class="group business aeward_fafan">
						<?php foreach($eventAwardLog as $v):?>
							<li>
								<!--div class="groupL"><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><img src="<?php echo HComm::avatar($v->uid)?>" /></a></div-->
								<div class="groupR quote">
									<p><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><?php echo $v->username?></a>获得&nbsp;<em><?php echo $v->awardname;?></em></p>
								</div>
							</li>
						<?php endforeach;?>
					</ul>
					<div style="clear:both;"></div>
				</div>
			<?php endif;?>

			<!--联系活动主办方-->
			<div class="block block1">
				<h3>联系平台客服</h3>
				<ol class="quote contact">
					<?php foreach($companyServices as $v):?>
						<li>
						 	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v->qq;?>&site=qq&menu=yes">
							<img border="0" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/qq.jpg" alt="<?=$v->nickname?>" title="<?=$v->nickname?>"/>
							<span style="position:relative;top:-3px;left:-3px;"><?php echo $v->nickname;?></span></a>
							<span style="position:relative;top:-3px;left:-1px; font-size:12px;"><?php echo $v->qq;?></span>
						</li>
					<?php endforeach;?>
					<div class="clearboth"></div>
				</ol>
			</div>

			<!--广告-->
			<?php if($src = HComm::getAdPicUrl(2 , $event->p2pid)):?>
				<div class="banner_L">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(2 , $event->p2pid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>
		</div>

		<div class="mainarea">
			<!--活动-->
			<div class="block introduce avti">
				<h4><?php echo $event->title;?></h4>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<th width="10%">活动时间：</th>
					<td colspan="3"><?php echo date('Y-m-d H:i',$event->starttime)?>　到　<?php echo date('Y-m-d H:i',$event->endtime)?></td>
					<td align="right">
					<em class="obvious">
					<span id="liked"><?php echo $event->likenum;?></span>人点赞
					<i>|</i><span><?php echo $event->viewnum;?></span>人浏览
					</em>
					
					</td>
				  </tr>
				  <tr>
					<th>发起平台：</th>
					<td width="15%"><a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $event->p2pid));?>"><?php echo $company->name;?></a></td>
					<th width="10%">活动类型：</th>
					<td><?php echo Yii::app()->params['Event']['lotterytype'][$event->lotterytype]?></td>
					<td  class="grey event_<?php echo $event->eventid?>" align="right" valign="top" style="padding-top:4px; padding-right:4px;">
						<?php if(Yii::app()->user->id && EventLike::model()->exists("eventid  = " . $event->eventid . " and uid = " . Yii::app()->user->id)):?>		
							<span class="yizan_icon">已赞</span>
						<?php else:?>
							<a href="javascript:void(0)" class="praise"  data-action="likeEvent" data-params="<?php echo $event->eventid?>">
								<span>点赞</span>
							</a>
						<?php endif;?>
					</td>
				  </tr>
				</table>
				
				<?php if($lotterySet):?>
					<div class="block yellow">
						<h3>活动奖品</h3>
						<ul class="photo prize_img">
							<?php foreach($lotterySet as $v):?>
								<li>
									<span><img src="<?php echo Yii::app()->request->baseUrl .  $v->event_award->awardpic; ?>" /></span>
									<p><em><?php echo $v->awardname;?></em></p>
								</li>
							<?php endforeach;?>
						</ul>
					</div>
				<?php endif;?>

				<!--活动内容-->
				<div class="block newsbulletin"  style="margin-top:20px;">			
					<h2>活动内容</h2>
					<p>
						<?php echo nl2br($event->event_field->content);?>
					</p>
				</div>
			</div>

			<!--广告-->
			<?php if($src = HComm::getAdPicUrl(1 , $event->p2pid)):?>
				<div class="banner_R">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(1 , $event->p2pid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>

			<?php $this->widget('CommentWidget',array('type'=>'2' , 'toid'=>$event->eventid));?>

		</div>
	</div>
</div>
