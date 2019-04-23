<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--找回密码-->
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2>找回密码</h2>
				<div class="login_R" style="width:228px"></div>

				<div class="login_L password" style="border:0; width:554px">
					<form id="forgetPwdForm" name="forgetPwdForm" method="post" action="">
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
								<td width="17%" align="right">手机号码：</td>
								<td width="58%">
									<input class="grey" type="text" name="mobile" id="mobile" placeholder="注册时填写的手机号码" />
								</td>
								<td class="ico" valign="middle"><?php echo Yii::app()->user->getFlash('mobile'); ?></td>
							</tr>
							<tr>
								<td align="right">验证码：</td>
								<td  class="code"><input style="width:90px;" type="text" name="verifyCode" size="10" id="cap" />
									<?php $this->widget('CCaptcha' , array('clickableImage'=>true ,  'buttonLabel'=>'点击更换')); ?>
								</td>
								<td class="ico" valign="middle"></td>
							</tr>
							<tr>
								<td align="right">手机验证码：</td>
								<td>
									<input style="width:155px;" class="grey" type="text" name="mobile_code" id="mobile_code" placeholder="请输入收到的验证码" />
									<a data-action="getSMSCode" id="getSMSCode" href="javascript:void(0)" class="obtain">获取短信</a>
								</td>
								<td class="ico" valign="middle"><?php echo Yii::app()->user->getFlash('mobile_code'); ?></td>
							</tr>
							<tr class="fatie">
								<td></td>
								<td><input class="btn_blue" type="submit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" /></td>
							</tr>	
						</table>
					</form>
					
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
		$("#forgetPwdForm").validate({
			rules: {
				"mobile":{
					required:true,
					phoneNo:true, //自定义方法
					remote:{
						url: "<?php echo $this->createUrl('/ajax/checkPhoneIsExists');?>",
						type: "post",
						dataType: "json",
						data:{'telephone': function(){  
							return $("#mobile").val(); 
						}},
					},
				},
				"verifyCode":{
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
				"mobile_code":{
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
			},
			messages: {
				"mobile":{
					remote: "<img src='/html/images/tan.png' />该手机号不存在",
				},
				"verifyCode":{
					remote: "<img src='/html/images/tan.png' />验证码不正确",
				},
				"mobile_code":{
					remote: "<img src='/html/images/tan.png' />短信验证码不正确",
				},
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});
</script>