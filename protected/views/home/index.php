<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<!--用户信息-->
		<?php $this->widget('HomeMenu', array(
			'_user'=> $this->_user,
			'_self'=> $this->_self,
			"selected" => 'index',
		)); ?>
			

		<div class="mainarea eight">
			<!--我的平台-->
			<div class="block">
				<h3><i><?php echo (Yii::app()->user->id == $this->_user->uid) ? '我' : $this->_user->username?>的平台</i></h3>
				<ul class="my_platformy">
					<?php if($companies):?>
						<?php foreach($companies as $v):?>
							<li>
								<p class="userlogo">
									<a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $v->cpid));?>"><img src="<?php echo HComm::get_com_dir($v->cpid);?>" /></a>
								</p>
								<div style="padding-left:4px;">
									<p><i>月收益：</i><?php echo $v->company->profitlow;?>%-<?php echo $v->company->profithigh?>%</p>
									<p>
										<i>活&nbsp;&nbsp;&nbsp;&nbsp;动：</i><?php echo $v->company->event_num?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
										<i>粉&nbsp;&nbsp;&nbsp;&nbsp;丝：</i><?php echo $v->company->follow_num;?>
									</p>
									<div class="guanlian_platform">
										<?php if(Yii::app()->user->id == $this->_user->uid):?>
											<span class="companyRelationship_<?=$v->cpid?>">
												<?php $follow = CompanyFollow::model()->find("uid = :uid and cpid = :cpid",array(':uid'=>Yii::app()->user->id , ':cpid'=>$v->cpid));?>
												<?php if(! $follow):?>
													<a href="javascript:void(0)" data-action="relateCom" data-params="<?php echo $v->cpid;?>">关注平台</a></cite>
												<?php elseif(! $follow->p2pname):?>
													<a  href="javascript:void(0)" data-action="relateCom" data-params="<?php echo $v->cpid;?>">关联平台</a>
												<?php else:?>
													关联帐号: <?=$v->p2pname?>
												<?php endif;?>
											</span>
										<?php endif;?>
										
									</div>
								</div>
							</li>
						<?php endforeach;?>
					<?php endif;?>
				</ul>

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