<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'biaos', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected" href="">发标播报</a>		
				<a href="<?php echo $this->createUrl('biaosEdit',array('cpid'=>$cpid))?>">添加发标</a>		
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="10">发标列表</th>
					</tr>
					<tr>
						<th width="15%">发标名称</th>
						<th align="center">金额/元</th>
						<th align="center">月利率/%</th>
						<th align="center">奖励</th>
						<th align="center">周期</th>
						<th align="center">标类型</th>
						<th align="center">预计发标时间</th>
						<th align="center">发布时间</th>
						<th align="center">操作</th>
					</tr>
					<?php if($biaos):?>
						<?php foreach($biaos as $key=>$biao):?>
						<tr class="<?php echo $key%2?'tr_bg':''?> biao_<?php echo $biao->id;?>">
							<td><a target="_blank" href="<?=$this->createUrl('/p2p/index' , array('cpid'=>$biao->cpid));?>"><?php echo $biao->title;?></a></td>
							<td align="center"><?php echo $biao->money;?></td>
							<td align="center"><?php echo $biao->interestrate;?>%</td>
							<td align="center"><?php echo $biao->award;?>%</td>
							<td align="center"><?php echo $biao->timelimit;?></td>
							<td align="center"><?php echo Yii::app()->params['Biaos']['itemtype'][$biao->itemtype];?></td>
							<td align="center"><?php echo date('Y-m-d',$biao->datelinepublish);?></td>
							<td align="center"><?php echo date('Y-m-d',$biao->dateline);?></td>
							
							<td class="zuzhang">
								<a href="<?php echo $this->createUrl('/p/p2p/biaosEdit',array('id'=>$biao->id,'cpid'=>$cpid));?>">编辑</a>
								/
								<a href="javascript:void(0)" onClick="remBiaos(<?php echo $biao->id?>);">删除</a>
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
	function remBiaos(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/biaosDel')?>",{'id':id},function(result){
			if(result.status == true){
				$('.biao_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>