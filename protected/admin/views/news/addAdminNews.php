<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',))));?>
<form method="post" action="">
	<table>
		<?php if($news):?>
			<input type="hidden" name="newsid" value="<?=$news->newsid?>"/>
		<?php endif;?>
		<tr>
			<td>标题：</td>
			<td><input style="width:500px;"  type="text" name="title" value="<?=$news->title?>"</td>
		</tr>
		<tr>
			<td>内容：</td>
			<td><textarea name="content" id="content"><?=$news->content?></textarea></td>
		</tr>
		<tr>
			<td>排序：</td>
			<td><input type="text" name="order" value="<?=$news->order?>"/></td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="提交"/>
			</td>
		</tr>
	</table>
</form>