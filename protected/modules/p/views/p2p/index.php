<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'index', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected"  href="">管理页面</a>	
				<a target="_blank" href="<?php echo $this->createUrl('/p2p/index', array('cpid' => $cpid))?>">首页预览</a>		
			</div>

			<?php if($notice):?>
				<div class="block block1 admin_news">
				<!--此处lastestNews Widget-->
					<div id="yw1" class="portlet">
						<div class="portlet-content">
							<h3>
								系统公告
							</h3>
							<ul class="msgtitlelist">
								<?php foreach($notice as $v):?>
									<li><a href="<?php echo $this->createUrl('/p/p2p/noticeView' , array('newsid'=>$v->newsid , 'cpid'=>$cpid));?>" target="_blank"  style="color:red"><?=$v->title?></a></li>
								<?php endforeach;?>
							</ul>
						</div>
					</div>
				</div>
			<?php endif;?>

			<div class="block step_buzhou">
				<?php if($company->isopen != 3):?>
					<p class="help">
					<?php if($company->isopen == 2) echo "等待审核中...";?>
						请花30分钟认真完善自己的平台资料，然后再
						<?php if($step['base']&&$step['service']&&$step['news']&&$step['biao']&&$step['album']):?>
							<a class="interest" class= "block menu_btn" href="<?php echo $this->createUrl('/p/p2p/applyOpen' , array('cpid'=>$cpid));?>">申请开通</a>
						<?php else:?>
							申请开通
						<?php endif;?>
					</p>
				<?php endif;?>
				<h4>第一步：完善资料<span class="grey">(30分钟)</span></h4>
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<th><a href="<?php echo $this->createUrl('/p/p2p/info' , array('cpid'=>$cpid));?>">基本资料</a></th>
						<th><a href="<?php echo $this->createUrl('/p/p2p/service' , array('cpid'=>$cpid));?>">在线客服</a></th>
						<th><a href="<?php echo $this->createUrl('/p/p2p/news' , array('cpid'=>$cpid));?>">新闻/公告</a></th>
						<th><a href="<?php echo $this->createUrl('/p/p2p/biaos' , array('cpid'=>$cpid));?>">发标播报</a></th>
						<th><a href="<?php echo $this->createUrl('/p/p2p/album' , array('cpid'=>$cpid));?>">宣传相册</a></th>
					</tr>
					<tr>
						<td>
							<?php if($step['base']):?>
								<em>已添加</em>
							<?php else:?>
								未添加
							<?php endif;?></td>
						</td>
						<td>
							<?php if($step['service']):?>
								<em>已添加</em>
							<?php else:?>
								未添加
							<?php endif;?>
						</td>
						<td>
							<?php if($step['news']):?>
								<em>已添加</em>
							<?php else:?>
								未添加
							<?php endif;?>
						</td>
						<td>
							<?php if($step['biao']):?>
								<em>已添加</em>
							<?php else:?>
								未添加
							<?php endif;?>
						</td>
						<td>
							<?php if($step['album']):?>
								<em>已添加</em>
							<?php else:?>
								未添加
							<?php endif;?>
						</td>
					</tr>
				</table>
				
			</div>

			<div class="block step_buzhou">
				<h4>第二步：邀请<span class="grey">(2分钟)</span></h4>
					<p class="help">邀请同事加入，注册后，在'员工管理'中审核，可进入此后台<br/>
					<br/>如被邀请的用户已经注册过理财派，则登录后再点击该链接即可<br/>邀请链接：&nbsp;&nbsp;&nbsp;<?php echo $empUrl;?><br/></p>
				<?php if(0 && $company->isopen == 3): ?>
					<p class="help">邀请投资人，激活僵尸用户，默认注册后自动关注此平台，成为粉丝<br/>邀请链接：&nbsp;&nbsp;&nbsp;<?php echo $followUrl;?><br/></p>
				<?php endif;?>
			</div>

		</div>
	</div>
</div>