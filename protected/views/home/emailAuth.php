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
					<li class="selected_li"><a href="<?php echo $this->createUrl('/home/emailAuth')?>">邮箱验证</a></li>
				</ul>
				<div class="tab_content clearboth">
					<!--密码修改-->
					<div >
						<?php $auth = AuthApply::model()->find("uid = " . $this->_user->uid);?> 
						<form class="backstage_input" id="emailAuthForm"  method="post" action="">
							<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
								<tr>
									<th width="12%">邮箱：</th>
									<td width="50%"><input type="text" id="email" name="email" value="<?php echo Member::model()->findByPk(Yii::app()->user->id)->email;?>"/></td>
									<td class="ico" valign="middle"></td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
									<input class="btn_blue" type="submit" value="发送邮件" />
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// 验证框架使用方法 需要name
		$("#emailAuthForm").validate({
			rules: {
				"email" : {
					required:true,
					email:true,
					// remote:{
					// 	url: "<?php echo $this->createUrl('/ajax/checkEmail');?>",
					// 	type: "post",
					// 	dataType: "json",
					// 	data:{'email': function(){  // 此处data不能写成$('#xx').val(), 要动态读取
					// 		return $("#email").val(); 
					// 	}},
				 //                            cache: false,
					// }
				},
			},
			messages: {
				// "email" : {
				// 	remote : "<img src='/html/images/tan.png' />邮箱已存在",
				// },
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});
</script>