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
				<a class="selected" href="">宣传相册</a>		
				<a href="">证件图片</a>	
				<a href="">添加图片</a>		
			</div>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="12%">图片标题：</th>
							<td width="88%">
								<input type="text" name="textfield" id="textfield" />
								<input class="upload" type="submit" name="button" id="button" value="上传图片" />
							</td>
						</tr>
						<tr>
							<th>类型：</th>
							<td>
								<select style="width:240px;" name="select" id="select">
									<option>等额本息</option>
									<option>先息后本（按月付息、到期还本）</option>
									<option>次性还本付息</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td>
							<input class="btn_blue" type="submit" name="button" id="button" value="上传图片" />
							</td>
						</tr>
					</table>
				</form>

				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
