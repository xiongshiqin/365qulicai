<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<!--用户信息-->
		<?php $this->widget('HomeMenu', array(
			'_user'=> $this->_user,
			'_self'=> $this->_self,
			'selected' => 'inviteFriends'
		)); ?>

		<div class="mainarea eight">
			<!--邀请好友提示-->
			<div class="block">
				<h3><i>邀请好友</i></h3>
				<div class="invitation_text">
					<p>温馨提示：请不要发送邀请信给不熟悉的人士，避免给别人带来不必要的困扰。</p>
					<p>邀请一个好友，即可增加一个平台关注名额，并可获得相应积分</p>
				</div>
			</div>

			<!--邀请链接-->
			<div class="block copy_link quote">
				<form style="padding-left:18px;" action="">
					<label style="float:left; padding-top:6px;">邀请链接：</label>
					<input type="input" name="" value="<?php echo $url;?>" >
					<a href="">马上复制链接</a>
				</form>
			</div>

			<!--邀请用户-->
			<div class="invitation_text" style="padding-top:0;">
				<table cellspacing="0" cellpadding="0" width="100%" border="0">
					<tr>
						<th>用户名称</th>
						<th>注册时间</th>
					</tr>
					<?php foreach($invited as $v):?>
					<tr>
						<td>
							<a target="_blank" href="<?php echo $this->createUrl('/home/index',array('uid' => $v->inviteuid))?>">
								<?php echo $v->inviteusername;?>
							</a>
						</td>
						<td><?php echo date('Y-m-d H:i:s' , $v->dateline);?></td>
					</tr>
					<?php endforeach;?>
				</table>
			</div>
		</div>
	</div>
</div>