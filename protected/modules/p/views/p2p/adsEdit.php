<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'ad', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a href="<?php echo $this->createUrl('/p/p2p/ads',array('cpid'=>$cpid));?>">广告图片列表</a>		
				<a class="selected" href="<?php echo $this->createUrl('/p/p2p/adsEdit',array('cpid'=>$cpid));?>">添加广告图片</a>		
			</div>

			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/p2p/adsEdit');?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid?>"/>
						<input type="hidden" name="id" value="<?php echo $adPic->id?>"/>
						<tr>
							<th width="12%">广告标题：</th>
							<td width="88%"><input style="width:393px;" type="text" name="title" value="<?php echo $adPic->title;?>"/></td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">链接地址：</th>
							<td>
								<input style="width:393px;" type="text" name="url" value="<?php echo $adPic->url;?>"/>
							</td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">图片：</th>
							<td>
								<input type="hidden" name="picurl" id="picurlVal" value="<?php echo $adPic->picurl;?>"/>
								<img style="float:left;" id="picurl" src="<?php echo $adPic->picurl; ?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="picurlUp" value="选择图片" />
								<span>&nbsp;方形广告尺寸大小为266*210；条形广告尺寸大小为728*60</span>
							</td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">广告位置：</th>
							<td>
								<select name="place" id="place">
									<?php foreach(Yii::app()->params['adsPlace'] as $k=>$v):?>
										<option <?php if($k==$adPic->place) echo ' selected ';?> value="<?php echo $k;?>"><?php echo $v;?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr>
						<tr>
							<th>排序：</th>
							<td>
								<input style="width:393px;" type="text" name="order" value="<?php echo $adPic->order;?>"/>
							</td>
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
		K('#picurlUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#picurlup').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#picurlVal').val(url);
						K('#picurl').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>