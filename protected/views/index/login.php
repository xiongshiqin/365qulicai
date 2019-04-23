<!--内容区-->
<div id="wrap">
	<div class="content">
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2>用户登录</h2>
				<div class="login_R">
					<p>您还没有帐号？</p>
					<p><a href="<?php echo $this->createUrl('/index/reg'); ?>" class="btn">>>马上注册</a></p>
					<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/login_img.png" /></p>
				</div>

				<div class="login_L">
					<div style="height:260px;">
						<?php if(Yii::app()->user->hasFlash('success')):?> 
							<div class="show-message"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
						<?php endif; ?> 
						<form id="login_form" method="post" action="<?php echo $this->createUrl('/index/login')?>" style="height:80px;">
							<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
								<tr>
									<td width="13%">用户名：</td>
									<td width="50%"><input style="width:240px;" type="text" name="LoginForm[username]" id="username" /></td>
									<td class="ico" width="37%" valign="middle"><?php echo Yii::app()->user->getFlash('username'); ?></td>
								</tr>
								<tr>
									<td>密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
									<td><input style="width:240px;" type="password" name="LoginForm[password]" id="password" /></td>
									<td><?php echo Yii::app()->user->getFlash('password'); ?></td>
								</tr>
								<tr>
									<td>验证码：</td>
									<td  class="code"><input style="width:80px;" type="text" name="LoginForm[verifyCode]" size="10" id="cap" />
									<?php $this->widget('CCaptcha' , array('clickableImage'=>true ,  'buttonLabel'=>'点击更换')); ?>
									</td>
									<td><?php echo Yii::app()->user->getFlash('verifyCode'); ?></td>
									</tr>
								<tr>
									<td></td>
									<td colspan="2"><input class="login_btn" type="submit" value="登&nbsp;&nbsp;&nbsp;&nbsp;录" /></td>
								</tr>	
							</table>
						</form>
					</div>
							
					<div class="hezuo_login">
						<!-- <p class="grey" style="font-size:16px;">使用合作网站帐号登录推广平台：</p> -->
						<p>
							<!-- <a href="">QQ登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;
							<a href="">微博登录</a>&nbsp;&nbsp;|&nbsp;&nbsp; -->
							<a style="color:#1c7abe;" href="<?php echo $this->createUrl('/index/forgetPwd')?>">忘记登录密码？找回密码</a>
						</p>
					</div>
				</div>
				<div style="clear:both;">&nbsp;</div>
			</div>
			<div class="login_bottom">&nbsp;</div>		
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#login_form").validate({ // 使用validate时记得给待验证的结构加上id，否则出现多个错误提示和提示不会消失
			rules: {
				"LoginForm[username]": {
					required: true,
					minlength: 2,	
					maxlength: 12,
				},
				"LoginForm[password]": {
					required:true,
					minlength:5,
					maxlength:16,
				},
				"LoginForm[verifyCode]":{
					required:true,
					remote:{
				                            url: "<?php echo $this->createUrl('/index/checkCaptcha');?>",
				                            type: "post",
				                            dataType: "json",
				                            data:{'cap': function(){ 
						  return $("#cap").val(); 
						}},
				                            cache: false,

					}
				}
			},
			messages: {
				"LoginForm[verifyCode]":{
					remote: "<img src='/html/images/tan.png' />验证码不正确",
				}
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});
</script>