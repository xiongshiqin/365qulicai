<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--个人申请加入-->
		<div class="block fatie">
			<h3><i>个人申请加入</i></h3>
			<form class="backstage_input" style="margin-top:20px;"  name="joinForm" id="joinForm" method="post" action="<?php $this->createUrl('/business/join', array('bid'=>$service_info->bid))?>">
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
					<tr>
						<th width="10%">真实姓名：</th>
						<td><input type="text" name="realname" /></td>
						<td class="ico"valign="middle"></td>
					</tr>
					<tr>
						<th>手机号码：</th>
						<td><input type="text" name="mobile"/></td>
						<td class="ico"valign="middle"></td>
					</tr>
					<tr>
						<th>QQ号：</th>
						<td><input type="text" name="qq" /></td>
						<td class="ico"valign="middle"></td>
					</tr>
					<tr>
						<th>备注：</th>
						<td><input type="text" name="remark"/></td>
						<td class="ico"valign="middle"></td>
					</tr>
					<tr>
						<th>&nbsp;</th>
						<td>
						<input class="btn_blue" type="submit" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
						</td>
					</tr>
				</table>
			</form>
			<div class="clearboth"></div>
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
		$("#joinForm").validate({
			rules: {
				"realname": {
					required: true,
					minlength: 2,	
					maxlength: 8,
				},
				"qq": {
					required: true,
					minlength: 5,	
					maxlength: 12,
				},
				"mobile": {
					required: true,
					phoneNo: true,
				},
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});
</script>