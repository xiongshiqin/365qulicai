<div class="main-title">
    <h2>编辑平台</h2>
</div>

<div>
	<form method="post" action="">
		<table>
			<input type="hidden" name="bid" value="<?=$business->bid?>"/>
			<tr>
				<th>平台简称：</th>
				<th><input type="text" name="shortname" value="<?=$business->shortname?>"/></th>
			</tr>
			<tr>
				<th>平台全称：</th>
				<th><input type="text" name="name" value="<?=$business->name?>"/></th>
			</tr>
			<tr>
				<th>网址：</th>
				<th><input type="text" name="siteurl" value="<?php echo isset($business->business_info->siteurl) ? $business->business_info->siteurl : '';?>"/></th>
			</tr>
			<tr>
				<th>地址：</th>
				<th><input type="text" name="address" value="<?php echo isset($business->business_info->address) ? $business->business_info->address : '';?>"/></th>
			</tr>
			<tr>
				<th><input type="submit" value="确认"/></th>
			</tr>
		</table>
		
	</form>
</div>
    
    
    
    
    