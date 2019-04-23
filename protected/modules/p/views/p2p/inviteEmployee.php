
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'employee', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn menu_btn1">
				<a href="<?php echo $this->createUrl('/p/p2p/employee',array('cpid'=>$cpid));?>">员工列表</a>
				<a class="selected"  href="<?php echo $this->createUrl('/p/p2p/inviteEmployee' , array('cpid' => $cpid));?>">邀请员工</a>		
			</div>

			请复制链接并发送给待邀请的员工，员工点击后即可在'员工管理'中审核<br/>
			链接地址：&nbsp;&nbsp;&nbsp;<?php echo $empUrl;?><br/>
			<br/>
			<br/>
			<br/>


			请复制链接并发送给平台的投资人，投资人点击后注册默认关注当前平台<br/>
			链接地址：&nbsp;&nbsp;&nbsp;<?php echo $followUrl;?><br/>
				
		</div>
	</div>
</div>
