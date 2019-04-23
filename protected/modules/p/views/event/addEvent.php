<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'event', //选中状态
		)); ?>

		<div class="mainarea">
			
			<?php include dirname(__FILE__) . "/subHeader.php"?>
			<?php if(! $manage):?>
				<!--进度条-->
				<div class="block" >
					<ol class="progress">
						<li class="addEvent">
							<a href="<?php echo $this->createUrl('/p/event/addEvent',array('eventid'=>$event->eventid,'cpid'=>$cpid));?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress1_cur.png" />
								<p>活动基本内容</p>
							</a>
						</li>
						<li class="setAward awardEdit">
							<a href="<?php echo $this->createUrl('/p/event/setAward',array('cpid'=>$cpid,'eventid'=>$event->eventid))?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress2_unset.png" />
								<p>上传奖品</p>
							</a>
						</li>
						<li class="lotteryAward">
							<a href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress3_unset.png" />
								<p>设置抽奖</p>
							</a>
						</li>
					</ol>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="eventid" value="<?php echo $event->eventid?>"/>
						<input type="hidden" name="manage" value="<?=$manage?>"/>
						<tr>
							<th width="14%">活动标题：</th>
							<td width="87%"><input style="width:390px;" type="text" name="title" value="<?php echo $event->title;?>"/></td>
						</tr>
						<!-- <tr>
							<th>活动类型：</th>
							<td>
								<select style="width:390px;" name="type" id="type">
									<?php foreach(Yii::app()->params['Event']['type'] as $k => $v):?>
										<option <?php if($event->type == $k) echo " selected='selected' "?> value="<?php echo $k;?>"><?php echo $v;?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr> -->
						<?php if($event->status == 2 || $type=='notice'):// 如果活动已经发布，则不能修改抽奖类型,未填写抽奖api的只能发布不抽奖的活动?>
							<input type="hidden" name="lotterytype" value="<?=$event->lotterytype?>"/>
						<?php else:?>
							<tr>
								<th style="padding-top:6px;" valign="top">选择抽奖：</th>
								<td>
									<?php foreach(Yii::app()->params['Event']['lotterytype'] as $k=>$v):?>
										<input class="lotterytype_<?=$k?>" style="width:14px; height:14px; border:0;" type="radio" value="<?php echo $k;?>" name="lotterytype" />
										<label><?php echo $v;?></label>
									<?php endforeach;?>
									<p style="padding-top:6px;"><img <?php if(! $event->lotterytype) echo ' style="display:none;" '?> id="lottery_img" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/lottery<?=$event->lotterytype?>.jpg" /></p>
								</td>
							</tr>
						<?php endif;?>
						<tr>
							<th>开始时间：</th>
							<td>
								<?php 
									$this->widget('application.extensions.timepicker.timepicker', array(
									    'model'=>$event,
									    'name'=>'starttime',
									));
								?>
							</td>
						</tr>
						
						<tr>
							<th>结束时间：</th>
							<td>
								<?php 
									// 如果有值则为结束时间，否则为当前时间往后一个月
									$arr = $event->endtime ? array('model'=>$event, 'name'=>'endtime',) : array('name'=>'endtime','value'=>strtotime('+1 month'));
									$this->widget('application.extensions.timepicker.timepicker', $arr);
								?>
							</td>
						</tr>
						<tr>
							<th valign="top">活动内容：</th>
							<td style="padding:0"><textarea style="width:735px;" name="content" cols="45" rows="5"> <?php if($event->eventid) echo $event->event_field->content;?></textarea></td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td>
								<input class="btn_blue" style="margin-right:15px;" type="submit" name="button" id="button" value="<?php echo $manage ? '确定' : '下一步';?>" />
							</td>
						</tr>
					</table>
				</form>

				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('.lotterytype_<?=$event->lotterytype?>').attr("checked" , "checked");

		// 切换抽奖类型更新图片
		$('[name=lotterytype]').click(function(){
			var t = $(this).val();
			if(t == 0){
				$('#lottery_img').hide();
			} else {
				$('#lottery_img').show();
			}
			$('#lottery_img').attr('src' , "/html/images/lottery" + t + ".jpg");
		});
	});
</script>