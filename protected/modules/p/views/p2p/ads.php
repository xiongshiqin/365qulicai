<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'ad', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/ads',array('cpid'=>$cpid));?>">广告图片列表</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/adsEdit',array('cpid'=>$cpid));?>">添加广告图片</a>		
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="7">广告列表</th>
					</tr>
					<tr>
						<th width="34%">标题</th>
						<th>广告位置</th>
						<th>添加时间</th>
						<th>排序</th>
						<th>状态</th>
						<th>图片</th>
						<th>操作</th>
					</tr>
					<?php if($ads):?>
						<?php foreach($ads as $key=>$v):?>
						<tr class="<?php echo $key%2?'tr_bg':''?> adPic_<?php echo $v->id;?>">
							<td><a href=""><?php echo $v->title?></a></td>
							<td><?php echo Yii::app()->params['adsPlace'][$v->place];?></td>
							<td><?php echo date('Y-m-d',$v->dateline);?></td>
							<td><?php echo $v->order;?></td>
							<td class="zuzhang" ><a class="status_<?php echo $v->id;?>" href="javascript:void(0);" onclick="changeStatus(<?php echo $v->id.','.$v->place?>)"><?php if($v->status==0){echo '未启用';}else{echo '启用';}?></a></td>
							<td><img src="<?php echo Yii::app()->request->baseUrl.$v->picurl; ?>" /></td>
							<td class="zuzhang">
								<a href="<?php echo $this->createUrl('/p/p2p/adsEdit',array('id'=>$v->id,'cpid'=>$cpid))?>">编辑</a>
								/
								<a href="javascript:void(0)" onclick="remAdPic(<?php echo $v->id?>);">删除</a>
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
	function remAdPic(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/adsDel')?>",{'id':id,'cpid':<?php echo $cpid;?>},function(result){
			if(result.status == true){
				$('.adPic_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}

	// 改变广告启用/禁用的状态
	function changeStatus(id,place){
		$.get("<?php echo $this->createUrl('/p/p2p/adsChangeStatus')?>",{"id":id,'cpid':<?php echo $cpid;?>,'place':place},function(result){
			if(result.status == true){
				if($('.status_'+id).html() == "启用"){
					$('.status_'+id).html("未启用");
				} else {
					$('.status_'+id).html("启用");
				}
			} else {
				alert(result.msg);
			}
		},'json');
	}
</script>