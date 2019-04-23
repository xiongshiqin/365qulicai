<div class="main-title">
    <h2>生成url</h2>
</div>
<div>
	<form method="post" action="">
		<table>
			<tr>
				<td>
					用户id:
				</td>
				<td>
					<input type="text" name="uid"/>
				</td>
			</tr>	
			<tr>
				<td>第三方支付：</td>
				<td>
					<select name="bid">
						<?php foreach($business as $v):?>
						<option value="<?=$v->bid?>"><?=$v->shortname?></option>	
						<?php endforeach;?>	
					</select>
				</td>
			</tr>
			<tr>
				<td>有效期：</td>
				<td>
					<input type="text" name="vali_time" value="5"/>天
					<span class="grey">最少一天，填写数字</span>
				</td>
			</tr>
			<tr><td><input type="submit" value="提交"/></td></tr>
		</table>
	</form>
</div>