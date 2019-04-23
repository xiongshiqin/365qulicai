<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'info', //选中状态
		)); ?>

		<div class="mainarea">
		
			<?php echo $this->renderPartial('infoSetHeader' , array('cpid' => $cpid , 'do' => 'base')); ?>

			<!--基本信息-->
			<div class="block fatie">
				<form class="backstage_input" id="infoForm" method="post" action="<?php echo $this->createUrl('/p/p2p/info');?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="cpid" value="<?php echo $cpid;?>" />
						<tr>
							<th width="15%">网站地址：</th>
							<td width="85%">
								<span><?=$company->siteurl?></span>
							</td>
						</tr>
						<tr>
							<th>所在地：</th>
							<td>
								<span><?=$company->resideprovince . ' ' . $company->city?></span>
							</td>
						</tr>
						<tr>
							<th>运营总监姓名：</th>
							<td>
								<span><?=$company->company_info->operation_name?></span>
							</td>
						</tr>
						<tr>
							<th>运营总监电话：</th>
							<td>
								<span><?=$company->company_info->operation_mobile;?></span>
							</td>
						</tr>
						<tr>
							<th>上线时间：</th>
							<td>
								<span><?php echo date('Y-m-d' , $company->onlinetime);?></span>
							</td>
						</tr>
						<tr><td colspan='2'><hr/></td></tr>
						<tr>
							<th>详细地址：</th>
							<td><input type="text" name="address" value="<?php echo $company->address;?>"/></td>
						</tr>
						<tr>
							<th>注册资金：</th>
							<td><input type="text" name="capital"  value="<?php echo $company->capital;?>"/><span>&nbsp;万元&nbsp;</span></td>
						</tr>
						<?php if($company->payid):?>
							<tr>
								<th>资金托管：</th>
								<td>
									<input style="width:14px; height:14px;" type="radio" <?php if($company->host == 1) echo "checked='checked'";?> name="host" value="1"/>
									<label>是</label>
									<input style="width:14px; height:14px;" type="radio" <?php if($company->host == 0) echo "checked='checked'";?> name="host" value="0"/>
									<label>否</label>
								</td>
							</tr>
						<? else: ?>
							<input type="hidden" name="host" value="0"/>
						<?php endif;?>
						<tr>
							<th>月标总收益：</th>
							<td>
								<input type="text" style="width:91px;" name="profitlow"  value="<?php echo $company->profitlow;?>"/><span>&nbsp;%&nbsp;到</span> 
								<input type="text" style="width:91px;" name="profithigh"  value="<?php echo $company->profithigh;?>"/><span>&nbsp;%</span>
								<span class="ico error" id="profitlow-error">月标利率加上奖励</span>
							</td>
						</tr>
						<tr>
							<th>标的周期：</th>
							<td>
								<input type="text" style="width:100px;" name="cyclelow" value="<?php echo $company->cyclelow ? $company->cyclelow : '一个月';?>"/><span>&nbsp;到</span> 
								<input type="text" style="width:100px;" name="cyclehigh" value="<?php echo $company->cyclehigh ? $company->cyclehigh : '三个月';?>"/>
							</td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">LOGO：</th>
							<td>
								<img id="logo" src="<?php echo HComm::get_com_dir($company->cpid);?>" width="200px" height="60px"/>
								<input class="upload_img" type="button" id="logoUp" value="选择图片" />
								<span>Logo尺寸最好为200*60</span>
							</td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">小LOGO：</th>
							<td>
								<img id="slogo" src="<?php echo HComm::get_com_dir($company->cpid , 's');?>" width="40px" height="40px"/>
								<input class="upload_img" type="button" id="slogoUp" value="选择图片" />
								<span>小Logo尺寸最好为35*35</span>
							</td>
						</tr>
						<tr>
							<th valign="top" style="padding-top:12px;">微信：</th>
							<td>

								<img id="weixin" src="<?php echo ($company->weixin)?$company->weixin : Yii::app()->params['default_upload_img'];?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="weixinUp" value="选择图片" />
								<span>可不填</span>
								<input type="hidden" name="weixin" value="<?php echo $company->weixin;?>"/>
							</td>
						</tr>
						<tr>
							<th>企业QQ：</th>
							<td><input type="text" name="qq"  value="<?php echo $company->qq;?>"/></td>
						</tr>
						<tr>
							<th>&nbsp;</th>
							<td><input class="btn_blue" type="submit" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" /></td>
						</tr>
					</table>
				</form>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		var tips = '<?php echo Yii::app()->user->getFlash("saveBaseInfo");?>';
		if(tips) show_message('success' , tips);


	$.validator.addMethod("phoneNo", function (value, element) {
		            var length = value.length;
		            // var regex = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
		            var regex = /^1+([2|3|4|5|6|7|8|9]{1})+([0-9]{1})+\d{8}$/;  
		            return this.optional(element) || (length == 11 && regex.test(value));
	        	}, "<img src='/html/images/tan.png' />手机号码格式错误");
		// 验证框架使用方法 需要name
		$("#infoForm").validate({
			rules: {
				"siteurl": {
					required: true,
					url:true,
				},
				"address":{
					required:true,
				},
				"capital": {
					required:true,
					number : true,
				},
				"profitlow":{
					required:true,
					number:true,
				},
				"profithigh":{
					required:true,
					number:true,
				},
				"cyclelow":{
					required:true,
				},
				"cyclehigh":{
					required:true,
				},
				"payment":{
					required:true,
				},
				"operation_name":{
					required:true,
				},
				"operation_mobile":{
					required:true,
					phoneNo:true,
				},
				"qq":{
					number:true,
				},
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td'));  
			}
		});

	});

	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
			// 如果上传的为公司logo  则增加 isCom : 公司id
			isCom: <?php echo $company->cpid?>,
		});
		K('#logoUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#logoUp').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#logo').attr('src',url+"?t="+Math.random());
						editor.hideDialog();
					}
				});
			});
		});
	});

	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
			// 如果上传的为公司logo  则增加 isCom : 公司id
			isCom: <?php echo $company->cpid?>,
			comType : 's',
		});
		K('#slogoUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#slogoUp').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#slogo').attr('src',url+"?t="+Math.random());
						editor.hideDialog();
					}
				});
			});
		});
	});

	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true,
		});
		K('#weixinUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#weixinUp').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#weixin').attr('src',url+"?t="+Math.random());
						K('[name=weixin]').val(url);
						editor.hideDialog();
					}
				});
			});
		});
	});
</script>