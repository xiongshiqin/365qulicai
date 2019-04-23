<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'event', //选中状态
		)); ?>

		<div class="mainarea">

			<?php include dirname(__FILE__) . "/subHeader.php"?>
			<?php if(! $manage):?>
				<!--进度条-->
				<div class="block" >
					<ol class="progress">
						<li class="addEvent">
							<a href="<?php echo $this->createUrl('/p/event/addEvent',array('eventid'=>$event->eventid,'cpid'=>$cpid));?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress1_set.png" />
								<p>活动基本内容</p>
							</a>
						</li>
						<li class="setAward awardEdit">
							<a href="<?php echo $this->createUrl('/p/event/setAward',array('cpid'=>$cpid,'eventid'=>$event->eventid))?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress2_set.png" />
								<p>上传奖品</p>
							</a>
						</li>
						<li class="lotteryAward">
							<a href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress3_cur.png" />
								<p>设置抽奖</p>
							</a>
						</li>
					</ol>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
			<!--设置抽奖-->
			<div class="block fatie backstage_table" style="position:relative;">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/event/lotteryAwardEdit',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<input type="hidden" id="curLevel" name="lev" value="<?php echo $lev;?>"/><!--记录当前有几等级奖励,默认为三等级-->
						<?php if($lottery):?>
							<input type="hidden" name="lotid" value="<?php echo $lottery->lotid;?>"/>
						<?php endif;?>
						<tr>
							<th class="title" colspan="4" style="border-top:1px solid #e5e5e5;">
							<cite style="font-weight:normal;"><a href="javascript:void(0);" class="lotterysethelp">怎样设置抽奖概率？</a></cite>设置抽奖
							<!--弹出-->
								<div class="arrowicon" style="display:none;">
									<div class="eject">
										<p><em>PS：</em></p>
										<p>1、中奖概率是百分比，概率必须大于0且小数长度小于等于2</p>
										<p>2、奖品数量必须为大于0且小于等于奖品库存的正整数</p>
										<p>3、奖项必须为3-5个奖项，从一等奖到五等奖，按顺序填写，如果没有5项奖励，后面的可不填写。</p>
										<p>4、如果开启VIP限定，则VIP限定奖项概率总和小于等于100%，未限定的总和小于等于100，两种奖项概率单独计算</p>
									</div>
								</div>
							<!--弹出结束-->
							</th>
							
						</tr>
						
						<tr>
							<th width="40%">奖品名称</th>
							<th>中奖概率（百分比）</th>
							<th>奖品数量</th>
							<th>VIP限制</th>
						</tr>
						<?php if($lotteryAwards):?>
							<?php foreach($lotteryAwards as $k=>$v):?>
								<tr class="level_<?php echo $k;?> level_tr" <?php if(!$v->probability&&$k>2) echo " style='display:none;' "?>>
									<input type="hidden" name="lottery[<?php echo $k;?>][id]" value="<?php echo $v->id;?>"/>
									<td>
										<?php echo $chinanum[$k];?>等奖：
										<select name="lottery[<?php echo $k;?>][awardid]">
											<?php if($awards):?>
												<?php foreach($awards as $option):?>
													<option <?php if($option->awardid==$v->awardid) echo ' selected=selected ';?> value="<?php echo $option->awardid;?>"><?php echo $option->awardname;?></option>
												<?php endforeach;?>
											<?php endif;?>
										</select>
									</td>
									<td><input class="percent" style="width:70px;" type="text" name="lottery[<?php echo $k;?>][probability]"  value="<?php echo $v->probability;?>"/>&nbsp;%</td>
									<td><input class="awards_num" num="<?php foreach($awards as $option){  if($option->awardid==$v->awardid) echo $option->num; }?>" style="width:70px;" type="text" name="lottery[<?php echo $k;?>][awardnum]"  value="<?php echo $v->awardnum;?>"/></td>
									<td>
										<select class="select_vip" name="lottery[<?php echo $k;?>][vip]">
											<?php foreach(Yii::app()->params['Event']['vip'] as $key => $vip):?>
												<option <?php if($v->vip == $key) echo " selected='selected' "?> value="<?php echo $key;?>"><?php echo $vip;?></option>
											<?php endforeach;?>
										</select>
									</td>
								</tr>
							<?php endforeach;?>

						<?php else:?>

							<?php for($i=0;$i<5;$i++):?>
								<tr class="level_<?php echo $i;?>" <?php if($i>=3) echo " style='display:none;' ";?>>
									<td>
										<?php echo $chinanum[$i];?>等奖：
										<select name="lottery[<?php echo $i;?>][awardid]">
											<?php if($awards):?>
												<?php foreach($awards as $k=>$option):?>
													<option value="<?php echo $option->awardid;?>"><?php echo $option->awardname;?></option>
												<?php endforeach;?>
											<?php endif;?>
										</select>
									</td>
									<td><input style="width:70px;" type="text" name="lottery[<?php echo $i;?>][probability]" />&nbsp;‰</td>
									<td><input style="width:70px;" type="text" name="lottery[<?php echo $i;?>][awardnum]" /></td>
									<td>
										<select name="lottery[<?php echo $i;?>][vip]">
											<?php foreach(Yii::app()->params['Event']['vip'] as $key => $vip):?>
												<option value="<?php echo $key;?>"><?php echo $vip;?></option>
											<?php endforeach;?>
										</select>
									</td>
								</tr>
							<?php endfor;?>
						<?php endif;?>

						<tr>
							<td class="allfafang" colspan="4">
								<a id="addLevel" <?php if($lev>=5) echo " style='display:none;' ";?>>+增加</a>
								<a id="remLevel" <?php if($lev<=3) echo " style='display:none;' ";?>>－删除</a>
							</td>
							<div >
						</tr>
					</table>
			</div>
			
			<!--抽奖设置-->
			<div class="block fatie">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<th width="9%">抽奖时间：</th>
							<td>
								<?php 
									$this->widget('application.extensions.timepicker.timepicker', array(
									    'model'=>$lottery,
									    'name'=>'starttime',
									));
								?>
									&nbsp;&nbsp;到&nbsp;

								<?php 
									$this->widget('application.extensions.timepicker.timepicker', array(
									    'model'=>$lottery,
									    'name'=>'endtime',
									));
								?>
							</td>
						</tr>
						<tr>
							<th>VIP限定：</th>
							<td>
								<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->vip == 1) echo " checked='checked' "?>  type="radio" value="1" name="vip" />
								<label>是</label>
								<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->vip == 0) echo " checked='checked' "?> type="radio" value="0" name="vip" />
								<label>否</label>
							</td>
						</tr>
						<!-- <tr>
							<th>抽奖机会：</th>
							<td>
								<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->awardchance == 0) echo " checked='checked' "?>  type="radio" value="0" name="awardchance" />
								<label>一人一次</label>
								<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->awardchance == 1) echo " checked='checked' "?> type="radio" value="1" name="awardchance" />
								<label>邀请一人即增加一次抽奖机会</label>
							</td>
						</tr> -->
						<tr style="display:none;">
							<th>抽奖前提：</th>
							<td>
								<!-- <input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->awardprecondition == 0) echo " checked='checked' "?> type="radio" value="0" name="awardprecondition" />
								<label>点赞即可抽奖</label> -->
								<!-- <input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->awardprecondition == 1) echo " checked='checked' "?> type="radio" value="1" name="awardprecondition" />
								<label>关注平台才可抽奖</label> -->
								<!--现在只有关联帐号才能抽奖，因为有自动发奖功能，需要关联的p2pname-->
								<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->awardprecondition == 2) echo " checked='checked' "?> type="radio" value="2" name="awardprecondition" />
								<label>关注平台并绑定帐号才可抽奖</label>
							</td>
						</tr>
						<?php if(isset(CompanyApi::model()->findByPk($cpid)->lottery_api)):?>
							<tr>
								<th>虚拟货币自动发奖：</th>
								<td>
									<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->autogiving == 1) echo " checked='checked' "?>  type="radio" value="1" name="autogiving" />
									<label>是</label>
									<input style="width:14px; height:14px; border:0;" <?php if($lottery && $lottery->autogiving == 0) echo " checked='checked' "?> type="radio" value="0" name="autogiving" />
									<label>否</label>
								</td>
							</tr>
						<?php else:?>
							<input type="hidden" name="autogiving" value="0"/>
						<?php endif;?>
						<tr>
							<th>&nbsp;</th>
							<td class="quote">
								<!--<a href="http://www.licaipi.cn/index.php?r=p/p2p/setAward&cpid=13&eventid=2" class="a_step">上一步</a>-->
								<input class="btn_blue" type="button" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
							</td>
						</tr>
					</table>
					<div class="clearboth"></div>
				</form>
			</div>


		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// 增加
		$('#addLevel').click(function(){
			// 获取当前等级
			var curLevel = $('#curLevel').val();
			// 记录增加后的等级,并显示
			curLevel++;
			if(curLevel == 5){
				$('#addLevel').hide();
			}
			$('#remLevel').show();
			$('#curLevel').val(curLevel);
			$('.level_'+(curLevel-1)).show();
		});

		//删除 
		$('#remLevel').click(function(){
			// 获取当前等级
			var curLevel = $('#curLevel').val();
			$('.level_'+(curLevel-1)).hide();
			// 记录增加后的等级
			curLevel--;
			if(curLevel == 3){
				$('#remLevel').hide();
			}
			$('#addLevel').show();
			$('#curLevel').val(curLevel);
		});

		// 怎样设置概率？
		$('.lotterysethelp').mouseover(function(){
			$('.arrowicon').show();
		}).mouseout(function(){
			$('.arrowicon').hide();
		});
		
		//概率判断
		$('#button').click(function(){
			var selected=0;
			var flag = true;
			var i=0;
			var j=0;
			var n=0;
			var m=0;
			
			var level_length1=$('.level_tr[style="display:none;"]').length;
			var level_length=$('.level_tr').length-level_length1;
			$('.level_tr').each(function(){
				var val=$(this).find('.select_vip').val();
				i+=parseInt(val);
				if(i==level_length){ 
					alert("不能全为vip");
					flag=false;
					return false;
				}
				if(val==1){
					selected=1;
				}
			})	
			$('.level_tr').each(function(){  //库存判断
				var percent=parseInt($(this).find('.percent').val());
				var awards_num=parseInt($(this).find('.awards_num').val());//奖品数量
				var ku_num=parseInt($(this).find('.awards_num').attr('num'));  //库存
				if(awards_num>ku_num){
					alert('奖品数量必须小于库存')
					flag=false;
					return false;
				}
				if(percent<0){
					alert('所填的概率必须大于0')
					flag=false;
					return false;
				}
			})							
			if(selected==1){ //部分vip限定
				$('.level_tr').each(function(){
					var is_vip=$(this).find('.select_vip').val();
					if(is_vip==1){   //vip项
						var yy=$(this).find('.percent').val();
						n+=parseInt(yy);
					}else{
						var mm=$(this).find('.percent').val();
						m+=parseInt(mm);
					}
				})
				if(m>100){
					alert('vip不限项总和不能超过100%')
					flag=false;
					return false;
				}
				if(n>100){
					alert('vip限项总和不能超过100%')
					flag=false;
					return false;
				}
			}else{  //没有vip限定
				var tt=$('.percent').val()
				$('.level_tr').each(function(){
					var tt=$(this).find('.percent').val();
					j+=parseInt(tt);
				})
				if(j>100){
					alert('概率总和必须小于等于100%');
					flag=false;
					return false;
				}
			}
			if(flag){
				$('#form1').submit()
			}
		})	
		
		// 自动发奖点击事件，隐藏显示api
		$('[name=autogiving]').click(function(){
			if(1 == $(this).val()){
				$('[name=api]').	parents('tr').show();
			} else {
				$('[name=api]').parents('tr').hide();
			}
		});	
		
	});
</script>