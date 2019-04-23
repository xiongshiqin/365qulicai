<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php  $this->widget('BusinessMenu',array('selected'=>'news')); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a href="<?php echo $this->createUrl('/p/business/news', array('id'=>$news_info->bid)); ?>">新闻列表</a>		
				<a href="<?php echo $this->createUrl('/p/business/newsAdd', array('comId'=>$news_info->bid)); ?>">添加新闻</a>	
			</div>

			<?php $this->widget('ext.kindeditor.KindEditorWidget',array(
			    'id'=>'content',   //对应表单中的 输入框ID 
			    'items' => array(
			        'width'=>'700px',
			        'height'=>'300px',
			        'themeType'=>'simple',
			        'allowImageUpload'=>true,
			        'allowFileManager'=>false,
			        'items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',),
			    ),
			)); ?>
			<!--添加新闻-->
			<div class="block fatie">
				<form class="backstage_input" id="news_form" name="form1" method="post" action="<?php echo $this->createUrl('/p/business/newsEdit',array('id'=>$news_info->id));?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="10%">新闻标题：</th>
							<td><input style="width:392px;" type="text" name="NewsForm[title]" id="title" value="<?php echo $news_info->title;?>" /></td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:10px;">新闻内容：</th>
							<td width="85%"><textarea style="width:390px;" name="NewsForm[content]" id="content" cols="45" rows="5"><?php echo $news_info->content;?></textarea></td>
						</tr>
						<tr>
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
<script>
	$(document).ready(function(){
		// 验证框架使用方法 需要name
		// $("#news_form").validate({
		// 	rules: {
		// 		"NewsForm[title]": {
		// 			required: true,
		// 			maxlength: 60,	
		// 		},
		// 		"NewsForm[content]": {
		// 			required:true,
		// 		},
		// 	},
		// 	messages: {
		// 		"NewsForm[title]": { 
		// 			required: "请输入标题",
		// 			maxlength: "标题长度必须小于30", 
		// 		},
		// 		"NewsForm[content]": {
		// 			required: "请输入密码",
		// 		},
		// 	}
		// });
	});
</script>