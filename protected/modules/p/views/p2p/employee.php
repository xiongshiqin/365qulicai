<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'service', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/employee',array('cpid'=>$cpid));?>">员工列表</a>
				<a href="<?php echo $this->createUrl('/p/p2p/service',array('cpid'=>$cpid));?>">客服列表</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/serviceEdit',array('cpid'=>$cpid));?>">添加客服</a>			
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="6">员工列表</th>
					</tr>
					<tr>
						<th width="16%">员工名称</th>
						<th width="12%">真实姓名</th>
						<th width="12%">部门</th>
						<th >是否审核</th>
						<th>是否管理后台</th>
						<th>操作</th>
					</tr>
					<?php if($employees):?>
						<?php foreach($employees as $key=>$v):?>
						<tr class="<?php echo $key%2?'tr_bg':''?> employee_<?php echo $v->id?>">
							<td><?php echo $v->username;?></td>
							<td><?php echo $v->realname?></td>
							<td><?php echo Yii::app()->params['department'][$v->department];?></td>
							<td class="isCheck"><?php if($v->status==1){echo '是';}else if($v->status==0){echo '否';}?></td>
							<td class="isAdmin"><?php if($v->isadmin==1){echo '是';}else {echo '否';}?></td>
							<td class="zuzhang">
								<a href="<?php echo $this->createUrl('/p/p2p/employeeEdit',array('id'=>$v->id,'cpid'=>$cpid))?>">编辑</a>
								/
								<a href="javascript:void(0)" onclick="remEmployee(<?php echo $v->id?>);">删除</a>&nbsp;&nbsp;|&nbsp; 
								<?php if($v->status == 0 ):?>
								<span class="checkOp">
									<a href="javascript:void(0)" onclick="setStatus(<?php echo $v->id?>,1);">审核通过</a>
									/
									<a href="javascript:void(0)" onclick="setStatus(<?php echo $v->id?>,-1);">审核不通过</a>&nbsp;&nbsp;|&nbsp;
								</span>
								<?php endif;?>
								<?php if($v->isadmin == 0):?>
									<span class="isadminOp">
										<a href="javascript:void(0)" onclick="setAdmin(<?php echo $v->id?>);">设为管理员</a>
									</span>
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
	// 删除员工
	function remEmployee(id){
		if(!window.confirm("确认删除吗？此操作不可恢复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/employeeDel')?>",{'id':id},function(result){
			if(result.status == true){
				$('.employee_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}

	function setStatus(id,status){
		$.post("<?php echo $this->createUrl('/p/p2p/empSetStatus')?>",{'cpid':<?=$cpid?>,'id':id,'status':status},function(result){
			if(result.status == true){
				if(status == 1){
					$('.employee_'+id+' .isCheck').html('是');
					$('.employee_'+id+' .checkOp').remove();
				} else {
					$('.employee_'+id).remove();
				}
			}else{
				alert(result.msg);
			}
		},'json');
	}

	//设为管理员
	function setAdmin(id){
		if(!window.confirm("管理员拥有最高权限，确认设置为管理员吗？此操作不可恢复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/empSetAdmin')?>",{'id':id},function(result){
			if(result.status == true){
				$('.employee_'+id+' .isAdmin').html('是');
				$('.employee_'+id+' .isadminOp').remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>
