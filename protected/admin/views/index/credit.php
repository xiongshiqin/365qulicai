	<div class="main bc manage">        
		<?php $this->widget('ManageMenu',array(
			'selected' =>array('index/index'=>' current'),
		)); ?>  

<div>
<?php if ($creditList):?>
<?php foreach ($creditList as $key => $value) {?>
	<p>
		<form id="form_<?php echo $value['ruleid'];?>" action="<?php echo $this->createUrl('index/credit');?>" method="POST">
		<input type="hidden" name="id" value="<?php echo $value['ruleid'];?>" />
		<input id="edit_<?php echo $value['ruleid'];?>" name="content2" value="<?php echo $value['content'];?>" type="text" />
		<select name="op">
				<option value="1" <?php if($value['op']==1):?>selected="selected"<?php endif;?> >增加</option>
				<option value="0" <?php if($value['op']==0):?>selected="selected"<?php endif;?>>减少</option>
			</select>
		<select name="class">
				<option value="1" <?php if($value['class']==1):?>selected="selected"<?php endif;?>>用户</option>
				<option value="2" <?php if($value['class']==2):?>selected="selected"<?php endif;?>>小组</option>
				<option value="3" <?php if($value['class']==3):?>selected="selected"<?php endif;?>>P2P</option>
				<option value="4" <?php if($value['class']==4):?>selected="selected"<?php endif;?>>活动</option>
			</select>	
		<input name="num" value="<?php echo $value['num']; ?>" type="text" />
		<input type="submit" name="creditsubmit" value="确定">
		<a href="<?php echo $this->createUrl('index/credit', array('ac'=>'del', 'id'=>$value['ruleid']));?>">删除</a>
	</p>
<?php } ?>
<?php endif;?>

</div>

<form action="<?php echo $this->createUrl('index/credit');?>" method="POST">
	<p>名称：<input name="content" value="" id="content_add" type="text" /></p>
	<p>操作：<select name="op">
				<option value="1" >增加</option>
				<option value="0" >减少</option>
			</select></p>
	<p>类别：<select name="class">
				<option value="1" >用户</option>
				<option value="2" >小组</option>
				<option value="3" >P2P</option>
				<option value="4" >活动</option>
			</select>
	</p>
	<p>值：<input name="num" value="" type="text" /></p>
	<p><input type="submit" name="creditsubmit" value="确定">	</p>
</form>