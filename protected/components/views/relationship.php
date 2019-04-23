	<?php 
		switch($this->relation){
			case 1:
			?>
				<div class="relationship relationship_<?php echo $this->fuid;?>">
				<!-- <span class="cur">关注</span> -->
				<span class="will" data-action="addRelationship" data-params="<?php echo $this->fuid;?>">关注</span>
			<?php
			break;
			case 2:
			?>
				<div class="cur relationship_<?php echo $this->fuid;?>">
				<img src="/html/images/gou1.png">
				<span>已关注</span>
				<!-- <span class="cur">已关注</span> -->
				<!-- <span class="will" data-action="remRelationship" data-params="<?php echo $this->fuid;?>" style="display:none;">取消关注</span> -->
			<?php
			break;
			case 3:
			?>
				<div class="relationship relationship_<?php echo $this->fuid;?>">
				<span class="will" data-action="addRelationship" data-params="<?php echo $this->fuid;?>">关注</span>
				<!-- <span class="cur">正关注我</span> -->
				<!-- <span class="will" data-action="addRelationship" data-params="<?php echo $this->fuid;?>" style="display:none;">关注</span> -->
			<?php
			break;
			case 4:
			?>
				<div class="cur relationship_<?php echo $this->fuid;?>">
				<img src="/html/images/gou1.png">
				<span>已关注</span>
				<!-- <span class="cur">互相关注</span> -->
				<!-- <span class="will" data-action="remRelationship" data-params="<?php echo $this->fuid;?>" style="display:none;">取消关注</span> -->
			<?php
			break;
			default:
			?>
				<!-- <span class="cur">我自己</span> -->
			<?php
		}
	?>
</div>

<script>
	$(document).ready(function(){
		// 关注按钮变换操作
		// $('.relationship').mouseover(function(){
		// 	$('.cur').hide();
		// 	$('.will').show();
		// }).mouseout(function(){
		// 	$('.will').hide();
		// 	$('.cur').show();
		// });
	});
</script>