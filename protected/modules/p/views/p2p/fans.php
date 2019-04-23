<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'fans', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
		<!-- 	<div class="block menu_btn menu_btn1">
				<a class="selected"  href="">客服列表</a>		
				<a href="">添加客服</a>		
			</div>
 -->
			<!--管理页面-->
			<div class="block backstage_table">
				<form id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="5">
								<input order="invitenum" id="invitenum" type="radio" value="" name="order"></input>
								<label>按邀请人数排名</label>
								<input order="dateline" id="dateline" type="radio" value="" name="order"></input>
								<label>按关注时间排名</label>								
								<input order="join_event_num" id="join_event_num" type="radio" value="" name="order"></input>
								<label>按参加活动次数排名</label>								
							</td>
						</tr>

						<tr style="border-top:1px solid #E5E5E5;">
							<th class="title" colspan="5">会员列表</th>
						</tr>
						<tr>
							<th width="30%">名称</th>
							<th width="30%">平台关联名称</th>
							<th>参加活动</th>
							<th>邀请人次</th>
							<th>关注时间</th>
						</tr>
						<?php if($fans):?>
							<?php foreach($fans as $key=>$v):?>
								<tr class="<?php echo $key%2?'tr_bg':''?>">
									<td><?php echo $v->username;?></td>
									<td><?php echo $v->p2pname;?></td>
									<td><?php echo $v->join_event_num;?>个</td>
									<td><?php echo $v->invitenum;?>人</td>
									<td><?php echo date('Y-m-d',$v->dateline);?></td>
								</tr>
							<?php endforeach;?>
						<?php endif;?>
					</table>
				</form>
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
	$(document).ready(function(){
		$('#'+"<?php echo $order;?>").attr('checked','checked');
		// 按照不同类型排序
		$(':radio').click(function(){
			window.location.href = "<?php echo $this->createUrl('/p/p2p/fans',array('cpid'=>$cpid));?>&order="+$(this).attr('order');
		});
	});
</script>