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
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/newsAdd',array('cpid'=>$cpid));?>">修改新闻/公告</a>		
			</div>

			<!--添加新闻公告-->
			<div class="block fatie clearboth">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/p2p/newsEdit')?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid?>"/>
						<input type="hidden" name="newsid" value="<?php echo $news->newsid;?>"/>
						<tr>
							<th width="8%">标题：</th>
							<td width="92%"><input style="width:653px;" type="text" name="title" value="<?php echo $news->title;?>" /></td>
						</tr>
						<tr>
							<th>类型：</th>
							<td>
								<?php foreach(Yii::app()->params['News']['category'][1] as $k=>$v):?>
									<input <?php if($news->classid == $k) echo " checked = 'checked' "?> style="width:14px; height:14px; border:0;" type="radio" value="<?php echo $k;?>" 
									name="classid" />
									<label><?php echo $v;?></label>
								<?php endforeach;?>
							</td>
						</tr>
						<tr>
							<th valign="top">内容：</th>
							<td style="padding:0"><textarea style="width:657px;" name="content" id="content" cols="45" rows="5"><?php echo $news->content;?></textarea></td>
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
