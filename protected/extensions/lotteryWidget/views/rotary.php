
<div id="turntable">
	<div id="WheelEvent">
		<div class="demo">
		    <div id="disk"></div>
		    <div id="start">
		    	<img id="startbtn" src="<?php echo  $this->assets . '/images/zhuanpan/wheel_arrow.png'; ?>"></div>
		</div>
	</div>
</div>
<script>
	$(function(){
		// 切换转盘背景图片
		$('#disk').css('background' , "url(<?php echo  $this->assets . '/images/zhuanpan/wheel_bg'.$this->levnum.'.png'?>)");

		$('#startbtn').click(function(){
			rotary("<?=$this->resultUrl?>" , <?=$this->lotid?>);
		});
	})
</script>