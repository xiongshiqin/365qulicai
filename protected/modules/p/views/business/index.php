<!--内容区-->
<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>

<div id="wrap">
	<div class="contentL">
		<?php $this->widget('BusinessMenu',array('selected'=>'index')); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected" href="<?php echo $this->createUrl('/p/business/index', array('id'=>$business_info->bid));?>">基本信息</a>		
				<!-- <a href="">费&nbsp;&nbsp;&nbsp;&nbsp;率</a>	 -->
				<a href="<?php echo $this->createUrl('/p/business/buzIntro', array('id'=>$business_info->bid));?>">公司介绍</a>		
			</div>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/business/index')?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" value="<?php echo $business_info->bid?>" name="id"/>
						<tr>
							<th>公司简称</th>
							<td><input type="text" name="shortname" value="<?php echo $business_info->shortname; ?>"/></td>
						</tr>
						<tr>
							<th>公司名称：</th>
							<td><input type="text" name="name"  value="<?php echo $business_info->name; ?>"/></td>
						</tr>
						<tr>
							<th>公司网址：</th>
							<td><input type="text" name="siteurl"  value="<?php echo $business_info->business_info->siteurl; ?>"/></td>
						</tr>
						<tr>
							<th>公司地址：</th>
							<td><input type="text" name="address"  value="<?php echo $business_info->business_info->address; ?>"/></td>
						</tr>
						<tr>
							<th>公司电话：</th>
							<td><input type="text" name="telephone"  value="<?php echo $business_info->business_info->telephone; ?>"/></td>
						</tr>
						<tr>
							<th>公司传真：</th>
							<td><input type="text" name="fax"  value="<?php echo $business_info->business_info->fax; ?>"/></td>
						</tr>
						<tr>
							<th>公司微博：</th>
							<td><input type="text" name="weibo"  value="<?php echo $business_info->business_info->weibo; ?>"/></td>
						</tr>
						<tr>
							<th>公司LOGO:</th>
							<td>
								<input type="hidden" name="logo" id="logoval" value="<?php echo $business_info->business_info->logo;?>"/>
								<img id="logo" src="<?php echo $business_info->business_info->logo ? $business_info->business_info->logo : Yii::app()->params['default_upload_img']; ?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="logoup" value="选择图片" />
							</td>
						</tr>
						<tr>
							<th>公司微信：</th>
							<td>
								<input type="hidden" name="weixin" id="weixinval" value="<?php echo $business_info->business_info->weixin;?>"/>
								<img id="weixin" src="<?php echo $business_info->business_info->weixin; ?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="weixinup" value="选择图片" />
							</td>
						</tr>
						<tr>
							<th>申请人手机：</th>
							<td><input type="text" name="mobile"  value="<?php echo $business_info->business_service->mobile; ?>"/></td>
						</tr>
						<tr>
							<th>申请人姓名：</th>
							<td><input type="text" name="realname"  value="<?php echo $business_info->business_service->realname; ?>"/></td>
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
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true
		});
		K('#weixinup').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#weixinup').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#weixinval').val(url);
						K('#weixin').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
		K('#logoup').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#logoup').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#logoval').val(url);
						K('#logo').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>
