<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php  $this->widget('BusinessMenu',array('selected'=>'invite')); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected" href="<?php echo $this->createUrL('/p/business/invite',array('status'=>'0','id'=>$comId))?>">未使用</a>		
				<a href="<?php echo $this->createUrL('/p/business/invite',array('status'=>'1','id'=>$comId))?>">已使用</a>	
			</div>

			<!--邀请码列表-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					
					<tr style="border-top:1px solid #E5E5E5;">
						<th class="title" >邀请码列表</th>
						<th class="title"><a style="float:right;margin-right:10px;" href="javascript:void(0);" onclick="inviteApply();"><font color="blue" style="font-weight:normal;">+申请平台邀请码</font></a></th>
					</tr>
					<tr>
						<th>编号</th>
						<th>邀请码</th>
					</tr>
					<?php if($invites):?>
						<?php foreach($invites as $k=>$v):?>
							<tr>
								<td><?php echo $v->id?></td>
								<td><?php echo $v->code?></td>
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
	// 申请邀请码
	function inviteApply(){
		var data = {
			'id' : '<?php echo $comId;?>',
		};
		$.get("<?php echo $this->createUrl('/p/business/inviteApply');?>",data,function(result){
			if(result.status == true){
				window.location.reload();
			} else{
				alert(result.msg);
			}
		},'json');
	}
</script>