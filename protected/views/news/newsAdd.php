<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',))));?>
<!--内容区-->
<div id="wrap">
	<div class="content">
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" >
				<h2><cite><a href="<?php echo $this->createUrl('/news/newsList')?>">返回新闻列表</a></cite>发表新闻</h2>
				<div class="login_R" style="width:28px"></div>

				<div class="login_L password" style="border:0; width:754px">
					<form class="backstage_input" id="newsForm" method="post" action="">
						<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
							<tr>
								<td align="right">标题：</td>
								<td><input style="width:640px;" type="text" name="title"/></td>
							</tr>
							<tr>
								<td align="right">摘要：</td>
								<td><input style="width:640px;" type="text" name="summary" /></td>
							</tr>
							<tr>
								<td align="right">内容：</td>
								<td style="padding-top:10px;"><textarea  style="width:650px;height:260px;" name="content"></textarea></td>
							</tr>
							<tr>
								<td valign="top" style="padding-top:12px;">封面：</td>
								<td style="padding-top:20px;">

									<img style="margin-bottom:-10px;" id="pic" src="<?php echo Yii::app()->params['default_upload_img'];?>" width="100px" height="100px"/>
									<input class="upload_img" type="button" id="picUp" value="选择图片" />
									<input type="hidden" name="pic" value=""/>
								</td>
							</tr>
							<tr>
								<td align="right">分类：</td>
								<td>
									<select name="classid">
										<?php foreach(Yii::app()->params['News']['category'][2] as $k => $v ):?>
											<option value="<?=$k?>"><?=$v?></option>
										<?php endforeach;?>
									</select>
								</td>
							</tr>
							<tr class="fatie">
								<td></td>
								<td><input class="btn_blue" type="submit" value="发布"/></td>
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
	$(function(){
		$.validator.addMethod("phoneNo", function (value, element) {
		            var length = value.length;
		            // var regex = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
		           var regex = /^1+([2|3|4|5|6|7|8|9]{1})+([0-9]{1})+\d{8}$/;  
		            return this.optional(element) || (length == 11 && regex.test(value));
	        	}, "<img src='/html/images/tan.png' />手机号码格式错误");
		// 表单验证
		$("#newsForm").validate({
			rules: {
				"name": {
					required:true,
				},
				"siteurl":{
					required:true,
					url : true,
				},
				"operation_name":{
					required:true,
				},
				"operation_mobile":{
					required:true,
					phoneNo:true,
				},
				"invite":{
					required:true,
				},
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td').next('td'));  
			}
		});
	});	

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
</script>