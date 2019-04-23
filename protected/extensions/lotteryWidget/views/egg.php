<style type="text/css">
.egg{width:660px; height:188px; margin:39px auto 17px auto;}
.egg ul li{z-index:999;}
.eggList{position:relative;width:660px;}
.eggList li{float:left;background:url(<?php echo  $this->assets . '/images/egg/egg_1.png'; ?>) no-repeat bottom;width:158px;height:187px;cursor:pointer;position:relative;margin-left:35px;}
.eggList li span{position:absolute; width:30px; height:60px; left:68px; top:64px; color:#ff0; font-size:42px; font-weight:bold}
.eggList li.curr{background:url(<?php echo  $this->assets . '/images/egg/egg_2.png'; ?>) no-repeat bottom;cursor:default;z-index:300;}
.eggList li.curr sup{position:absolute;background:url(<?php echo  $this->assets . '/images/egg/img-4.png'; ?>) no-repeat;width:232px; height:181px;top:-36px;left:-34px;z-index:800;}
.hammer{background:url(<?php echo  $this->assets . '/images/egg/img-6.png'; ?>) no-repeat;width:74px;height:87px;position:absolute; text-indent:-9999px;z-index:1500;left:168px;top:-20px;}
.resultTip{position:absolute; background:#ffc ;width:148px;padding:6px;z-index:500;top:200px; left:10px; color:#f60; text-align:center;overflow:hidden;display:none;z-index:500;}
.resultTip b{font-size:14px;line-height:24px;}
</style>
	<div class="egg">
		<ul class="eggList">
			<p class="hammer" id="hammer">锤子</p>
			<p class="resultTip" id="resultTip"><b id="result"></b></p>
			<li><span>1</span><sup></sup></li>
			<li><span>2</span><sup></sup></li>
			<li><span>3</span><sup></sup></li>
		</ul>
	</div>

<script type="text/javascript">

$(".eggList li").click(function() {
	eggClick($(this) , '<?=$this->resultUrl?>' , '<?=$this->lotid?>');
});

$(".eggList li").hover(function() {
	var posL = $(this).position().left + $(this).width();
	$("#hammer").show().css('left', posL);
})
</script>