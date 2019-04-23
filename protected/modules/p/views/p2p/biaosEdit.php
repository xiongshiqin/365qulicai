<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'biaos', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a href="<?php echo $this->createUrl('/p/p2p/biaos',array('cpid'=>$cpid))?>">发标播报</a>		
				<a class="selected" href="<?php echo $this->createUrl('/p/p2p/biaosEdit',array('cpid'=>$cpid))?>">添加发标</a>	
			</div>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="addForm" method="post" action="<?php echo $this->createUrl('/p/p2p/biaosEdit');?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid;?>"/>
						<input type="hidden" name="id" value="<?php echo $biaos->id;?>"/>
						<tr>
							<th width="15%">标名称：</th>
							<td width="85%"><input type="text" name="title" value="<?php echo $biaos->title;?>"/>&nbsp;如暂时无法确定标名称，可直接写一月标二月标</td>
						</tr>
						<tr>
							<th>金额：</th>
							<td><input type="text" name="money" value="<?php echo (int)$biaos->money;?>"/>&nbsp;元</td>
						</tr>
						<tr>
							<th>年化：</th>
							<td><input type="text" name="profityear" id='profityear' value="<?php echo (float)$biaos->profityear;?>"/>&nbsp;%</td>
						</tr>
						<tr>
							<th>奖励：</th>
							<td><input type="text" name="award" id='award' value="<?php echo (float)$biaos->award;?>"/>&nbsp;%</td>
						</tr>

						<tr>
							<th>还款方式：</th>
							<td>
								<select style="width:247px;" id="repaymenttype" name="repaymenttype">
									<?php foreach(Yii::app()->params['Biaos']['repaymenttype'] as $k=>$v):?>
										<option value="<?php echo $k;?>"><?php echo $v;?></option>
									<?php endforeach;?>
								</select>
							</td>
						</tr>
						<tr>
							<th>标种：</th>
							<td>
								<?php foreach(Yii::app()->params['Biaos']['itemtype'] as $k=>$v):?>
									<input class="<?php echo $k;?>" style="width:14px; height:14px; border:0;" type="radio" value="<?php echo $k;?>" 
									name="itemtype" />
									<label><?php echo $v;?></label>
								<?php endforeach;?>
							</td>
						</tr>
						<!-- 秒标编辑时默认隐藏周期-->
						<tr class="zhouqi" <?php if($biaos->itemtype == 1 ) echo " style='display:none;' "?>>
								<th>投资周期：</th>
								<td>
									<input type="text" name="timelimit" id='timelimit' value="<?php echo (int)$biaos->timelimit? (int)$biaos->timelimit : 1;?>"/>
									<span id="circus"><?php echo isset($biaos->itemtype) ? Yii::app()->params['Biaos']['itemtype'][$biaos->itemtype] : '月'?></span>
								</td>
						</tr>

						<tr>
							<th>预期万元收益：</th>
							<td><input type="text" disabled="disabled" name="expectprofit" id='expectprofit' value="<?php echo (int)$biaos->expectprofit; ?>" readonly='readonly'/>&nbsp;元</td>
						</tr>

						<tr>
							<th>预计发标时间：</th>
							<td>
								<?php 
									$this->widget('application.extensions.timepicker.timepicker', array(
									    'model'=>$biaos,
									    'name'=>'datelinepublish',
									));
								?>
							</td>
						</tr>
						
						<tr>
							<th>&nbsp;</th>
							<td>
							<input class="btn_blue" type="submit" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
							</td>
						</tr>
					</table>
				</form>

				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
var itemtype;
$(document).ready(function(){
	// 默认选中当前标的类型
	var type = <?php echo !!$biaos->itemtype ? $biaos->itemtype : 3;?>;
	$('.'+type).attr('checked','checked');
	// 默认选中当前标的还款类型
	$('#repaymenttype').val("<?php echo $biaos->repaymenttype?>");
	 // 切换同期的单位
	 $(':radio').click(function(){
	 	$('#circus').html($(this).next('label').html());	 	
	 	//alert(itemtype);
	 	if($(this).val() == 1){ // 秒标隐藏周期
	 		$('.zhouqi').hide();
	 	} else {
	 		$('.zhouqi').show();
	 	}
	 });

	$("#addForm").validate({
		rules: {
			"title": {
				required: true,
				maxlength: 25,
			},
			"money": {
				required:true,
				number:true,
			},
			"profityear":{
				required:true,
				number:true,
				max: 100,
			},
			"award":{
				required:true,
				number:true,
				max: 100,
			},
			"timelimit":{
				required:true,
				number: true,
			},
		},
		errorClass : 'ico error',
		errorPlacement: function(error, element) {  
	   		error.appendTo(element.parents('td'));  
		}
	});


	//计算收益函数, 3:月标; 2:天标; 1:秒标
	function expectprofit(){
		//获取一系列参数
		var profityear = $.trim($('#profityear').val());
		var award      = $.trim($('#award').val());
		var	timelimit  = $.trim($('#timelimit').val());
		var type       = $('input[name=itemtype]:checked').val();
		//alert(itemtype);
		//计算公式：10000*（借出总时间*利息 + 奖励）
		if ( profityear == '' || profityear == 0 ){
			return 0;
		}
		//如果是天标
		if ( type == 2 ){
			result = 10000*(timelimit*profityear/100/12/30 + award/100);
		//如果是秒标
		}else if( type == 1 ) {
			result = 10000*(profityear/100/12 + award/100);
		//如果是月标
		}else{
			result = 10000*(timelimit*profityear/100/12 + award/100);
		}
		return result.toFixed(2);
	}

	$('#profityear').keyup(function(){
		
		result = expectprofit();
		//alert(result);
		$('#expectprofit').val(result);

	})

	$('#award').keyup(function(){
		result = expectprofit();
		//alert(result);
		$('#expectprofit').val(result);

	})

	$(':radio').click(function(){
		
		result = expectprofit();
		//alert(result);
		$('#expectprofit').val(result);

	})

	$('#timelimit').keyup(function(){
		result = expectprofit();
		//alert(result);
		$('#expectprofit').val(result);

	})

});
</script>