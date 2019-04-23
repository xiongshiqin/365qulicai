
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<div class="sideL">
			<!--左导航-->
			<div class="block" >
				<dl class="message_center" style="min-height:210px;">
					<dt>消息中心</dt>
					<dd><a href="<?php echo $this->createUrl('/home/msgList')?>">系统通知</a></dd>
					<dd  class="selected"><a href="<?php echo $this->createUrl('/home/talkList')?>">我的私信</a></dd>
				</dl>
			</div>
			
		</div>

		<div class="mainarea eight">
			<!--我的私信-->
			<div class="block activities user_post">
				<h3>
					<i>我的私信<small class="grey">&nbsp;(<?php echo $this->_user->count->talknum;?>条未读)</small></i>
				</h3>
				
				<!--更多-->
			<!-- 	<div class="more more1">
					<a href="">更多对话信息</a>
				</div> -->

				<input type="hidden" value="0" id="talkpage"/>
				<ul class="group my_sixin">
					<?php foreach($talks as $v):?>
						<?php
							$uid = $v->uid;
							$username = $v->username;
							$num = $v->fnum;
							if($v->uid == Yii::app()->user->id){
								$uid = $v->fuid;
								$username = $v->fusername;
								$num = $v->num;
							}
						?>
						<li class="review ">
							<div class="groupL">
								<a href="<?php echo $this->createUrl('/home/index' , array('uid' => $uid));?>">
									<img src="<?php echo HComm::avatar($uid, 'm'); ?>" />
								</a>
							</div>
							<div class="groupR postC">
								<h5>
									<cite><?php echo date('Y-m-d H:i:s' , $v->lastreply);?></cite>
									<a href="<?php echo $this->createUrl('/home/writeTalk' , array('fuid' => $uid));?>"><?php echo $username?></a>
								</h5>
								<p>
									<?php echo $v->content;?>
									<span class="quote"><a href="<?php echo $this->createUrl('/home/writeTalk' , array('fuid' => $uid));?>">详细内容&gt;</a></span> 
								</p>
								<p>
									<cite class="has_read">
										<?php if($num > 0):?>
											<a style="cursor:pointer;"  onclick="ignoreTalk(<?php echo $v->talkid?>)" >设为己读</a>
										<?php endif;?>
										<a <?php if($num > 0) echo ' style="font-weight:bold;" '?> href="<?php echo $this->createUrl('/home/writeTalk' , array('fuid' => $uid));?>">
											<span>共<i><?php echo $v->total?></i>条私信</span>
											<span><i class="talk_<?php echo $v->talkid?>"><?php echo $num;?></i>条新回复</span>
										</a>
									</cite>
									&nbsp;
								</p>
							</div>
						</li>
					<?php endforeach;?>
				</ul>

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
	// 设为已读
	function ignoreTalk(talkid){
		var url = '<?php echo $this->createUrl("/home/ignoreTalk");?>';
		var data = {
			'talkid' : talkid,
		};
		ajaxpost(url,data,function(result){
			// $('.talk_' + talkid).html('0');
			window.location.reload();
		},function(result){
			show_message('error' , result.msg);
		});
	}
</script>