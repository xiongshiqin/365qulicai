<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<div class="mainarea">
			<p class="help">欢迎申请成为 <a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $cpid));?>"><?php echo Company::model()->findByPk($cpid)->name?></a> 平台的一份子</p>
			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="12%">会员名称：</th>
							<td width="88%"><input style="border:0;" value="<?php echo $userinfo->username?>" type="text" name="username" /></td>
						</tr>
						<tr>
							<th width="12%">昵称:</th>
							<td width="88%"><input  type="text" name="nickname" /></td>
						</tr>
						<tr>
							<th>QQ：</th>
							<td><input type="text" name="qq" value="<?php echo $userinfo->info->qq?>"/></td>
						</tr>
						<tr>
							<th>所属部门：</th>
							<td>
								<select name="department">
									<?php foreach(Yii::app()->params['department'] as $k=>$v):?>
										<option value="<?=$k;?>"><?=$v?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr>
						<tr>
							<th>真实姓名：</th>
							<td><input type="text" name="realname" value="<?php echo $userinfo->info->realname?>"/></td>
						</tr>
						<tr>
							<th>相片：</th>
							<td>
								<input type="hidden" name="pic" id="picVal"/>
								<img id="pic" src="<?php echo Yii::app()->params['default_upload_img']?>" width="100px" height="100px"/>
								<input type="button" id="picUp" value="选择图片" />
								<span class="grey">仅支持jpg,gif,png格式图片，大小不能超过200M</span>
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
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true
		});
		K('#picUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#picup').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#picVal').val(url);
						K('#pic').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>