<?php $this->widget('ext.kindeditor.KindEditorWidget'); ?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'info', //选中状态
		)); ?>

		<div class="mainarea">
			<?php echo $this->renderPartial('infoSetHeader' , array('cpid' => $cpid , 'do' => $do)); ?>

			<!--基本信息-->
			<div class="block fatie">
				<p class="help">可以从自己平台的相关栏目里，复制粘贴信息到这里，图片也可以自己复制。也可以自己打开html代码，进行页面编辑</p>
				<form class="backstage_input" method="post" action="<?php echo $this->createUrl('/p/p2p/otherInfo');?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?=$cpid;?>" />
						<input type="hidden" name="do" value="<?=$do?>"/>
						<tr>
							<td width="15%" valign="top"><?=$doName?> : </td>
						</tr>
						<tr>
							<td style="padding:0">
								<textarea style="width:800px;height:340px;" name="content" cols="60" rows="5"> <?php echo $content;?></textarea>
							</td>
						</tr>
						<tr>
							<td><input class="btn_blue" type="submit" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" /></td>
						</tr>
					</table>
				</form>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		var sucMsg = '<?php echo Yii::app()->user->getFlash("otherInfoSuccess");?>';
		if(sucMsg){
			show_message('success' , sucMsg);
		}
	});
</script>