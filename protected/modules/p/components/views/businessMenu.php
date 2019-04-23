<div class="sideL">
	<!--后台管理-->
	<dl class="block backstage">
		<dt>后台管理</dt>
		<dd <?php echo $this->getSelected('index')?>><?php echo CHtml::link('基本信息',array('/p/business/index', 'id'=>$this->id)); ?></dd>
		<dd <?php echo $this->getSelected('news')?>><?php echo CHtml::link('新闻公告',array('/p/business/news', 'id'=>$this->id)); ?></dd>
		<dd <?php echo $this->getSelected('member')?>><?php echo CHtml::link('成员',array('/p/business/member', 'id'=>$this->id)); ?></dd>
		<!-- <dd <?php echo $this->getSelected('invite')?>><?php echo CHtml::link('邀请码',array('/p/business/invite', 'id'=>$this->id)); ?></dd> -->
		<dd><?php echo CHtml::link('首页预览',array('/business/index', 'id'=>$this->id)); ?></dd>
	</dl>
</div>