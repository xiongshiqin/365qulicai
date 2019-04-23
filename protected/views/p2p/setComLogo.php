<?php $this->widget('ext.kindeditor.KindEditorWidget'); ?>
<!--内容区-->
<div id="wrap">
	<div class="content">
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2>设置平台Logo</h2>
				<div class="login_R" style="width:228px"></div>
				<div class="login_L" style="border:0; width:554px">
					<form id="form1" name="form1" method="post" action="">
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
							<input type="hidden" name="cpid" value="<?php echo $cpid;?>"/>
							<tr>
								<th valign="top" style="padding-top:12px;">LOGO：</th>
								<td>
									<img id="logo" src="<?php echo HComm::get_com_dir($cpid);?>"/>
									<input class="upload_img" type="button" id="logoUp" value="选择图片" />
									<font color="red">图片大小比例最好为 200*60</font>
								</td>
							</tr>
							<tr>
								<td></td>
								<td colspan="2"><input class="login_btn" type="submit" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" /></td>
							</tr>	
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
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
			// 如果上传的为公司logo  则增加 isCom : 公司id
			isCom: <?php echo $cpid?>,
		});
		K('#logoUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#logoUp').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#logo').attr('src',url+"?t="+Math.random());
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>