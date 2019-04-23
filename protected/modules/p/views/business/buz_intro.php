<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('BusinessMenu',array('selected'=>'index')); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a href="<?php echo $this->createUrl('/p/business/index', array('id'=>$business_info->bid));?>">基本信息</a>		
				<!-- <a href="">费&nbsp;&nbsp;&nbsp;&nbsp;率</a>	 -->
				<a class="selected" href="<?php echo $this->createUrl('/p/business/buzIntro', array('id'=>$business_info->bid));?>">公司介绍</a>		
			</div>
			<?php $this->widget('ext.kindeditor.KindEditorWidget',array(
			    'id'=>'info',   //对应表单中的 输入框ID 
			    'items' => array(
			        'width'=>'700px',
			        'height'=>'300px',
			        'themeType'=>'simple',
			        'allowImageUpload'=>true,
			        'allowFileManager'=>false,
			        'items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',),
			    ),
			)); ?>
			<?php $this->widget('ext.kindeditor.KindEditorWidget',array(
			    'id'=>'mainbisness',   //对应表单中的 输入框ID 
			    'items' => array(
			        'width'=>'700px',
			        'height'=>'300px',
			        'themeType'=>'simple',
			        'allowImageUpload'=>true,
			        'allowFileManager'=>false,
			        'items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',),
			    ),
			)); ?>
			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/business/buzIntro')?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" value="<?php echo $business_info->bid?>" name="id"/>
						<tr>
							<th valign="top" style="padding-top:10px;">公司简介：</th>
							<td width="85%"><textarea style="width:390px;" name="info" id="info" cols="45" rows="5"><?php echo $business_info->info;?></textarea></td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:10px;">业务介绍：</th>
							<td width="85%"><textarea style="width:390px;" name="mainbisness" id="mainbisness" cols="45" rows="5"><?php echo $business_info->mainbissness;?></textarea></td>
						</tr>
							<th>&nbsp;</th>
							<td><input class="btn_blue" type="submit" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" /></td>
						</tr>
					</table>
				</form>
				<div class="clearboth"></div>
			</div>

		</div>
	</div>
</div>