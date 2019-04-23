<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php  $this->widget('BusinessMenu',array('selected'=>'news')); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected" href="">新闻列表</a>		
				<a href="<?php echo $this->createUrl('/p/business/newsAdd', array('comId'=>$comId,'id'=>$comId)); ?>">添加新闻</a>	
			</div>

			<!--新闻列表-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="4">新闻列表</th>
					</tr>
					<tr>
						<th width="57%">标题</th>
						<th>浏览</th>
						<th>时间</th>
						<th>操作</th>
					</tr>
					<?php if($news):?>
						<?php foreach ($news  as $key=>$value) {?>
						<tr class="news_<?php echo $value->id;?>">
							<td><a target="_blank" href="<?php echo $this->createUrl('/business/view',array('id'=>$value->id))?>"><?php echo  CHtml::encode($value->title);?> </a></td>
							<td><?php echo $value->viewnum;?></td>
							<td><?php echo date('Y-m-d h:i:s', $value->dateline); ?></td>
							<td class="zuzhang">
								<a href="<?php echo $this->createUrl('/p/business/newsEdit', array('id'=>$value->id)); ?>">修改</a>
								/
								<a href="javascript:void(0)" onclick="remNews(<?php echo $value->id?>);">删除</a>
							</td>
						</tr>
						<?php };?>
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
	function remNews(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/business/newsDel')?>",{'id':id},function(result){
			if(result.status == true){
				$('.news_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>