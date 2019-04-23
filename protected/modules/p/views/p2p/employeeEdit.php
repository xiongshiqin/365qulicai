<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'service', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a href="<?php echo $this->createUrl('/p/p2p/employee',array('cpid'=>$cpid));?>">员工列表</a>	
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/service',array('cpid'=>$cpid));?>">客服列表</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/serviceEdit',array('cpid'=>$cpid));?>">添加客服</a>		
			</div>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th>真实姓名：</th>
							<td><input type="text" name="realname" value="<?php echo $employee->realname;?>"/></td>
						</tr>
						<tr>
							<th>部门</th>
							<td>
								<select id="department" name="department">
								 	<?php foreach(Yii::app()->params['department'] as $k=>$v):?>
								 		<option value="<?php echo $k?>"><?php echo $v;?></option>
								 	<?php endforeach;?>
								</select>
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
<script>
	$(document).ready(function(){
		$('#department').val("<?php echo $employee->department;?>");
	});
</script>