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
				<a class="selected" href="">发标播报</a>		
				<a href="">添加发标</a>	
				<a href="">发标列表</a>		
			</div>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="15%">标名称：</th>
							<td width="85%"><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>金额：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>年化：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>利率：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>还款方式：</th>
							<td>
								<select style="width:240px;" name="select" id="select">
									<option>等额本息</option>
									<option>先息后本（按月付息、到期还本）</option>
									<option>次性还本付息</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>标种类：</th>
							<td>
								<input style="width:14px; height:14px; border:0;" checked="checked" id="" type="radio" value="" name="radio" />
								<label>天标</label>
								<input style="width:14px; height:14px; border:0;" id="" type="radio" value="" name="radio" />
								<label>秒标</label>
								<input style="width:14px; height:14px; border:0;" id="" type="radio" value="" name="radio" />
								<label>月标</label>
							</td>
						</tr>
						<tr>
							<th>周期：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
						</tr>
						<tr>
							<th>预计发标时间：</th>
							<td><input type="text" name="textfield" id="textfield" /></td>
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
	// 删除新闻
	function remBiaos(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/p2p/newsDel')?>",{'id':id},function(result){
			if(result.status == true){
				$('.news_'+id).remove();
			}else{
				alert(result.msg);
			}
		},'json');
	}
</script>