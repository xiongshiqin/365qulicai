<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<div class="sideL">
			<!--左导航-->
			<div class="block" >
				<dl class="message_center" style="min-height:210px;">
					<dt>消息中心</dt>
					<dd class="selected"><a href="<?php echo $this->createUrl('/home/msgList')?>">系统通知</a></dd>
					<dd><a href="<?php echo $this->createUrl('/home/talkList')?>">我的私信</a></dd>
				</dl>
			</div>
			
		</div>

		<div class="mainarea eight">
			<!--系统消息-->
			<div class="block activities user_post">
				<h3>
					<cite class="allfafang ie6">
						<a onclick="allRead()">
							<img style="wdith:10px; height:10px;" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/gou1.png" />
							全部标记己读
						</a>
					</cite>
					<i>系统消息<small class="grey">&nbsp;(<?php echo $this->_user->count->message;?>条未读)</small></i>
				</h3>
				
				<table class="system_news" width="100%" border="0" cellpadding="0" cellspacing="0">
					<?php foreach($msgs as $v):?>
						<tr class="<?php echo $v->isview? '' : 'selected';?>">
							<td><a href="<?php echo $this->createUrl('/home/msgDetail' , array('mid' => $v->mid));?>"><?php echo $v->subject;?></a></td>
							<td width="13%" class="grey"><?php echo date('Y-m-d' , $v->dateline);?></td>
						</tr>
					<?php endforeach;?>
					
				</table>

				<!--分页-->
				<div class="pages clearboth">
					<ul class="pagelist">
						<?php   
							$_pager = Yii::app()->params->pager;
							$_pager['pages'] = $pages;
							$this->widget('CLinkPager', $_pager);
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	// 全部设为已读
	function allRead(){
		ajaxget('<?php echo $this->createUrl("/home/msgAllRead");?>' , '' , function(){
			window.location.reload();
		} , function(result){
			show_message('error' , result.msg);
		});
	}
</script>