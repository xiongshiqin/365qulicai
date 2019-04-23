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
					<?php if($this->_user->realstatus != 2):?>
						<li><a href="<?php echo $this->createUrl('/home/realnameAuth')?>">实名认证</a></li>
					<?php endif;?>
					<?php if($this->_user->emailstatus != 1):?>
						<li><a href="<?php echo $this->createUrl('/home/emailAuth')?>">邮箱验证</a></li>
					<?php endif;?>
				</ul>
				<div class="tab_content clearboth">
					<?php 
					switch($tab){ 
					case 'base_info':?>
						<!--基本信息-->
						<div>
							<form class="backstage_input" id="baseinfo" method="post" action="">
								<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
									<input type="hidden" name="tab" value="base_info"/>
									<tr>
										<th width="12%">昵称：</th>
										<td><input value="<?php echo $member->username?>" style="border:0;" type="text" name="username" /></td>
									</tr>
									<tr>
										<th>所在地：</th>
										<td>
											<?php
												$this->widget('City' , array(
													'model' => $member->info,
													'provinceidname' => 'provinceid',
													'cityidname' => 'residecityid',
												));
											?>
										</td>
									</tr>
									<tr>
										<th>性别：</th>
										<td>
											<input style="width:14px; height:14px; border:0;" class="gender_0" type="radio" value="0" name="gender" />
											<label>保密</label>
											<input style="width:14px; height:14px; border:0;" class="gender_1" type="radio" value="1" name="gender" />
											<label>男</label>
											<input style="width:14px; height:14px; border:0;" class="gender_2" type="radio" value="2" name="gender" />
											<label>女</label>
										</td>
									</tr>
									<tr>
										<th>&nbsp;</th>
										<td>
										<input class="btn_blue" type="button" id="baseInfoSubmit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
										</td>
									</tr>
								</table>
							</form>
							<script>
							(function($){	
								// 初始化性别
								$('.gender_<?php echo $member->info->gender?>').attr('checked','checked');
								// 提交事件
								$('#baseInfoSubmit').click(function(){
									$.ajax({
										cache: true,
										type: "POST",
										url:'',
										dataType: 'json',
										data:$('#baseinfo').serialize(),// 你的formid
										async: false,
										error: function(result) {
											show_message('error' , '服务器忙');
										},
										success: function(result) {
											if(result.status == !0){
												show_message('success' , result.msg);
											}else {
												show_message('error' , result.msg);
											}
										}
									});
								});
							})(jQuery)
							</script>
						</div>

					<?php break; case 'modify_avatar' :?>
						<!--修改头像-->
						<div class="w800 fr">
							<!-- <span style="display:none">
								<img src="<?php echo HComm::avatarpath(Yii::app()->user->id, 'm');?>" id="hideImg" onload="getUserImg()" onerror="">
							</span> -->

							<div class="info-main">
								<p class="help">上传一张图片作为自己的个人头像。上传完成后，请<span class="c-red">刷新</span>页面显示新头像</p>								
								<p><img src="<?php echo HComm::avatar(Yii::app()->user->id, 'm'); ?>" id="userImage"/></p>								
								<?php echo $urlCameraFlash; ?>
							</div>

						</div>
						<script type="text/javascript">
							//写一个定时刷新获取图片的js
							var currentImg = $('#userImage').attr('src');
															
							function timeCount(){
								$.get('', {autoFreshImg: true}, function ( result ){
									//alert(result);
									$('#userImage').attr('src', result+"?t="+Math.random());
								})								
								setTimeout('timeCount()',1000);								
							}

							function timeCount1(){
								$('#userImage').attr('src', currentImg+"?t="+Math.random());
								setTimeout('timeCount1()',1000);	
							}

							//如果是系统默认图像则不断地发起请求
							if (currentImg == '/images/avatar_m.jpg'){
								timeCount();
							//否则直接在图片后面加上随机数
							}else{
								timeCount1();
							}							

						</script>


					<?php break; case 'modify_pwd' :?>
						<!--密码修改-->
						<div >
							<form class="backstage_input" id="modifypwd"  method="post" action="">
								<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
									<input type="hidden" name="tab" value="modify_pwd"/>
									<tr>
										<th width="12%">当前密码：</th>
										<td><input type="password" name="oldPwd" id="curPwd" /></td>
										<td><span class="oldPwdErr" style="display:none;"><font color="red">当前密码错误</font></span></td>
									</tr>
									<tr>
										<th>设置新密码：</th>
										<td><input type="password" name="newPwd" id="newPwd" /></td>
										<td><span class="newPwdErr" style="display:none;"><font color="red">密码的长度必须大于5小于16</font></span></td>
									</tr>
									<tr>
										<th>确认密码：</th>
										<td><input type="password" name="checkPwd" id="checkPwd" /></td>
										<td><span class="checkPwdErr" style="display:none;"><font color="red">两次输入的密码不一样</font></span></td>
									</tr>
									<tr>
										<th>&nbsp;</th>
										<td>
										<input class="btn_blue" type="button" id="modifyPwdSubmit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
										</td>
									</tr>
								</table>
							</form>
						</div>
						<script>
						(function($){
							// 提交事件
							$('#modifyPwdSubmit').click(function(){
								$('.oldPwdErr , .newPwdErr , .checkPwdErr').hide();
								$.ajax({
									cache: true,
									type: "POST",
									url:'',
									dataType: 'json',
									data:$('#modifypwd').serialize(),// 你的formid
									async: false,

									error: function(result) {
										show_message('error' , '服务器忙');
									},
									success: function(result) {
										if(result.status == !0){
											show_message('success' , result.msg);
										}else {
											$('.' + result.msg + "Err").show();
										}
									}
								});
							});
						}(jQuery))
						</script>
					<?php break; }?>
				</div>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// 初始化选项卡
		$('.<?php echo $tab;?>').addClass('selected_li');
	});
</script>
