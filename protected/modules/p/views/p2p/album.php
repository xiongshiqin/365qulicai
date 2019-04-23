<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'album', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/album',array('cpid'=>$cpid));?>">宣传相册</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/albumEdit',array('cpid'=>$cpid));?>">添加图片</a>		
			</div>

			<!--管理页面-->
			<div class="block">
				<style>			
				</style>

				<ul class="photo photos backstage_img">
					<?php if($albums):?>
						<?php foreach($albums as $v):?>
							<li class="album_<?php echo $v->id;?>">
								<a href=""><img src="<?php echo Yii::app()->request->baseUrl.$v->url; ?>" /></a>
								<div class="con">
									<a href="<?php echo $this->createUrl('/p/p2p/albumEdit',array('id'=>$v->id,'cpid'=>$cpid)); ?>"><i class="edit">编辑</i></a>
									<a href="javascript:void(0)" onclick="remAlbum(<?php echo $v->id?>);"><i>删除</i></a>
								</div>
								<p><a href=""><?php echo $v->picname;?></a></p>
							</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>

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
	function remAlbum(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/albumDel')?>",{'id':id,'cpid':<?php echo $cpid;?>},function(result){
			if(result.status == true){
				$('.album_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>