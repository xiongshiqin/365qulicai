<!--内容区-->
<?php $company = Company::model()->findByPk($cpid);?>
<div id="wrap">
	<div class="contentL">
		<div class="sideL" style="width:180px;">
			<!--平台介绍-->
			<div class="block sidebar" style="background:#FAFAFA;">
				<dl>
					<dt><?php echo $company->name;?></dt>
					<dd class="ptjj"><a href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid' => $cpid , 'do' => 'ptjj'))?>">平台简介</a></dd>
					<dd class="zzzm"><a href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid' => $cpid , 'do' => 'zzzm'))?>">公司证件</a></dd>
					<dd class="tdjs"><a href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid' => $cpid , 'do' => 'tdjs'))?>">团队介绍</a></dd>
					<dd class="lxwm"><a href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid' => $cpid , 'do' => 'lxwm'))?>">联系我们</a></dd>
					<dd class="sfqk"><a href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid' => $cpid , 'do' => 'sfqk'))?>">管理费用</a></dd>
				</dl>
			</div> 
		</div>

		<div class="mainarea" style="width:814px;">
			<!--内容-->
			<div class="block newsbulletin platform_C" style="padding:0;">
				<h4><cite><a href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $cpid))?>">&gt;&gt;回<?=$company->name?>首页</a></cite><?=$doName?></h4>
				<div style="padding:5px 10px;">
					<p>
						<?=$company->company_info->$do;?>
					</p>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$(".<?=$select?>").addClass('selected').siblings('a').removeClass('selected');
	})
</script>
