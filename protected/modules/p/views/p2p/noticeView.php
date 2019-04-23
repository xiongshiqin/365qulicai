<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'notice', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<cite><a style="background:none; color:#1c7abe;" href="<?php echo $this->createUrl('/p/p2p/index' , array('cpid'=>$cpid));?>">返回公告列表</a></cite><a class="selected" href="">系统公告</a>
			</div>

			<!--系统公告-->
			<div class="block system_notice">
				<h2><?=$notice->title?></h2>
				<p class="noticetime"><?php echo date('Y-m-d H:m' , $notice->dateline);?></p>
				<p><?=$notice->content?></p>
			</div>
		</div>
	</div>
</div>
