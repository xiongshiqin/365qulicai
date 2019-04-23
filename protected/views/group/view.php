<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">
			<!--本贴来自小组-->
			<div class="block block1">
				<h3>本贴来自小组</h3>
				<ul class="group">
					<li style="width:auto; margin:5px;">
						<div class="groupL"><a href="<?php echo $this->createUrl('group/index'); ?>"><img src="<?php echo HComm::get_group_dir($this->_group->gid)?>" /></a></div>
						<div class="groupR">
							<h5><a href="<?php echo $this->createUrl('group/index',array('gid'=>$this->_group->gid));?>"><?php echo $this->_group->name;?></a></h5>
							<p class="grey">成员：<?php echo $this->_group->follownum;?>  话题：<?php echo $this->_group->topicnum;?></p>
						</div>
							<p class="grey" style="clear:both;"><?php echo  CHtml::encode($this->_group->info);?></p>
					</li>
				</ul><div class="clearboth"></div>
			</div>

			<!--广告-->
				<?php if(($expandCpid = Yii::app()->request->cookies['expandCpid']) && $src = HComm::getAdPicUrl(2 , $expandCpid)):?>
					<div class="banner_L">
						<a target="_blank" href="<?php echo HComm::getAdPicUrl(2 , $expandCpid , 'url');?>">
							<!-- <img src="html/images/banner_L2.jpg" /> -->
							<img src="<?php echo $src;?>"/>
						</a>
					</div>
				<?php endif;?>
		</div>

		<div class="mainarea" style="_clear:both;">
			<!--小组内容-->
			<div class="block">
				<h1><?php if ($page > 1) :?>回复：<?php endif;?><?php echo $topic->title;?></h1>
				<?php if ($page==1) :?>
				<?php $postheader=array_shift($post) ;?>
				<ul class="group">
					<li class="group_huati">
						<div class="groupL">
							<a target="_blank" href="<?php echo $this->createUrl('home/index',array('uid'=>$topic->uid)); ?>"><img src="<?php echo HComm::avatar($topic->uid);?>" /></a>
							<p>楼主</p>
						</div>
						<div class="groupR postC">
							<h5>来自：<a target="_blank"  href="<?php echo $this->createUrl('home/index', array('uid'=>$topic->uid)); ?>"><?php echo $topic->username;?></a><!--&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d H:i:s',$topic['dateline']);?>--></h5>
							<p><?php echo nl2br(CHtml::encode($postheader['content']));?></p>
						</div>
					</li>
				</ul>

				<div class="zuzhang operate">
					<span style="float:left; margin-left:26px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d H:i:s',$topic['dateline']);?></span>
					<?php if($postheader->uid == Yii::app()->user->id):?>
						<a href="<?php echo $this->createUrl('/group/editTopic' , array('id'=>$topic->topicid,'gid'=>$topic->gid));?>">编辑</a>
					<?php endif;?>
					[<?php echo $topic->viewnum;?>]查看&nbsp;					
					[<?php echo $topic->replynum;?>]回复&nbsp;
					<span class="praise_<?=$topic->topicid?>" >
						<?php if(Yii::app()->user->id && Like::model()->exists("type = 1 and itemid = {$topic->topicid} and uid = " . Yii::app()->user->id)): ?>
							<span class="yizan_icon">已赞</span>[<span class="praise_num"><?php echo $topic->likenum;?></span>]
						<?php else:?>
							<a href="javascript:void(0)" data-action="praiseGroup" data-params="<?=$topic->topicid?> , tid" class="praise">
								<span class="praise_num"><?php echo $topic->likenum;?></span>
							</a>
						<?php endif?>
					</span>
					&nbsp;
				</div>
				<?php endif;?>
			</div>

			<!--广告-->
			<?php if(($expandCpid = Yii::app()->request->cookies['expandCpid']) && $src = HComm::getAdPicUrl(1 , $expandCpid)):?>
				<div class="banner_R">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(1 , $expandCpid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>

			<!--网友评论-->
			<div class="block news_comment">
				<?php if(0): ?>
					<div class="my_comment">
						<span><em>加入小组</em>与12162人一起讨论"上班那些事儿"</span>
					</div>
				<?php else : ?>
					<form class="fatie" id="replyform" name="groupReply" method="post" action="<?php echo $this->createUrl('group/reply');?>">
						<input type="hidden" name="gid" value="<?php echo $topic->gid; ?>" />
						<input type="hidden" name="topicid" value="<?php echo $topic->topicid; ?>" />
						<h3><cite><a href=""><?=$topic->replynum?>条评论</a></cite>派友评论</h3>
						<div class="comment_border">
							<div class="comment_textarea">
								<textarea name="content"></textarea>
							</div>

							<div class="comment_button">
								<input type="button" name="button" id="submit" value="发表评论" />
								<div class="comment_user">
									<img src="<?php echo HComm::avatar(Yii::app()->user->id); ?>"/><?=Yii::app()->user->name;?>
								</div>
							</div>
						</div>
					</form>
				<?php endif;?>
			</div>

			<!--全部评论-->
			<div class="block">
				<?php if ($post):?>
				<ul class="group">
					<?php foreach ($post as $key => $value) {?>
					<li class="review">
						<div class="groupL">
							<a target="_blank" href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
							<!--p><?php $ordernum = ($page ==1) ? 1 : 0; echo ($page-1) * Yii::app()->params['postnum'] + $key + $ordernum;?>楼</p-->
						</div>
						<div class="groupR postC" >
							<h5><cite>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo date('Y-m-d H:i:s',$value['dateline']);?></cite><a target="_blank" href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid));?>"><?php echo $value['username'];?></a></h5>
							<p>
							<?php if($value->del == 1):?>
							***** 此内容已被楼主或管理员屏蔽 *****
							<?php else:?>
							<?php echo  nl2br(CHtml::encode($value['content']));?>
							<?php endif;?>
							</p>
							<div class="ding_pl">
								<?php if(Yii::app()->user->id == $topic->uid || $this->_identidy >= 8):?>
								<a href="<?php echo $this->createUrl('group/del', array('postid'=>$value->postid));?>">删除</a>
								&nbsp;&nbsp;
								<?php endif;?>
								<!--a href="javascript:void(0);"  onclick="ding(<?=$value->postid?>);">顶</a>
								[<span class="ding_<?=$value->postid?>"><?php echo $value->likenum; ?></span>]-->
							</div>
						</div>
					</li>
					<?php } ?>
				</ul>
				<!--分页-->
				<div class="pages" style="clear:both;">
				
					<?php   
					$_pager = Yii::app()->params->pager;
					$_pager['pages'] = $pages;
					$this->widget('CLinkPager', $_pager);
					 /* 
			    $this->widget('CLinkPager',array(    
			        'header'=>'',    
			        'firstPageLabel' => '首页',    
			        'lastPageLabel' => '末页',    
			        'prevPageLabel' => '上一页',    
			        'nextPageLabel' => '下一页',    
			        'pages' => $pages,    
			        'maxButtonCount'=>10,
			        'cssFile'=>false,
			        )    
			    );*/
			    ?> 
				</div>
				<!--分页End-->
				<?php else: ?>
				<div>暂无回复</div>
				<?php endif;?>
			</div>

			<!--我的评论
			<div class="block" >
				<?php if(0): ?>
				<div class="my_comment">
					<span><em>加入小组</em>与12162人一起讨论"上班那些事儿"</span>
				</div>
				<?php else : ?>
				<form class="fatie" id="replyform" name="groupReply" method="post" action="<?php echo $this->createUrl('group/reply');?>">
					<input type="hidden" name="gid" value="<?php echo $topic->gid; ?>" />
					<input type="hidden" name="topicid" value="<?php echo $topic->topicid; ?>" />
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<td style="padding-bottom:0;"><textarea style="width:722px; height:120px;" name="content" id="textarea" cols="45" rows="5"></textarea></td>
						</tr>
						<tr>
							<td>验证码：<input style="width:80px; position:relative" type="text" name="verifyCode" size="12" id="" /><span class="image_code"><?php $this->widget('CCaptcha',array('clickableImage'=>true, 'buttonLabel'=>'点击更换')); ?></span></td>
						</tr>
						<tr>
							<td align="left"><input class=" btn_blue" type="button" name="button" id="submit" value="回&nbsp;&nbsp;复" /></td>
						</tr>
					</table>
				</form>
				<?php endif; ?>
				<div style="clear:both"></div>
			</div>-->
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// 提交按钮事件
		$('#submit').click(function(){
			ajaxpost("<?php echo $this->createUrl('/group/reply')?>" , $('#replyform').serialize() , function(result){
				window.location.reload();
			} , function(result){
				show_message('error' , result.msg);
			});
		});
		
		$('.image_code').find('img').css({'position':'relative','top':'20px'})
		$('input[name="verifyCode"]').focus(function(){
			$(window).keydown(function(e){
				if(e.keyCode==13){
				   $('#submit').click();
				   return false;
				}
			});		
		})
		
	})
	function ding(pid){
		var data = {
			'pid' : pid,
		}
		var url = "<?php echo $this->createUrl('group/like'); ?>";
		ajaxget(url , data , function(result){
			$('.ding_' + pid).html(parseInt($('.ding_' + pid).html())+1);

		} , function(result){
			show_message('error' , result.msg);
		});
	}
</script>