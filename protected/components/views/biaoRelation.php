	<?php 
		switch($this->relation){
			case 0:
			?>
				<span data-action="addBiaoLike" data-params="<?php echo $this->biaoid . ',' . $this->cpid;?>">感兴趣</span>
			<?php
			break;
			case 1:
			?>
				<img src="/html/images/gou1.png">
				<span data-action="remBiaoLike" data-params="<?php echo $this->biaoid . ',' . $this->cpid?>">取消</span>
			<?php
			break;
			default:
			?>
			<?php
		}
	?>
