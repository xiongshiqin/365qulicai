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
				<?php if(($emp = CompanyEmployee::model()->find("cpid = $cpid and uid = " . Yii::app()->user->id)) && $emp->isadmin == 1):?>
					<a href="<?php echo $this->createUrl('/p/p2p/employee',array('cpid'=>$cpid));?>">员工列表</a>
				<?php endif;?>
				<a href="<?php echo $this->createUrl('/p/p2p/service',array('cpid'=>$cpid));?>">客服列表</a>		
				<a class="selected" href="<?php echo $this->createUrl('/p/p2p/serviceEdit',array('cpid'=>$cpid));?>">添加/编辑客服</a>		
			</div>

			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="12%">客服名称：</th>
							<td width="88%"><input type="text" name="nickname" value="<?php echo $service->nickname;?>"/></td>
						</tr>
						<tr>
							<th>客服QQ：</th>
							<td><input type="text" name="qq" value="<?php echo $service->qq;?>"/></td>
						</tr>
						<tr>
							<th>客服QQ：</th>
							<td>
								<input style="width:14px; height:14px;" type="radio" <?php if($service->status == 1) echo "checked='checked'";?> name="status" value="1"/>
								<label>启用</label>
								<input style="width:14px; height:14px;" type="radio" <?php if($service->status == 0) echo "checked='checked'";?>name="status" value="0"/>
								<label>停用</label>
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
