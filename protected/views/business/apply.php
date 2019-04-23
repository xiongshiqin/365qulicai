<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--第三方支付申请入驻-->
		<div class="block fatie">
			<h3><i>第三方支付申请入驻</i></h3>
			<form class="backstage_input" style="margin-top:20px;"  id="form1" name="form1" method="post" action="<?php echo $this->createUrl('business/apply');?>">
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
					<tr>
						<th width="13%">支付名称：</th>
						<td><input type="text" name="shortname" values="" /></td>
					</tr>
					<tr>
						<th>公司名称：</th>
						<td><input type="text" name="name" values="" /></td>
					</tr>
					<tr>
						<th>公司网址：</th>
						<td><input type="text" name="siteurl" values="" /></td>
					</tr>
					<tr>
						<th>公司地址：</th>
						<td><input type="text" name="address" values="" /></td>
					</tr>
					<tr>
						<th>申请人姓名：</th>
						<td><input type="text" name="realname" values="" /></td>
					</tr>
					<tr>
						<th>申请人手机：</th>
						<td><input type="text" name="mobile" values="" /></td>
					</tr>
					<tr>
						<th>验证码：</th>
						<td><input type="text" name="verifyCode" size="10" id="" /><?php $this->widget('CCaptcha' , array('clickableImage'=>true ,  'buttonLabel'=>'点击更换')); ?></td>
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