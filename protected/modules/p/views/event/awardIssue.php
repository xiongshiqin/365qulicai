<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'event', //选中状态
		)); ?>

		<div class="mainarea">
			
			<?php include dirname(__FILE__) . "/subHeader.php"?>
			
			<!--div class="tab">
				<ul class="tab_menu">
					<li class="selected_li"><a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">抽奖发奖</a></li>
					<li> <a href="<?php echo $this->createUrl('/p/event/specialAwardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">特别发奖</a></li>

				</ul>
				<ul class="tab_menu">
					<li class="<?php echo $tab != 'sent' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid))?>">未发</a></li>
					<li class="<?php echo $tab == 'sent' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>'sent'))?>">已发</a></li>
				</ul>
			</div-->
			
			<!--管理页面-->
			<div class="block backstage_table">
				<form id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="6">
								中奖者：
								<a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>'all'))?>">
									<input <?php if($tab == 'all') echo " checked='checked' "?> type="radio" name="radio"></input>
									<label>所有中奖者</label>
								</a>
								<a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>'sent'))?>">
									<input <?php if($tab == 'sent') echo " checked='checked' "?>  type="radio" name="radio"></input>
									<label>己发奖品</label>
								</a>
								<a href="<?php echo $this->createUrl('/p/event/awardIssue',array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>'unsent'))?>">								
									<input <?php if($tab == 'unsent') echo " checked='checked' "?>  type="radio" name="radio"></input>
									<label>未发奖品</label>
								</a>	

								<a href="<?php echo $this->createUrl('/p/event/awardIssueExcel' ,array('eventid'=>$event->eventid,'cpid'=>$cpid,'tab'=>$tab));?>" style="float:right;margin-right:20px;">导出excel</a>							
							</td>
						</tr>
						<tr style="border-top:1px solid #E5E5E5;">
							<th class="title" width="17%">
								<input type="checkbox" name="checkbox" value=""/>
								<label for="checkbox">编号</label>
							</th>
							<th class="title" width="20%">名称</th>
							<th class="title" width="20%">平台关联帐号</th>
							<th class="title">中奖奖品</th>
							<th class="title">中奖时间</th>
							<th class="title">操作</th>
						</tr>
						<?php if($awards):?>
							<?php foreach($awards as $key=>$v):?>
								<tr class='award_<?php echo $v->id?>  <?php echo $key%2?'tr_bg':''?>'>
									<td>
									  <input type="checkbox" name="aids[]" value="<?php echo $v->id?>" />
									  <label for="checkbox2"><?php echo $v->id?></label>
									</td>
									<td><?php echo $v->username;?></td>
									<td><?php if($follow = CompanyFollow::model()->find("uid = $v->uid and cpid = $cpid")) echo $follow->p2pname;?></td>
									<td><?php echo $v->awardname?></td>
									<td><?php echo date('Y-m-d H:i:s' , $v->dateline);?></td>
									<?php if($v->issend):?>
										<td>已发放</td>
									<?php else:?>
										<td class="fafang"><a href="javascript:void(0);" onclick="awardIssue(<?php echo $v->id;?>);">发放</a></td>
									<?php endif;?>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
					</table>

					<!--分页-->
					<div class="pages" style="padding-left:13px;">
						<ul class="pagelist">
							<?php   
								$_pager = Yii::app()->params->pager;
								$_pager['pages'] = $pages;
								$this->widget('CLinkPager', $_pager);
							?>
						</ul>

						<div class="allfafang">
							<input type="checkbox" name="allCheck" id="allCheck" />
							<label for="allCheck">全选</label>
							<input class="all_fafang" type="submit" value="全部发放"/>
						</div>
					</div>
					<!--分页End-->
				</form>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		// 已发奖品，未发奖品，所有奖品 radio的单击事件，chrome兼容性
		$(':radio').click(function(){
			window.location.href = $(this).parent('a').attr('href');
		});
	});
	// 全选
	$('#allCheck').click(function(){
		if(this.checked){
			 $(":checkbox").each(function(){this.checked=true;});
		} else {
			 $(":checkbox").each(function(){this.checked=false;});  
		}

	});
	
	// 奖品发放
	function awardIssue(awardid){
		// 发放操作
		var data = {
			'id' : awardid,
		};
		$.post('<?php echo $this->createUrl("/p/event/awardIssueDo");?>',data,function(result){
			if(result.status == true){
				$('.award_' + awardid).hide();
			} else {
				alert(result.msg);
			}
		},'json');
	}
</script>