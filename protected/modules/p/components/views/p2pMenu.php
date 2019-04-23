	<span style="color:red">如有疑问请加理财派QQ群咨询：300583640</span>
	<br/><br/>
	<div class="sideL">
		<!--P2P后台管理菜单 beyond_dream  -->
		<dl class="block backstage">
			<dt><?php echo Company::model()->findByPk($this->p2pid)->name?>后台</dt>
			<dd<?php echo $this->getSelected('index'); ?>><?php echo CHtml::link('管理首页',array('/p/p2p/index', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('info'); ?>><?php echo CHtml::link('基本信息',array('/p/p2p/info', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('service'); ?>><?php echo CHtml::link('员工/客服',array('/p/p2p/service', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('album'); ?>><?php echo CHtml::link('宣传相册',array('/p/p2p/album', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('news'); ?>><?php echo CHtml::link('新闻/公告',array('/p/p2p/news', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('biaos'); ?>><?php echo CHtml::link('发标播报',array('/p/p2p/biaos', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('video'); ?>><?php echo CHtml::link('宣传视频',array('/p/p2p/video', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('event'); ?>><?php echo CHtml::link('活动&抽奖',array('/p/event/eventList', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('adver'); ?>><?php echo CHtml::link('自助广告',array('/p/p2p/ads', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('fans'); ?>><?php echo CHtml::link('粉丝管理',array('/p/p2p/fans', 'cpid'=>$this->p2pid)); ?></dd>
			<dd<?php echo $this->getSelected('api'); ?>><?php echo CHtml::link('接口管理',array('/p/p2p/api', 'cpid'=>$this->p2pid)); ?></dd>
			<dd><a target="_blank" href="<?php echo Yii::app()->createUrl('/p2p/index' , array('cpid'=>$this->p2pid))?>">去前台首页</a></dd>
		</dl>
	</div>