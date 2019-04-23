<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'video', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/video',array('cpid'=>$cpid));?>">宣传视频</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/videoEdit',array('cpid'=>$cpid))?>">添加视频</a>		
			</div>
			<p class="help">
				视频丰富的图像展示效果，可以展示自己公司办公情况、领导致辞、团队介绍、标的物拍摄等等，起到远程考察的作用。<br/>
				信息更加透明，更加容易获得投资人信赖<br/>
				不需要专业的摄像机，自己用苹果手机摄像就行，然后传到优酷网站上(跟上传图片一样简单)，把视频地址记录下来就可以了				
			</p>
			<!--管理页面-->
			<div class="block backstage_table">
				
				<!--企业视频-->
				<div class="block" style="margin-bottom:5px;">
					<ul class="video">
						<?php if($video):?>
							<?php foreach($video as $v):?>
								<li><embed allowfullscreen="true" id="movie_player" width="330" height="240" type="application/x-shockwave-flash" src="<?php echo $v->url;?>" quality="high">
									<p>
										<a><?php echo $v->title;?></a>&nbsp;&nbsp;
										<span class="zuzhang" style="float:right;">
											<a href="<?php echo $this->createUrl('/p/p2p/videoEdit',array('id'=>$v->id,'cpid'=>$cpid));?>">编辑</a>&nbsp;&nbsp;
											<a href="javascript:void(0)" onclick="remVideo(<?php echo $v->id?>);">删除</a>
										</span>
									</p>
								</li>
							<?php endforeach;?>
						<?php endif;?>
					</ul>
					<div class="clearboth"></div>
				</div>
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
	function remVideo(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/videoDel')?>",{'id':id,'cpid':<?php echo $cpid;?>},function(result){
			if(result.status == true){
				$('.video_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>