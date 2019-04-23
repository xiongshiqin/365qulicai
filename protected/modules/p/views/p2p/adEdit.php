<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'ad', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected" href="">添加/编辑视频</a>		
				<a href="">返回添加/编辑</a>		
			</div>

			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="12%">视频标题：</th>
							<td width="88%"><input style="width:393px;" type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">视频源地址：</th>
							<td>
								<input style="width:393px;" type="text" name="textfield" id="textfield" />
								<div style="padding-top:8px;">
									<p class="quote" ><span style="grey">帮助：</span><a href="">怎么复制视频地址：</a></p>
									<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/demonstration_img.png" /></p>
								</div>

							</td>
						</tr>
						<tr>
							<th>排序：</th>
							<td>
								<input style="width:393px;" type="text" name="textfield" id="textfield" />
							</td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td><input class="btn_blue" type="submit" name="button" id="button" value="添&nbsp;&nbsp;&nbsp;&nbsp;加" /></td>
						</tr>
					</table>
				</form>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>