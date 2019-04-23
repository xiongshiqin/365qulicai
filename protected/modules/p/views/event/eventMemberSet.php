<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'event', //选中状态
		)); ?>

		<div class="mainarea">
		
			<?php include dirname(__FILE__) . "/subHeader.php"?>
			
			<div class="block fatie" style="margin-bottom:10px;">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="13%">查找关联帐号：</th>
							<td class="quote">
								<input style="text" name="username" value="<?php echo $username;?>" />
								<input class="btn_blue" type="submit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
							</td>
						</tr>
					</table>

					<div class="clearboth"></div>
				</form>
			</div>

			<!--div class="tab">
				<ul class="tab_menu">
					<li class="<?php echo $tab != 'vip' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p/event/eventMemberSet',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">全部</a></li>
					<li class="<?php echo $tab == 'vip' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p/event/eventMemberSet',array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>'vip'))?>">已设vip</a></li>
				</ul>
			</div-->
			
			<!--管理页面-->
			<div class="block backstage_table">
				<form class="" id="form1" name="form1" method="post" action="">
					<table  width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
							<td colspan="5">
								<a href="<?php echo $this->createUrl('/p/event/eventMemberSet',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">
									<input <?php if($tab != 'vip') echo " checked='checked' ";?> type="radio" name="radio"></input>
									<label>全部</label>
								</a>

								<a href="<?php echo $this->createUrl('/p/event/eventMemberSet',array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>'vip'))?>">
									<input <?php if($tab == 'vip') echo " checked='checked' ";?> type="radio" name="radio"></input>
									<label>己设Vip</label>
								</a>
							</td>
						</tr>
						<tr style="border-top:1px solid #E5E5E5;">
							<th class="title" width="16%">名称</th>
							<th class="title" width="16%">平台关联帐号</th>
							<th class="title">邀请人数</th>
							<th class="title">关注时间</th>
							<th class="title">是否VIP</th>
						</tr>
						<?php if($eventLikes):?>
							<?php foreach($eventLikes as $k=>$v):?>
								<tr class="aa <?php if($k%2) echo 'tr_bg'?>">
									<td><?php echo $v->username?></td>
									<td><?php if($follow = CompanyFollow::model()->find("cpid = " . $v->p2pid . ' and uid = ' . $v->uid)) echo $follow->p2pname;?></td>
									<td><?php echo $v->invitenum;?>人</td>
									<td><?php echo date('Y-m-d H:i:s' , $v->dateline);?></td>
									<td style="cursor:pointer" class="quote setVip_<?php echo $v->id?>">
										<?php if($v->vip):?>
											<a onclick="setVip(<?php echo $v->id;?> , 0);">Vip 取消</a>
										<?php else:?>
											<a onclick="setVip(<?php echo $v->id;?> , 1);">设成vip</a>
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
	$(function(){
		// 全部和已设VIP radio的单击事件，chrome兼容性
		$(':radio').click(function(){
			window.location.href = $(this).parent('a').attr('href');
		});
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