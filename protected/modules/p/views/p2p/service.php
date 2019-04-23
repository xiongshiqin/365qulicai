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
				<?php if(($emp = CompanyEmployee::model()->find("cpid = $cpid and uid = " . Yii::app()->user->id)) && $emp->isadmin == 1):?>
					<a href="<?php echo $this->createUrl('/p/p2p/employee',array('cpid'=>$cpid));?>">员工列表</a>
				<?php endif;?>
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/service',array('cpid'=>$cpid));?>">客服列表</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/serviceEdit',array('cpid'=>$cpid));?>">添加客服</a>		
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="4">客服列表</th>
					</tr>
					<tr>
						<th width="27%">客服名称</th>
						<th width="27%">QQ号码</th>
						<th width="27%">状态</th>
						<th>操作</th>
					</tr>
					<?php if($service):?>
					<?php foreach($service as $key=>$v):?>
							<tr class="<?php echo $key%2?'tr_bg':''?> service_<?php echo $v->id;?>">
								<td><?php echo $v->nickname;?></td>
								<td><?php echo $v->qq;?></td>
								<td><?php if($v->status == 1) echo "启用"; else echo "停用";?></td>
								<td class="zuzhang">
									<a href="<?php echo $this->createUrl('/p/p2p/serviceEdit',array('id'=>$v->id,'cpid'=>$cpid));?>">编辑</a>
									<a href="javascript:void(0)" onclick="remService(<?php echo $v->id?>);">删除</a>
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
	function remService(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/serviceDel')?>",{'id':id,'cpid':<?php echo $cpid;?>},function(result){
			if(result.status == true){
				$('.service_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>