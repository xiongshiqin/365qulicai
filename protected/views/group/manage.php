<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position">
			<h4>
				<i><a href="<?php echo $this->createUrl('group/hot'); ?>">小组首页</a>&nbsp;&gt;&nbsp;<a href="<?php echo $this->createUrl('group/index',array('gid'=>$this->_group->gid)); ?>"><?php echo $this->_group->name;?></a>&nbsp;&gt;&nbsp;设置</i>
			</h4>
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
			<div class="block fatie" style="width:818px;">
				<form id="form1" name="form1" method="post" action="<?php echo $this->createUrl('group/manage'); ?>">
					<input type="hidden" name="gid" value="<?php echo $this->_group->gid;?>" />
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="ss">
						<tr>
							<td>名&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;称：</td>
							<td><?php echo $this->_group->name;?></td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">小组头像：</th>
							<td>
								<img id="pic" src="<?php echo HComm::get_group_dir($this->_group->gid);?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="picUp" value="选择图片" />
							</td>
						</tr>
						<tr>
							<td valign="top">介&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;绍：</td>
							<td><textarea style="height:140px;" name="info" id="textarea" cols="45" rows="5"><?php echo CHtml::encode($this->_group->info);?></textarea></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
							<input class="btn_blue" type="submit" name="button" id="button" value="更新设置" />
							<a href="<?php echo $this->createUrl('group/index',array('gid'=>$this->_group->gid)); ?>">&nbsp;&nbsp;&gt;&gt;返回小组</a></td>
						</tr>
					</table>
				</form>

				<div style="clear:both;"></div>
			</div>

		</div>
	</div>
</div>
<script>
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
			// 如果上传的为小组pic  则增加 isGroup : 小组id
			isGroup: <?php echo $this->_group->gid?>,
		});
		K('#picUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#picUp').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#pic').attr('src',url+"?t="+Math.random());
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>
