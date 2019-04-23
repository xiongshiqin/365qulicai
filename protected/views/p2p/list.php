<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--平台列表-->
		<div class="block navigation">
			<div class="tab">
				<ul class="tab_menu">
					<li class="<?php echo $tab == 'all' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/list');?>">全部平台</a></li>
					<li class="<?php echo $tab == 'my' ? 'selected_li' : ''?>"><a href="<?php echo $this->createUrl('/p2p/myP2p')?>">我关注的平台</a></li>
				</ul>
			</div>
			
			<?php if(!Yii::app()->user->isGuest && Yii::app()->user->cpid):?>
				<?php $myCompany = Company::model()->findByPk(Yii::app()->user->cpid);?>
				<dl class="admin_platform ">
					<dt class="quote">我的平台：<a href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $myCompany->cpid));?>"><?=$myCompany->name;?></a></dt>
					<dd>月收益：<?php echo $myCompany->profitlow?>%-<?php echo $myCompany->profithigh?>%</dd>
					<dd>活动：<?=$myCompany->event_num?></dd>
					<dd>粉丝：<?=$myCompany->follow_num?></dd>
					<dd class="into_admin"><a href="<?php echo $this->createUrl('/p/p2p/index',array('cpid'=>$myCompany->cpid));?>">进入后台管理</a></dd>
					<?php if($myCompany->isopen < 2):?>
						<dd><a href="<?php echo $this->createUrl('/p/p2p/applyOpen' , array('cpid'=>$myCompany->cpid));?>"><font color="red">申请开通</font></a></dd>
					<?php elseif($myCompany->isopen == 2):?>
						<dd>等待审核中</dd>
					<?php endif;?>
				</dl>
			<?php endif;?>

			<ul class="my_platformy clearboth">
				<?php foreach($companies as $v):?>
					<?php if($tab=='my' || $v->isopen == 3):?>
						<li class = 'companies'>
							<p class="logoimg">
								<a href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $v->cpid));?>">
									<img src="<?php echo HComm::get_com_dir($v->cpid)?>" />
								</a>
							</p>
							<div class="navigation_text">
								<p><i>月收益：</i><?=$v->profitlow?>%-<?=$v->profithigh?>%</p>
								<!--p><i>活&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;动：</i><?=$v->event_num?></p-->
								<p><i>粉&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;丝：</i><?=$v->follow_num?></p>
							</div>

							<div class="join" style="display:none;">
								<div class="comRelation_<?php echo $v->cpid;?>">
									<?php $this->widget('CompanyRelationship' , array('cpid' => $v->cpid))?>
								</div>
							</div>
						</li>
					<?php else:?>
						<li>
							<p class="logoimg bg_opacity"><img src="<?php echo HComm::get_com_dir($v->cpid)?>" /></p>
							<div class="navigation_text <?php if(Yii::app()->user->isGuest || Yii::app()->user->cpid != $v->cpid) echo 'grey';?>">
								<!--p>平台名称：<?=$v->name?></p-->
								<?php if(Yii::app()->user->isGuest || Yii::app()->user->cpid != $v->cpid):?>
									<p>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：<?=$v->resideprovince?> | <?=$v->city?></p>
									<p>平台资料完善中，敬请期待</p>
								<?php else:?>
									<p>状态 : 完善资料</p>
									<p><a href="<?php echo $this->createUrl('/p/p2p/index' , array('cpid'=>$v->cpid));?>" style="color:blue;">&nbsp;&nbsp;&nbsp;>>现在去完善资料</a></p> 
								<?php endif;?>
							</div>
						</li>
					<?php endif;?>
				<?php endforeach;?>
				
				<?php if(!Yii::app()->user->isGuest && $tab != 'my' && !CompanyEmployee::model()->exists(array('condition'=>'uid = '.Yii::app()->user->id))):?>
					<li class="enter">
						<a href="<?php echo $this->createUrl('/p2p/apply');?>">&nbsp;</a>
					</li>
				<?php endif;?>
			</ul>
			<div class="clearboth"></div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('.companies').hover(function(){
			$('.join').hide();
			$(this).find('.join').show();
		}) 
	});
</script>