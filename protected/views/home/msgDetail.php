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
			<div class="block">
				<h3><i>系统消息</i></h3>
				<div class="user_xinxi introduce" >
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>	
							<th width="6%">标题：</th>
							<td style="font-size:18px;"><?php echo $msg->subject?></td>
						</tr>
						<tr>	
							<th>时间：</th>
							<td><?php echo date('Y-m-d H:i:s' , $msg->dateline);?></td>
						</tr>
						<tr>	
							<th valign="top">内容：</th>
							<td style="padding-top:6px;">
								<?php echo $msg->content;?>
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
