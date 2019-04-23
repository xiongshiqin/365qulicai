<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'api', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a href="<?php echo $this->createUrl('/p/p2p/api' , array('cpid' => $cpid))?>">接口管理</a>		
				<a class="selected" href="<?php echo $this->createUrl('/p/p2p/apiTest' , array('cpid' => $cpid))?>">接口调试</a>
			</div>

			<!--管理页面-->
			<div class="block fatie">
				<table class="backstage_input" cellpadding="0" align="left" cellspacing="0" width="100%" border="0">
					<tr>
						<th width="12%">接口名称：</th>
						<td width="88%">
							<select id="apiName">
								<option key="">请选择接口</option>
								<?php foreach($companyApi->attributes as $k=>$v):?>
									<?php if($k == 'cpid') continue;?>
									<option key="<?=$k?>" value="<?=$v?>"><?=$unjsonDeclare[$k]['name'];?></option>
								<?php endforeach;?>
							</select>
						</td>
					</tr>
					<tr>
						<th>说&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;明：</th>
						<td><div class="grey" id="rule"></div></td>
					</tr>
					<tr>
						<th>地&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;址：</th>
						<td><input style="width:400px" id="api" type="text" value=""/></td>
					</tr>
					<tr>
						<th valign="top" style="padding-top:15px;">参&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;数：</th>
						<td><div id="args"></div></td>
					</tr>
					<tr>
						<th></th>
						<td><input class="btn_blue" type="button" value="测&nbsp;&nbsp;&nbsp;&nbsp;试" id="start"/></td>
					</tr>
					<tr>
						<th>返回结果：</th>
						<td>
							<textarea style="width:400px;height:100px;" id="result">
							</textarea>
						</td>
					</tr>
				</table>
			</div> 

		</div>
	</div>
</div>
<script>
	$(function(){
		// 隐藏其他tr
		$('tr :not(:first)').hide();

		// 选择接口名称
		$('#apiName').change(function(){
			var apiName = $(this).find("option:selected").attr('key');
			var data = $.parseJSON('<?=$declare?>');
			$('#api').val($(this).val()); // 地址
			$('#rule').html(data[apiName]['rule']); // 说明
			var args = "";
			$.each(data[apiName]['args'] , function(index , value){
				args += "<p style='margin-bottom:6px;'><span style='width:80px;text-align:right;display:inline-block;padding-right:8px'> " + value + " : </span><input type='text' class='attri' style='width:100px;' name='" + value + "'/></p>";
			});
			$('#args').html(args);
			$('tr').show();
		});

		// 开始测试
		$('#start').click(function(){
			var api = $('#api').val();
			var data = {
				'api' : api,
				'api_type' : $('#apiName').find("option:selected").attr('key'),
				};
			// 获取参数
			$(".attri").each(function(){
				var name = $(this).attr('name');
				var val = $(this).val();
				data[name] = val;
			});

			ajaxget("<?php echo $this->createUrl('apiResult' , array('cpid'=>$cpid))?>" , data , function(result){
				$('#result').html(result.data);
			} , function(result){
				show_message('error' , result.msg);
			});
		});
	});
</script>