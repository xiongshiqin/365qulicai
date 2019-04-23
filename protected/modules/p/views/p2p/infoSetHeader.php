<!--莱单-->
<div class="block menu_btn" >
	<a class="base" href="<?php echo $this->createUrl('/p/p2p/info',array('cpid'=>$cpid));?>">基本信息</a>
	<a class="ptjj" href="<?php echo $this->createUrl('/p/p2p/otherInfo',array('cpid'=>$cpid , 'do' => 'ptjj'));?>">平台简介</a>
	<a class="tdjs" href="<?php echo $this->createUrl('/p/p2p/otherInfo',array('cpid'=>$cpid , 'do' => 'tdjs'));?>">团队介绍</a>		
	<a class="zzzm" href="<?php echo $this->createUrl('/p/p2p/otherInfo',array('cpid'=>$cpid , 'do' => 'zzzm'))?>">公司证件</a>	
	<a class="lxwm" href="<?php echo $this->createUrl('/p/p2p/otherInfo',array('cpid'=>$cpid , 'do' => 'lxwm'));?>">联系我们</a>	
	<a class="sfqk" href="<?php echo $this->createUrl('/p/p2p/otherInfo',array('cpid'=>$cpid , 'do' => 'sfqk'))?>">收费情况</a>	
</div>
<script>
	$(function(){
		$(".<?=$do?>").addClass('selected').siblings('a').removeClass('selected');
	})
</script>
