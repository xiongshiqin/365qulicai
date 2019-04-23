<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position">
			<h4>创建小组</h4>
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--右边-->
			<div class="block">
			&nbsp;
			</div>
		</div>

		<div class="mainarea">
			<!--发贴-->
			<div class="block fatie">
				<form id="groupCreateForm" name="groupCreateForm" method="post" action="<?php echo $this->createUrl('group/create'); ?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<td width="8%" >名称：</td>
							<td width="92%"><input style="width:664px;" type="text" name="name" id="textfield" /></td>
						</tr>
						<tr>
							<td valign="top">介绍：</td>
							<td><textarea style="height:140px;" name="info" id="info" cols="45" rows="5"></textarea></td>
						</tr>
						
						
						<!--tr>
							<td>分类：</td>
							<td>
								<select name="class" id="class">
									<option value="0">请选择分类</option>
									<option value="1">1</option>
									<option value="">2</option>
								</select>
							</td>
						</tr-->
						<tr>
							<td>验证码：</td>
							<td><input style="width:90px;" type="text" name="verifyCode" size="10" id="" />
							<?php $this->widget('CCaptcha' , array('clickableImage'=>true ,  'buttonLabel'=>'点击更换')); ?>
							</td>
						</tr>
						<!--tr>
							<td>图标：</td>
							<td><input style="width:210px; height:30px; line-height:30px; font-size:12px; padding:0 4px;" type="file" name="fileField" id="fileField2" /><span>&nbsp;&nbsp;<em>*</em>仅支持jpg,gif,png格式图片</span></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<th class="quote" align="left"><input style="border:0; width:15px;" type="checkbox" name="agree" id="checkbox" value="1" />我己认真阅读并同意<a href="">《社区指导原则》</a>和<a href="">《免责声明》</a></th>
						</tr-->						
						<tr>
							<td>&nbsp;</td>
							<td><input class="btn_blue" type="submit" name="create" id="button" value="创建小组" /></td>
						</tr>
					</table>
				</form>
				<div style="clear:both;"></div>
			</div>

		</div>
	</div>
</div>
