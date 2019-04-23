<!--网友评论-->
<div class="block news_comment">
	<input type="hidden" name="toid" value="<?php echo $this->toid; ?>" />
	<h3><cite><a href="javascript:void(0)"><?=$replynum;?>条评论</a> </cite>派友评论</h3>
	<div class="comment_border">
		<div class="comment_textarea">
			<textarea name="content" id="content"></textarea>
		</div>
		<div class="comment_button">
			<input type="button" name="button" id="submit" value="发表评论" />
			<div class="comment_user">
				<img src="<?php echo HComm::avatar(Yii::app()->user->id); ?>"/><?=Yii::app()->user->name;?>
			</div>
		</div>
	</div>
</div>

<!--全部评论-->
<div class="block">
	<ul class="group">
		<?php foreach ($comments as $key => $value):?>
		<li class="comment_<?=$value['toid']?> review" comment_id="<?=$value['cid']?>">
			<div class="groupL">
				<a target="_blank" href="<?php echo Yii::app()->createUrl('home/index',array('uid'=>$value["uid"])); ?>"><img src="<?php echo HComm::avatar($value['uid']);?>" /></a>
			</div>
			<div class="groupR postC" >
				<h5>
					<!-- <cite><a href="javascript:void(0)" class="sec_reply">回复</a>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d H:i:s',$value['dateline']);?></cite> -->
					<cite>
						<a href="javascript:void(0)" class="ding">顶(<span><?=$value['likenum']?></span>)</a>
						&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d H:i:s',$value['dateline']);?>
					</cite>
					<a target="_blank" href="<?php echo Yii::app()->createUrl('home/index',array('uid'=>$value['uid']));?>"><?php echo $value['username'];?></a>
				</h5>
				<p>
					<?php echo  $value['content'];?>
				</p>
			</div>
			<?php foreach($value['reply'] as $v):?>
				<dt><?=$v['username']?> : <?=$v['content'];?></dt>
			<?php endforeach;?>
		</li>
		<?php endforeach; ?>
	</ul>
	<!--分页-->
	<div class="pages" style="clear:both;">
		<?php   
			$_pager = Yii::app()->params->pager;
			$_pager['pages'] = $pages;
			$this->widget('CLinkPager', $_pager);
   	 	?> 
	</div>
</div>
<script>
	$(function(){
		// 一级评论
		$('#submit').click(function(){
			var data = {
				'content' : $('#content').val(),
				'type' : '<?=$this->type;?>',
				'toid' : '<?=$this->toid?>',
			};
			ajaxpost("<?php echo Yii::app()->createUrl('/ajax/reply')?>" , data , function(result){
				$('#content').val('');
				show_message('success' , result.msg);
				$('.group').prepend(result.data);
			} , function(result){
				show_error(result.msg);
			});
		});	
		
		// 二级回复
		$('.group').on('click', '.sec_reply' , function(){
			var dom = $(this);
			var li = $(this).parents('li');
			var comment_id = li.attr('comment_id');
			li.append('<textarea class="reply_'+comment_id+'" style="height:50px;width:500px"></textarea><button class="reply">回复</button>');
			$('.reply').click(function(){
				var data = {
					'comment_id' : comment_id,
					'toid' : '<?=$this->toid?>',
					'content' : $('.reply_'+comment_id).val(),
				};
				ajaxpost("<?php echo Yii::app()->createUrl('/ajax/secondReply')?>" , data , function(result){
					$('.reply_'+comment_id).remove();
					$('.reply').remove();
					li.find('.groupR').after(result.data);
					show_message('success' , result.msg);
				} , function(result){
					show_message('error' , result.msg);
				});
			});
		});

		// 顶
		$('.group').on('click' , '.ding' , function(){
			var dom = $(this);
			var comment_id = dom.parents('li').attr('comment_id');
			var data = {
				'comment_id' : comment_id,
			};
			ajaxpost("<?php echo Yii::app()->createUrl('/ajax/ding')?>" , data , function(result){
				dom.find('span').text(result.data);
			} , function(result){
				show_error(result.msg);
			});
		});
	});
</script>