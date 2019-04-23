<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('id'=>'content', 'items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',))));?>
<div class="main-title">
	<h2>编辑平台</h2>
</div>
<form method="post" action="">
	<table>
		<input type="hidden" name="newsid" value="<?=$news->newsid?>"/>
		<tr>
			<td>标题：</td>
			<td>
				<input type="text" style="width:500px;" name="title" value="<?=$news->title?>"/>
			</td>
		</tr>
		<tr>
			<td valign="top" style="padding-top:12px;">封面：</td>
			<td style="padding-top:20px;">

				<img style="margin-bottom:-10px;" id="pic" src="<?php echo $news->pic ? $news->pic : Yii::app()->params['default_upload_img'];?>" width="100px" height="100px"/>
				<input class="upload_img" type="button" id="picUp" value="选择图片" />
				<input type="hidden" name="pic" value="<?=$news->pic?>"/>
			</td>
		</tr>
		<tr>
			<td>摘要：</td>
			<td>
				<textarea style="width:500px;height:100px" id="summary" name="summary"><?=$news->summary?></textarea>
			</td>
		</tr>
		<tr>
			<td>内容：</td>
			<td><textarea style="width:1200px;height:800px" id="content" name="content"><?=$news->content?></textarea></td>
		</tr>
		<tr>
			<td>
				<input type="radio" name="status" value="-1" <?php if($news->status == -1) echo 'checked="checked"';?>/>删除
				<input type="radio" name="status" value="0" <?php if($news->status == 0) echo 'checked="checked"';?> />审核中
				<input type="radio" name="status" value="1" <?php if($news->status == 1) echo 'checked="checked"';?>/>通过审核
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="提交"/>
			</td>
		</tr>
	</table>
</form>
<script>
	$(function(){
		KindEditor.ready(function(K) {
			var editor = K.editor({
				allowFileManager : true,
			});
			K('#picUp').click(function() {
				editor.loadPlugin('image', function() {
					editor.plugin.imageDialog({
						showRemote : false,
						imageUrl : K('#picUp').val(),
						clickFn : function(url, title, width, height, border, align) {
							K('#pic').attr('src',url+"?t="+Math.random());
							K('[name=pic]').val(url);
							editor.hideDialog();
						}
					});
				});
			});
		});
	});
</script>