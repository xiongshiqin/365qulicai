<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',))));?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'news', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a href="<?php echo $this->createUrl('/p/p2p/news',array('cpid'=>$cpid));?>">新闻/公告列表</a>		
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/newsAdd',array('cpid'=>$cpid));?>">添加新闻/公告</a>		
			</div>

			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/p2p/newsAdd')?>">
					<p class="help">温馨提醒：新闻可以直接自己平台复制粘贴到这里。最新添加的新闻显示在最前面，所以请从最早的新闻开始添加</p>
					
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid?>"/>
						<tr>
							<th width="8%">标题：</th>
							<td width="92%"><input style="width:653px;" type="text" name="title"  /></td>
						</tr>
						<tr>
							<th>类型：</th>
							<td>
								<?php foreach(Yii::app()->params['News']['category'][1] as $k=>$v):?>
									<input <?php if($k=='101') echo " checked='checked' "?> class="class_<?php echo $k;?>" style="width:14px; height:14px; border:0;" type="radio" value="<?php echo $k;?>" 
									name="classid" />
									<label><?php echo $v;?></label>
								<?php endforeach;?>
							</td>
						</tr>
						<tr>
							<th valign="top">内容：</th>
							<td style="padding:0"><textarea style="width:657px; height:300px;" name="content" id="content" cols="45" rows="5"></textarea></td>
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
