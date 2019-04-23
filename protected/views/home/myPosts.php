<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<!--用户信息-->
		<?php $this->widget('HomeMenu', array(
			'_user'=> $this->_user,
			'_self'=> $this->_self,
			'selected' => 'myPosts', 
		)); ?>
			

		<div class="mainarea eight">
			<!--我的帖子-->
			<div class="block activities">
				<h3><i><?php echo (Yii::app()->user->id == $this->_user->uid) ? '我' : $this->_user->username?>的帖子</i></h3>
				<table class="pingtai" width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th style="padding-left:15px;">标题</th>
						<th width="16%">浏览</th>
						<th width="15%">时间</th>
					</tr>
					<?php foreach($topics as $v):?>
						<tr>
							<td class="wenzi_R"><a target="_blank" href="<?php echo $this->createUrl('/group/view' , array('id' => $v->topicid));?>"><?php echo $v->title;?></a></td>
							<td><?php echo $v->viewnum;?></td>
							<td class="grey"><?php echo date('Y-m-d' , $v->addtime);?></td>
						</tr>
					<?php endforeach;?>
				</table>

				<!--分页-->
				<div class="pages clearboth">
					<ul class="pagelist">
						<?php   
							$_pager = Yii::app()->params->pager;
							$_pager['pages'] = $pages;
							$this->widget('CLinkPager', $_pager);
						?>
					</ul>
				</div>
				<!--分页End-->

			</div>
		</div>
	</div>
</div>