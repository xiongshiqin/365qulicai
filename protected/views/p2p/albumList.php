<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position no_bg">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'P2P理财'=>$this->createUrl('/p2p/list'),
				$company->name => $this->createUrl('/p2p/index',array('cpid'=>$cpid)),
				),
			)); ?><!-- breadcrumbs -->
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<div class="block block1">
				<?php $this->widget("LastestNews",array('cpid'=>$cpid))?>
			</div>
		</div>
		<div class="mainarea">
			<!--企业视频-->
			<div class="block">
				<h3><i>平台相册</i></h3>
				<ul class="photo photos">
					<?php if($albums):?>
						<?php foreach($albums as $v):?>
							<li>
								<a href="<?php echo $this->createUrl('/p2p/albumDetail' , array('albumid' => $v->id , 'cpid' => $cpid));?>">
									<img src="<?php echo BASE_URL.$v->url;?>" />
								</a>
								<!-- <p class="quote"><span class="grey">来自&nbsp;</span><a href="">韩汉</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="">12</a>&nbsp;回应</p> -->
							</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>
				<!--分页-->
				<div class="pages clearboth">
					<?php   
						$_pager = Yii::app()->params->pager;
						$_pager['pages'] = $pages;
						$this->widget('CLinkPager', $_pager);
					?>
				</div>
				<!--分页End-->
			</div>
		</div>
	</div>
</div>