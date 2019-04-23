<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'video', //选中状态
		)); ?>


		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a href="<?php echo $this->createUrl('/p/p2p/video',array('cpid'=>$cpid));?>">宣传视频</a>		
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/videoEdit',array('cpid'=>$cpid))?>">添加视频</a>		
			</div>


			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid?>"/>
						<input type="hidden" name="id" value="<?php echo $video->id;?>"/>
						<tr>
							<th width="12%">视频标题：</th>
							<td width="88%">
								<input style="width:393px;" type="text" name="title" value="<?php echo $video->title ?>" />
							</td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">视频源地址：</th>
							<td>
								<input style="width:393px;" type="text" name="url" value="<?php echo $video->url ?>" />
								<p class="grey">比如：http://player.youku.com/player.php/sid/XODM5OTQ4MzU2/v.swf</p>
								<div style="padding-top:8px;">
									<p class="quote" ><span style="grey">帮助：</span><a href="javascript:void(0)" class="vhelp">怎么复制优酷视频地址：</a></p>
									<p class="help_content" style="display:none;"><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/demonstration_img.png" /></p>
								</div>
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
	$(document).ready(function(){
		$('.vhelp').click(function(){
			$('.help_content').toggle();
		})
	});
</script>