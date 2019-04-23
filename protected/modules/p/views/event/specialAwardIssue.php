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
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress1.png" />
								<p>活动基本内容</p>
							</a>
						</li>
						<li class="setAward awardEdit">
							<a href="<?php echo $this->createUrl('/p/event/setAward',array('cpid'=>$cpid,'eventid'=>$event->eventid))?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress2.png" />
								<p>上传奖品</p>
							</a>
						</li>
						<li class="lotteryAward">
							<a href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress3.png" />
								<p>设置抽奖</p>
							</a>
						</li>
					</ol>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
			<!--<div class="tab">
				<ul class="tab_menu">
					<li ><a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">抽奖发奖</a></li>
					<li class="selected_li"><a href="<?php echo $this->createUrl('/p/event/specialAwardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">特别发奖</a></li>
				</ul>
			</div>-->
			<!--活动设置-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">

						<tr>
							<th>关注时间：</th>
							<td>
								<?php 
									$this->widget('application.extensions.timepicker.timepicker', array(
									    'name' => 'starttime',
									    'value' => $starttime,
									    'model' => $event,
									));
								?>
								&nbsp;&nbsp;至&nbsp;
								<?php 
									$this->widget('application.extensions.timepicker.timepicker', array(
									   'name'=>'endtime',
									   'value' => $endtime,
									   'model' => $event,
									));
								?>
							</td>
						</tr>
						<tr>
							<th>邀请人数：</th>
							<td>
								<input style="width:130px;" type="text" name="startInvite" value="<?php echo $startInvite?>" id="textfield" />&nbsp;&nbsp;人到&nbsp;
								<input style="width:130px;" type="text" name="endInvite"  value="<?php if($endInvite) echo $endInvite?>" id="textfield" /><span>&nbsp;&nbsp;不填写表示不限人数</span> 

							</td>
						</tr>
						<tr>
							<th>发奖品：</th>
							<td>
								<input style="width:14px; height:14px; border:0;"  class="isSend_0" type="radio" value="0" name="isSend" />
								<label>不限</label>
								<input style="width:14px; height:14px; border:0;"  class="isSend_1" type="radio" value="1" name="isSend" />
								<label>己发奖品</label>
								<input style="width:14px; height:14px; border:0;"  class="isSend_2"  type="radio" value="2" name="isSend" />
								<label>未发奖品</label>
							</td>
						</tr>
						<tr>
							<th>Vip：</th>
							<td>
								<input style="width:14px; height:14px; border:0;"  class="isVip_0" type="radio" value="0" name="isVip" />
								<label>不限</label>
								<input style="width:14px; height:14px; border:0;"  class="isVip_2"  type="radio" value="2" name="isVip" />
								<label>是</label>
								<input style="width:14px; height:14px; border:0;" class="isVip_1"  type="radio" value="1" name="isVip" />
								<label>否</label>
							</td>
						</tr>
						<tr>
							<th>用户名称：</th>
							<td class="quote">
								<input style="text" name="username" value="<?php echo $username;?>" />
							</td>
						</tr>
						<tr>
							<th>中奖者：</th>
							<td colspan="8">
								<input style="width:14px; height:14px; border:0;" checked="checked" type="radio" value="invitenum" name="order" class="invitenum_order"></input>
								<label>按邀请人数排名</label>
								<input style="width:14px; height:14px; border:0;"  type="radio" value="dateline" name="order" class="dateline_order"></input>
								<label>按关注时间排名</label>								
								<input style="width:14px; height:14px; border:0;" type="radio" value="join_event_num" name="order" class="join_event_num_order"></input>
								<label>按参加活动次数排名</label>								
							</td>
						</tr>
						<tr>
							<td></td>
							<td>
								<input class="btn_blue" type="submit" id="button" value="搜&nbsp;&nbsp;&nbsp;&nbsp;索" />
							</td>
						</tr>
					</table>

					<div class="clearboth"></div>
				</form>
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<form class="" id="form1" name="form1" method="post" action="">
					<table class="hudong_table" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<th class="title" width="14%">
								<input type="checkbox" name="checkbox" id="checkbox" />
								<label for="checkbox">编号</label>
							</th>
							<th class="title" width="16%">名称</th>
							<th class="title" width="16%">平台关联帐号</th>
							<th class="title">邀请</th>
							<th class="title">关注时间</th>
							<th class="title">奖励</th>
							<th class="title">操作</th>
						</tr>
						<?php if($eventLikes):?>
							<?php foreach($eventLikes as $k=>$v):?>
								<tr class="aa <?php if($k%2) echo 'tr_bg'?>">
									<td>
										<input type="checkbox" name="checkbox1" id="checkbox1" />
										<label for="checkbox1">第<?php echo $v->num;?>名</label>
									</td>
									<td><?php echo $v->username?></td>
									<td><?php if($follow = CompanyFollow::model()->find("cpid = " . $v->p2pid . ' and uid = ' . $v->uid)) echo $follow->p2pname;?></td>
									<td><?php echo $v->invitenum;?>人</td>
									<td><?php echo date('m-d H:i:s' , $v->dateline);?></td>
									<td>
										<select id="award_<?php echo $v->id?>" >
											<?php if($awards):?>
												<?php foreach($awards as $a):?>
													<option value="<?php echo $a->awardid;?>"><?php echo $a->awardname;?></option>
												<?php endforeach;?>
											<?php endif;?>
										</select>
									</td>
									<td class="fafang">
										<a href="javascript:void(0);" onclick="awardIssue(<?php echo $v->eventid . ',' . $v->uid . ',' . $v->id?>);">发放</a>
									</td>
								</tr>
								<tr>
									<td class="huodong_td grey" colspan="7">
									<span class="sendAwards_<?php echo $v->id?>">已发奖励：</span>
									<?php if($v->special_awards):?>
										<?php foreach($v->special_awards as $s):?>
											<?php echo '    ' . $s->awardname?>
										<?php endforeach;?>
									<?php endif;?>
									</td>
								</tr>
						<?php endforeach;?>
					<?php endif;?>

					</table>

					<!--分页-->
					<div class="pages" style="padding-left:13px;">
						<?php //$this->widget("CLinkPager",array('pages'=>$pages,'cssFile'=>false))?>

					</div>
					<!--分页End-->
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// 初始化 '发奖品' 筛选选项
		$('.isSend_' + <?php echo $isSend?>).attr('checked' , 'checked');
		// 初始化 'Vip' 筛选选项
		$('.isVip_' + <?php echo $isVip?>).attr('checked' , 'checked');
		// 初始脂 '排序' 筛选条件
		$('.<?php echo $order?>_order').attr('checked' , 'checked');
	});
	// 奖品发放
	// eventid 活动id uid 用户id awardid 奖品id id 点赞信息Id
	function awardIssue(eventid , uid , id){
		var awardid = $('#award_'+id).val();
		var data = { 
			'eventid' : eventid,
			'uid' : uid,
			'awardid' : awardid,
		};
		ajaxpost('<?php echo $this->createUrl("/p/event/awardSpecialIssue")?>',data,function(result){
			show_message('sucecss',result.msg);
			$('.sendAwards_' + id).append('    ' + result.data);
		},function(result){
			show_message('error',result.msg);
		});
	}

	// 设置vip
	function setVip(id,vip){
		var data = {
			'id' : id,
			'vip' : vip,
		};
		ajaxpost('<?php echo $this->createUrl("/p/event/setVip");?>',data,function(result){
			show_message('success',result.msg);
			$('.setVip_'+id).html(result.data);
		},function(result){
			show_message('error' , result.msg);
		});	
	}
</script>