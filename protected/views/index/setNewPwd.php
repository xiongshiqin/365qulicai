<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--找回密码-->
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2>设置新密码</h2>
				<div class="login_R" style="width:228px"></div>

				<div class="login_L password" style="border:0; width:554px">
					<form id="forgetPwdForm" name="forgetPwdForm" method="post" action="<?php echo $this->createUrl('/index/setNewPwd')?>">
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
								<td width="17%" align="right">用户名：</td>
								<td width="58%">
									<input type="hidden" name="secret" value="<?=$secret?>"/>
									<span><?=$username?></span>
								</td>
								<td class="ico" valign="middle"><?php echo Yii::app()->user->getFlash('mobile'); ?></td>
							</tr>
							<tr>
								<td align="right">密&nbsp;&nbsp;&nbsp;&nbsp;码：</td>
								<td><input style="width:224px;" type="password" name="password" id="password" /></td>
								<td class="ico"></td>
							</tr>
							<tr>
								<td align="right">确认密码：</td>
								<td><input style="width:224px;" type="password" name="password_repeat" id="password_repeat" /></td>
								<td class="ico"></td>
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
		// 验证框架使用方法 需要name
		$("#forgetPwdForm").validate({
			rules: {
				"password": {
					required:true,
					minlength:5,
					maxlength:16,
				},
				"password_repeat":{
					required:true,
					equalTo: "#password",
				},
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});
</script>