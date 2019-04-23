<div class="companyRelationship companyRelationship_<?php echo $this->cpid;?>">
	<?php 
		switch($this->relation){
			case 1:
			?>
				<!-- <a href="javascript:void(0);" data-action="addComRelationship" data-params="<?php echo $this->cpid;?>"  >关注平台</a> -->
				<?php if($this->hasApi):?>
					<!-- <a class="will"  href="javascript:void(0)" data-action="relateCom" data-params="<?php echo $this->cpid;?>">关注平台</a> -->
					<a href="javascript:void(0);" data-action="addComRelationship" data-params="<?php echo $this->cpid;?>"  >关注平台</a>
				<?php else: // 未填写api不弹窗默认关注?>
					<a href="javascript:void(0);" data-action="addComRelationship" data-params="<?php echo $this->cpid;?>"  >关注平台</a>
				<?php endif;?>
			<?php
			break;
			case 2:
			?>
				<cite class="cur"><img src="/html/images/gou1.png">已关注</cite>
				<?php if( $this->hasApi):?>
					<a class="will"  href="javascript:void(0)" data-action="relateCom" data-params="<?php echo $this->cpid;?>">关联平台</a>
				<?php endif;?>
				<!-- <a href="javascript:void(0);" data-action="remComRelationship" data-params="<?php echo $this->cpid;?>">取消关注</a> -->
			<?php
			break;
			case 3:
			?>
				<img src="/html/images/gou1.png">已关联
			<?php
		}
	?>
</div>
<script>
	$(document).ready(function(){
		// 关注按钮变换操作
		// $('.companyRelationship').mouseover(function(){
		// 	$('.cur').hide();
		// 	$('.will').show();
		// }).mouseout(function(){
		// 	$('.will').hide();
		// 	$('.cur').show();
		// });
	});
</script>