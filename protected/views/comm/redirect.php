
<div id="wrap" >
	<div class="content">
		<div class="block">
			<div class="login_top">&nbsp;</div>
			<div class="login_c" style="padding: 10px 18px;">
				<h3><i>信息提示</i></h3>

				<div class="fl <?php echo $type;?>-ico"><em></em></div>

		<!-- 		<div class="fr">
					<?php if('error' == $type):?>
						<h1 class="c_E64141">操作失败</h1>
						<p class="mb10"><?php echo $message;?></p>
						<p><span><a href="<?php echo $url;?>">&gt;请点击此处返回</a></span></p>
					<?php else:?>
						<h1>操作成功</h1>
						<p class="mb10"><?php echo $message;?></p>
					<?php endif;?>
				</div
 -->
				<div class="tishi">
					<h2><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/tishi_<?php echo $type;?>_ico.png" /><?php echo $message;?></h2>
					<?php if('error' == $type):?>
						<p class="blue"><a href="<?php echo $url;?>">[请点击此处返回]</a></p>
					<?php else:?>
						<br/>
						<span class="remain"><?php echo $delay ; ?></span>秒后跳转......
						<script>
						$(function(){
						var time = <?php echo $delay-1 ; ?>;
							jump();
							function jump(){
								setTimeout(function(){
									if(time <= 0){
										window.location.href = "<?php echo $url?>";
									}
									$('.remain').html(time);
									time-- ;
									jump();
								} , 1000); 
							}
						});
						</script>
					<?php endif;?>
				</div>
			
			</div>
			<div class="login_bottom">&nbsp;</div>		
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#body').css('background' , '#f8f8f8');
	})
</script>










