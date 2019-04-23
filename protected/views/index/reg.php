<!--内容区-->
<div id="wrap">
	<div class="content">
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2>用户注册</h2>
				<div class="login_R">
					<p>己有帐号，去登陆</p>
					<p><a href="<?php echo $this->createUrl('/index/login'); ?>" class="btn">>>立即登陆</a></p>
					<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/regis_img.png" /></p>
				</div>

				<div class="login_L">
					<div style="height:455px;">
				                    <?php if(Yii::app()->user->hasFlash('success')):?> 
				                   	 <div class="show-message"> <?php echo Yii::app()->user->getFlash('success'); ?></div>
				                    <?php elseif (Yii::app()->user->hasFlash('error')):?>
					                    <div class="show-message"> 
					                        <?php 
					                        	$errors = Yii::app()->user->getFlash('error');
					                        	if(is_array($errors)){
						                        	foreach ($errors as $value) {
							                            echo '<p>'.$value[0].'</p>';
							                        } 
					                        	} else {
					                        		echo $errors;
					                        	}
					                        ?>
					                    </div>
				                    <?php endif; ?>   
                    
					<form id="reg_form" name="reg_form" method="post" action="<?php echo $this->createUrl('index/reg'); ?>" style="height:80px;">
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
								<td width="18%" align="right">用户名：</td>
								<td width="50"><input style="width:224px;" type="text" name="RegForm[username]" id="username" /></td>
								<td class="ico" width="32%" valign="middle"></td>
							</tr>
							<tr>
								<td align="right">邮箱：</td>
								<td><input style="width:224px;" type="text" name="RegForm[email]" id="email" /></td>
								<td class="ico"valign="middle"></td>
							</tr>
							<tr>
								<td align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
								<td><input style="width:224px;" type="password" name="RegForm[password]" id="password" /></td>
								<td class="ico"></td>
							</tr>
							<tr>
								<td align="right">确认密码：</td>
								<td><input style="width:224px;" type="password" name="RegForm[password_repeat]" id="password_repeat" /></td>
								<td class="ico"></td>
							</tr>
							<tr>
								<td align="right">手机号码：</td>
								<td><input style="width:224px;" type="text" name="RegForm[mobile]" id="mobile" /></td>
								<td class="ico"valign="middle"></td>
							</tr>
							<tr>
								<td align="right">验证码：</td>
								<td  class="code"><input style="width:90px;" type="text" name="RegForm[verifyCode]" size="10" id="cap" />
									<?php $this->widget('CCaptcha' , array('clickableImage'=>true ,  'buttonLabel'=>'点击更换')); ?>
								</td>
								<td class="ico" valign="middle"></td>
							</tr>
							<tr>
								<td align="right">手机验证码：</td>
								<td>
									<input style="width:90px;" type="text" name="RegForm[mobile_code]" id="mobile_code" />
									<a class="obtain" href="javascript:void(0)" id="getSMSCode" data-action="getSMSCode">获取短信</a>
								</td>
								<td class="ico" valign="middle"><?php echo Yii::app()->user->getFlash('inviteCode'); ?></td>
							</tr>
							<tr style="display:none;">
								<td align="right">注册邀请码：</td>
								<td><input style="width:130px;" type="text" value="<?=$code?>" name="RegForm[inviteCode]" id="inviteCode" /></td>
								<td class="ico" valign="middle">
									<?php echo Yii::app()->user->getFlash('inviteCode'); ?>
									如通过邀请链接注册可不填此项
								</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input class="login_btn" type="submit" value="注&nbsp;&nbsp;&nbsp;&nbsp;册" /></td>
							</tr>	
						</table>
					</form>
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
		$.validator.addMethod("phoneNo", function (value, element) {
		            var length = value.length;
		            // var regex = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
		            var regex = /^1+([2|3|4|5|6|7|8|9]{1})+([0-9]{1})+\d{8}$/;  
		            return this.optional(element) || (length == 11 && regex.test(value));
	        	}, "<img src='/html/images/tan.png' />手机号码格式错误");
		// 验证框架使用方法 需要name
		$("#reg_form").validate({
			rules: {
				"RegForm[username]": {
					required: true,
					minlength: 2,	
					maxlength: 12,
					remote:{
						url: "<?php echo $this->createUrl('/ajax/checkUsername');?>",
						type: "post",
						dataType: "json",
						data:{'username': function(){  
							return $("#username").val(); 
						}},
					},
				},
				"RegForm[password]": {
					required:true,
					minlength:5,
					maxlength:16,
				},
				"RegForm[password_repeat]":{
					required:true,
					equalTo: "#password",
				},
				"RegForm[email]" : {
					required:true,
					email:true,
					remote:{
						url: "<?php echo $this->createUrl('/ajax/checkEmail');?>",
						type: "post",
						dataType: "json",
						data:{'email': function(){  // 此处data不能写成$('#xx').val(), 要动态读取
							return $("#email").val(); 
						}},
				                            cache: false,
					}
				},
				"RegForm[mobile]":{
					required:true,
					phoneNo:true, //自定义方法
					remote:{
						url: "<?php echo $this->createUrl('/ajax/checkPhone');?>",
						type: "post",
						dataType: "json",
						data:{'telephone': function(){  
							return $("#mobile").val(); 
						}},
					},
				},
				"RegForm[verifyCode]":{
					required:true,
					remote:{
						url: "<?php echo $this->createUrl('/index/checkCaptcha');?>",
						type: "post",
						dataType: "json",
						data:{'cap': function(){  // 此处data不能写成$('#xx').val(), 要动态读取
							return $("#cap").val(); 
						}},
				                            cache: false,
					}
				},
				"RegForm[mobile_code]":{
					required:true,
					remote:{
						url: "<?php echo $this->createUrl('/ajax/checkSms');?>",
						type: "post",
						dataType: "json",
						data: {
							'telephone': function(){
								return $('#mobile').val();
							},
							'sms' : function(){
								return $('#mobile_code').val();
							}
						}
					},
				},
				// "RegForm[inviteCode]":{
				// 	required:true,
				// 	remote:{
				// 		url: "<?php echo $this->createUrl('/ajax/checkInviteCode');?>",
				// 		type: "post",
				// 		dataType: "json",
				// 		data: {
				// 			'inviteCode': function(){
				// 				return $('#inviteCode').val();
				// 			},
				// 		}
				// 	},
				// },
			},
			messages: {
				"RegForm[username]":{
					remote: "<img src='/html/images/gang.png' />帐号已存在",
				},
				"RegForm[email]" : {
					remote : "<img src='/html/images/tan.png' />邮箱已存在",
				},
				"RegForm[mobile]":{
					remote: "<img src='/html/images/tan.png' />该手机号已经被使用",
				},
				"RegForm[verifyCode]":{
					remote: "<img src='/html/images/tan.png' />验证码不正确",
				},
				"RegForm[mobile_code]":{
					remote: "<img src='/html/images/tan.png' />短信验证码不正确",
				},
				// "RegForm[inviteCode]":{
				// 	remote: "<img src='/html/images/tan.png' />邀请码有误",
				// }
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});
</script>