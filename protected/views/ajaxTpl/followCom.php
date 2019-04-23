<!--写弹出窗时  标题为h3  内容为class="ejectC"-->

<div class="ejectjtyC">
	<?php if(! isset(CompanyApi::model()->findByPk($company->cpid)->relate_api)):?>
		该平台未填写关联平台帐号api，无法关联，请联系此平台客服!
	<?php else:?>
		<h3><cite><a href="">&nbsp;</a></cite><strong>关联平台帐号:</strong></h3>
		<div style="padding:20px;">
			<!--右边-->
			<div class="relationR">
				<p>还没有帐号？</p>
				<p><a target="_blank" href="<?=$company->siteurl?>">&gt;&gt;现在就去<em><?=$company->name?></em>注册</a></p>
			</div>

			<!--左边-->
			<div class="relationL">
				<?php if(count($p2pname) > 0):?>
					我在<?=$company->name?>上的用户名：
					<?php foreach($p2pname as $v): ?>
						<p><input class="choicename" type="radio" value="<?=$v?>"/ name="names">&nbsp;<?=$v?></p>
					<?php endforeach;?>
					<p><input type="radio" id="val" value="<?=$v?>"/ name="names"><a href="javascript:void(0)" class="write"><label for="val">手动填写</label></a></p>
					
					<p><input style="width:200px;display:none;" class="relation_input" id="setp2pname" type="text" name="p2pname"/></p>
				<?php else:?>
					用户名：<input style="width:200px" class="relation_input" id="setp2pname" type="text" name="p2pname"/>
				<?php endif;?>
				<div class="relationsL">
					<p>请确认你在<?=$company->name?>平台上的账号</p>
					<p style="color:red;">将作为平台活动抽奖发奖的凭证</p>
					<p><span style="margin-top:9px;" class="btn_blues" id="setp2pnamesub">确定</span></p>
				</div>
			</div>
			<div class="clearboth"></div>
		</div>
	<?php endif;?>
</div>
<script>
	$('.write , #val').click(function(){
		$('[name=p2pname]').show();
	});

	$('.choicename').click(function(){
		$('[name=p2pname]').val($(this).val());
		$('[name=p2pname]').hide();
	});

	$('[name=p2pname]').click(function(){
		$('#hidd').val($(this).val());
		$('#hidd').click();
	});

</script>



<!--div class="ejectjtyC">
<center>
	在<?=$company->name?>上的用户名 : <input style="width:200px" class="relation_input" id="setp2pname" type="text" name="p2pname"/>(不填代表关注该平台)
	<br/><br/>
	<span class="btn_blues" id="setp2pnamesub">确定</span>
</center>
</div-->