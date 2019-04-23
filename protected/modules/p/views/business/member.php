<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('BusinessMenu',array('selected'=>'member')); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a <?php if($status == 0) echo ' class="selected" '; ?> href="<?php echo $this->createUrl('/p/business/member' , array('id'=>$id,'status'=>0));?>">申请中</a>		
				<a <?php if($status == 1) echo ' class="selected" '; ?> href="<?php echo $this->createUrl('/p/business/member' , array('id'=>$id,'status'=>1))?>">业务咨询</a>	
			</div>

			<!--邀请码列表-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="8">人员管理</th>
					</tr>
					<tr>
						<th colspan="2">用户名称</th>
						<th>电话</th>
						<th>QQ</th>
						<th width="25%">备注</th>
						<th>时间</th>
						<th>状态</th>
						<th>操作</th>
					</tr>
					<?php if($members):?>
						<?php foreach($members as $key=>$value):?>
						<tr class="member_<?php echo $value->id?>">
							<td width="7%" class="touxiang"><a href=""><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/touxiang.png" /></a></td>
							<td width="11%" style="padding-left:5px;"><a href=""><?php echo $value->realname;?></a></td>
							<td><?php echo $value->mobile;?></td>
							<td><?php echo $value->qq;?></td>
							<td><?php echo $value->remark?></td>
							<td><?php echo date('Y-m-d h:i:s',$value->dateline)?></td>
							<td><?php echo $value->status;?></td>
							<td class="zuzhang">
								<?php if($status == 0):?>
									<a href="javascript:void(0);" onclick="checkMem(<?php echo $value->id;?>,'status','1');">通过</a>
									｜
									<a href="javascript:void(0);" onclick="checkMem(<?php echo $value->id;?>,'isshow','0')">忽略</a>
									｜
								<?php endif;?>
								<a href="javascript:void(0);" onclick="checkMem(<?php echo $value->id;?>,'status','-1');">删除</a>
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
	// 审核用户  通过/忽略/删除
	function checkMem(id,field,val){
		$.post("<?php echo $this->createUrl('/p/business/checkMem')?>",{'id':'<?=$id?>','sid':id,'field':field,'val':val},function(result){
			if(result.status == true){
				$('.member_'+id).hide(1000);
			}
		},'json');
	}
</script>