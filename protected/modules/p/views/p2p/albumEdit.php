<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'album', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a href="<?php echo $this->createUrl('/p/p2p/album',array('cpid'=>$cpid , 'type'=> 1));?>">宣传相册</a>		
				<a class="selected" href="<?php echo $this->createUrl('/p/p2p/albumEdit',array('cpid'=>$cpid));?>">添加图片</a>		
			</div>

			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/p2p/albumEdit')?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid?>"/>
						<input type="hidden" name="id" value="<?php echo $album->id;?>"/>
						<input type="hidden" name="album" value="2"/>
						<tr>
							<th valign="top">图片：</th>
							<td style="padding:0">
								<input type="hidden" name="url" id="urlVal" value="<?php echo $album->url;?>"/>
								<img style="float:left;" id="url" src="<?php echo $album->url ? $album->url : Yii::app()->params['default_upload_img']; ?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="urlUp" value="选择图片" />
							</td>
						</tr>
						<tr>
							<th>名称：</th>
							<td><input style="width:393px;" type="text" name="picname" value="<?php echo $album->picname;?>" /></td>
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
<script>
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true
		});
		K('#urlUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#urlup').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#urlVal').val(url);
						K('#url').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>