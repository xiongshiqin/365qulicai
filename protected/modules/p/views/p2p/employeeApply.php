<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'employee', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected" href="">员工列表</a>		
				<a href="">审核申请</a>	
			</div>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="12%">会员名称：</th>
							<td width="88%"><input style="border:0;" value="小红" type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>所属部门：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>真实姓名：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>可管理后台：</th>
							<td>
								<input style="width:14px; height:14px; border:0;" checked="checked" id="" type="radio" value="" name="radio" />
								<label>否</label>
								<input style="width:14px; height:14px; border:0;" id="" type="radio" value="" name="radio" />
								<label>是</label>
							</td>
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
</div>
