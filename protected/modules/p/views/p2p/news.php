<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'news', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/news',array('cpid'=>$cpid));?>">新闻/公告列表</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/newsAdd',array('cpid'=>$cpid));?>">添加新闻/公告</a>		
			</div>

			<!--管理页面-->
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" colspan="4">新闻/公告列表</th>
					</tr>
					<tr>
						<th width="62%">新闻标题</th>
						<th align="center">发布时间</th>
						<th align="center">浏览次数</th>
						<th align="center">操作</th>
					</tr>
					<?php if($news):?>
						<?php foreach($news as $key=>$v):?>
						<tr class="<?php echo $key%2?'tr_bg':''?> news_<?php echo $v->newsid;?>">
							<td><a target="_blank" href="<?php echo $this->createUrl('/p2p/newsDetail', array('id'=>$v->newsid));?>"><?php echo $v->title?></a></td>
							<td align="center"><?php echo date('Y-m-d',$v->dateline);?></td>
							<td align="center"><?php echo $v->viewnum;?></td>
							<td class="zuzhang" align="center">
								<a href="<?php echo $this->createUrl('/p/p2p/newsEdit/',array('newsid'=>$v->newsid,'cpid'=>$cpid))?>">编辑</a>
								/
								<a href="javascript:void(0)" onclick="remNews(<?php echo $v->newsid?>);">删除</a>
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
	function remNews(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/newsDel')?>",{'id':id},function(result){
			if(result.status == true){
				$('.news_'+id).remove();
			}else{
				show_message('error' , result.msg);
			}
		},'json');
	}
</script>