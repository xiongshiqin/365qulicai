
<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position">
			<h4>
				<?php $this->widget('zii.widgets.CBreadcrumbs', array(
					'separator'=>' > ',
					'links' => array(
						'P2P理财'=>$this->createUrl('/p2p/list'),
						$this->_group->name => $this->createUrl('/group/index',array('gid'=>$this->_group->gid)),
						'编辑' => '',
						),
				)); ?><!-- breadcrumbs -->
			</h4>
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--右边-->
			<div class="block">
			&nbsp;
			</div>
		</div>

		<div class="mainarea">
			<!--发贴-->
			<div class="block fatie">
				<form id="form1" name="form1" method="post" action="<?php echo $this->createUrl('group/editTopic', array('gid'=>$this->_group->gid)); ?>" >
					<input type="hidden" name="id" value="<?php echo $this->_group->gid; ?>" />
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="postid" value="<?=$post->postid;?>"/>
						<input type="hidden" name="id" value="<?=$post->topicid?>"/>
						<tr>
							<td width="8%" >标题：</td>
							<td width="92%"><?=$post['title']?></td>
						</tr>
						<tr>
							<td valign="top"><img src="<?php echo HComm::avatar($this->_group->gid); ?>" /></td>
							<td><textarea name="content" id="content" cols="45" rows="5"><?=$post['content']?></textarea></td>
						</tr>
						<tr>
							<td>验证码：</td>
							<td><input style="width:90px;" type="text" name="verifyCode" size="10" id="" />
								<span class="image_code"><?php $this->widget('CCaptcha' , array('clickableImage'=>true ,  'buttonLabel'=>'点击更换')); ?></span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input class="btn_blue" type="submit" name="button" id="button" value="确&nbsp;&nbsp;定" /></td>
						</tr>
					</table>
				</form>
				<div style="clear:both;"></div>
			</div>

		</div>
	</div>
</div>