<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--基本信息-->
		<div class="block fatie">
			<div class="tab usertab">
				<ul class="tab_menu">
					<li class="base_info"><a href="<?php echo $this->createUrl('/home/myProfile' , array('tab'=>'base_info'))?>">基本信息</a></li>
					<li class="modify_avatar"><a href="<?php echo $this->createUrl('/home/avatar')?>">修改头像</a></li>
					<li class="modify_pwd"><a href="<?php echo $this->createUrl('/home/myProfile' , array('tab'=>'modify_pwd'))?>">密码修改</a></li>
					<li class="selected_li"><a href="<?php echo $this->createUrl('/home/realnameAuth')?>">实名认证</a></li>
					<?php if($this->_user->emailstatus != 1):?>
						<li><a href="<?php echo $this->createUrl('/home/emailAuth')?>">邮箱验证</a></li>
					<?php endif;?>
				</ul>
				<div class="tab_content clearboth">
					<!--密码修改-->
					<div >
						<?php $auth = AuthApply::model()->find("uid = " . $this->_user->uid);?> 
						<?php if($auth && $auth->status ==0):?>
							实名认证审核中。。。
						<?php elseif(!$auth):?>
							<form class="backstage_input" id="modifypwd"  method="post" action="">
								<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
									<input type="hidden" name="tab" value="modify_pwd"/>
									<tr>
										<th width="12%">真实姓名：</th>
										<td><input type="text" name="realname" /></td>
										<td></td>
									</tr>
									<tr>
										<th>身份说明：</th>
										<td><input type="text" placeholder="某某公司CEO" name="job"/></td>
										<td></td>
									</tr>
									<tr>
										<th>申请说明：</th>
										<td><input type="text" name="remark"/></td>
										<td></td>
									</tr>
									<tr>
										<th>&nbsp;</th>
										<td>
										<input class="btn_blue" type="submit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
										</td>
									</tr>
								</table>
							</form>
						<?php else:?>
							您已完成实名认证
						<?php endif;?>
					</div>
				</div>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
