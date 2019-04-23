<!--内容区-->
<div id="wrap">
	<div class="content">
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2>平台申请入驻</h2>
				<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=438439984&site=qq&menu=yes">
				<img border="0" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/qq.jpg" alt="理财派客服" title="理财派客服"/>						
				<span style="position:relative;top:-3px;left:-3px;">365趣理财客服</span></a>
				<span style="position:relative;top:-3px;left:-1px; font-size:12px;">331256045</span>
				<div class="login_R" style="width:228px"></div>

				<div class="login_L" style="border:0; width:554px">
					<form id="applyForm" method="post" action="<?php echo $this->createUrl('/p2p/apply');?>">
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
								<td width="22%" align="right">平台名称：</td>
								<td width="43"><input style="width:224px;" type="text" name="name" id="name"/></td>
								<td class="ico" width="35%" valign="middle"></td>
							</tr>
							<tr>
								<td align="right">网站地址：</td>
								<td><input style="width:224px;" type="text" name="siteurl" id="siteurl"/></td>
								<td class="ico"></td>
							</tr>
							<tr class="fatie">
								<td align="right">所在地：</td>
								<td>
									<?php
										$this->widget('City' , array(
										));
									?>
								</td>
								<td class="ico"></td>
							</tr>
							<!-- <tr>
								<td align="right">详细地址：</td>
								<td><input style="width:224px;" type="text" name="address"/></td>
								<td class="ico"valign="middle"><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/tan.png" />请输入您的详细地址</td>
							</tr>-->
							<tr>
								<td align="right">运营总监姓名：</td>
								<td><input style="width:224px;" type="text" name="operation_name"/></td>
								<td class="ico" valign="middle"></td>
							</tr>
							<tr>
								<td align="right">运营总监手机：</td>
								<td><input style="width:224px;" type="text" name="operation_mobile"/></td>
								<td class="ico"valign="middle"></td>
							</tr>
							<tr>
								<td align="right">上线时间：</td>
								<td>
									<?php 
										$this->widget('application.extensions.timepicker.timepicker', array(
										    'name'=>'onlinetime',
										    'value'=> time(),
										    'options' => array(
										    	'showSecond' =>false,
										    	'showHour' => false,
										    	'showMinute' => false,
										    	),
										));
									?>
								</td>
							</tr>
							<span>
							<tr>
								<td align="right">邀请码：</td>
								<td><input style="width:224px;" type="text" name="invite" value="<?=$code?>"/></td>
								<td class="ico"valign="middle"></td>
							</tr>
							<tr>
								<td style="line-height:14px; padding-bottom:15px;">&nbsp;</td>
								<td colspan="2" class="grey" style="font-size:12px; line-height:14px; padding-bottom:15px;">邀请码请联系平台</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input class="login_btn" type="submit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" /></td>
							</tr>	
							</span>
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
	$(function(){
		$.validator.addMethod("phoneNo", function (value, element) {
		            var length = value.length;
		            // var regex = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
		           var regex = /^1+([2|3|4|5|6|7|8|9]{1})+([0-9]{1})+\d{8}$/;   
		            return this.optional(element) || (length == 11 && regex.test(value));
	        	}, "<img src='/html/images/tan.png' />手机号码格式错误");
		// 表单验证
		$("#applyForm").validate({
			rules: {
				"name": {
					required:true,
				},
				"siteurl":{
					required:true,
					url : true,
					remote:{
						url: "<?php echo $this->createUrl('/ajax/p2pIsExists');?>",
						type: "post",
						dataType: "json",
						data:{
							'name': function(){  
								return $("#name").val(); 
							},
							'siteurl': function(){
								return $('#siteurl').val();
							},
						},
					},
				},
				"operation_name":{
					required:true,
				},
				"operation_mobile":{
					required:true,
					phoneNo:true,
				},
				"invite":{
					required:true,
				},
			},
			messages :{
				'siteurl' : {
					remote : "<img src='/html/images/tan.png' />平台已存在",
				}
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});	
</script>