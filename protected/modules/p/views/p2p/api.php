<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
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
				<a class="selected" href="<?php echo $this->createUrl('/p/p2p/api' , array('cpid' => $cpid))?>">接口管理</a>		
				<a href="<?php echo $this->createUrl('/p/p2p/apiTest' , array('cpid' => $cpid))?>">接口调试</a>		
			</div>

			<!--管理页面-->
					<p class="help">帮助：
						请填写能够处理相应逻辑的请求地址，加上加密参数key，例如：
						http://www.***.com/api/relateApi.php?key=abcd
					</p>
			<div class="block backstage_table">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<th class="title" width="20%">接口名称</th>
						<th class="title" width="55%">地址</th>
						<th class="title" width="15%" >操作</th>
						<th class="title" width="10%">示例</th>
					</tr>
					<tr>
						<td>手机号获取账号名称</td>
						<td class="show"><?=$companyApi->relate_api?></td>
						<td class="set" style="display:none;">
							<input class="interface" type="text" name="relate_api" value="<?=$companyApi->relate_api?>"/>
							<input type="button" class="interest sub" value="确认"/>
						</td>
						<td class="edit"><?php echo $companyApi->relate_api ? '编辑' : '新增'?></td>
						<td><a target="_blank" href="<?php echo $this->createUrl('/ajax/download' , array('path' => './apiDemo/' , 'filename'=>'relate_api.php'));?>">下载demo</a></td>
					</tr>
					<tr>
						<td>检测用户名是否存在</td>
						<td class="show"><?=$companyApi->user_check?></td>
						<td class="set" style="display:none;">
							<input class="interface"  type="text" name="user_check" value="<?=$companyApi->user_check?>"/>
							<input type="button" class="interest sub"  value="确认"/>
						</td>
						<td class="edit"><?php echo $companyApi->user_check ? '编辑' : '新增'?></td>
						<td><a target="_blank" href="<?php echo $this->createUrl('/ajax/download' , array('path' => './apiDemo/' , 'filename'=>'user_check.php'));?>">下载demo</a></td>
					</tr>
					<tr>
						<td>活动发奖</td>
						<td class="show"><?=$companyApi->lottery_api?></td>
						<td class="set" style="display:none;">
							<input class="interface" type="text" name="lottery_api" value="<?=$companyApi->lottery_api?>"/>
							<input type="button" class="interest sub" value="确认"/>
						</td>
						<td class="edit"><?php echo $companyApi->lottery_api ? '编辑' : '新增'?></td>
						<td><a target="_blank" href="<?php echo $this->createUrl('/ajax/download' , array('path' => './apiDemo/' , 'filename'=>'lottery_api.php'));?>">下载demo</a></td>
					</tr>
				</table>
			</div> 
		</div>
	</div>
</div>
<script>
	$(function(){
		//编辑按钮
		$('.edit').click(function(){
			$(this).parent('tr').find('.show').hide().end().find('.set').show();
		});

		// 确认按钮
		$('.sub').click(function(){
			var name = $(this).prev('input').attr('name');
			var val = $(this).prev('input').val();
			var data = {
				'name' : name,
				'val' : val,
				'cpid' : "<?=$cpid?>",
			};
			ajaxpost("<?php echo $this->createUrl('/p/p2p/setApi')?>" , data , function(result){
				alert('修改成功');
				window.location.reload();
			} , function(result){
				show_message('error' , result.msg);
			});
		});
	});
</script>