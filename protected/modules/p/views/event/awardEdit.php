<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'event', //选中状态
		)); ?>
		<div class="mainarea">
			<!--我的位置-->
			<div class="block position no_bg">
				<h4>
					<?php $this->widget('zii.widgets.CBreadcrumbs', array(
						'separator'=>' > ',
						'links' => array(
							'P2P理财'=>$this->createUrl('/p2p/list'),
							Company::model()->findByPk($cpid)->name => $this->createUrl('/p2p/index',array('cpid'=>$cpid)),
							'设置奖品' => 'javascript:void(0)',
							),
					)); ?><!-- breadcrumbs -->
				</h4>
			</div>
			
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
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress2_cur.png" />
								<p>上传奖品</p>
							</a>
						</li>
						<li class="lotteryAward">
							<a href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress3_unset.png" />
								<p>设置抽奖</p>
							</a>
						</li>
					</ol>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
			<!--上传奖品-->
			<div class="block fatie">
				<form class="backstage_input" id="form1" name="form1" method="post" action="<?php echo $this->createUrl('/p/event/awardEdit',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
					<input type="hidden" value="<?=$manage?>" name="manage"/>
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="eventid" value="<?php echo $event->eventid?>"/>
						<input type="hidden" name="id" value="<?php echo $award->awardid?>"/>
						<tr>
							<th>上传图片：</th>
							<td>
								<input type="hidden" name="awardpic" id="picurlVal" value="<?php echo $award->awardpic;?>"/>
								<img id="picurl" src="<?php echo $award->awardpic ? $award->awardpic : Yii::app()->params['default_upload_img']?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="picurlUp" value="选择图片" />
								<span class="grey">仅支持jpg/gif/png格式图片，大小不能超过2M</span>
							</td>
						</tr>
						<tr>
							<th width="15%">奖品名称：</th>
							<td width="85%"><input style="width:390px;" type="text" value="<?php echo $award->awardname;?>" name="awardname"/></td>
						</tr>
						<tr>
							<th>奖品数量：</th>
							<td><input style="width:390px;" type="text" value="<?php echo $award->num;?>" name="num"/></td>
						</tr>
						<tr>
							<th>奖品类型：</th>
							<td>
								<?php foreach(Yii::app()->params['Event']['awardType'] as $k=>$v):?>
									<input<?php if($k==$award->awardtype) echo " checked='checked' "?> class="<?php echo $k;?>" style="width:14px; height:14px; border:0;" type="radio" value="<?php echo $k;?>" 
									name="awardtype" />
									<label><?php echo $v;?></label>
								<?php endforeach;?>
							</td>
						</tr>
						<tr <?php if($award->awardtype == 1) echo ' style="display:none;" ';?>  class="awardvalue">
							<th width="15%">红包/金币值：</th>
							<td width="85%"><input style="width:390px;" type="text" value="<?php echo $award->awardvalue;?>" name="awardvalue"/></td>
						</tr>
						<tr>
							<td></td>
							<td class="grey quote">
								<p>
									<input class="btn_blue" style="margin-right:15px; margin-top:3px;" type="submit" name="button" id="button" value="确&nbsp;&nbsp;&nbsp;&nbsp;定" />
								</p>
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
	KindEditor.ready(function(K) {
		var editor = K.editor({
			allowFileManager : true
		});
		K('#picurlUp').click(function() {
			editor.loadPlugin('image', function() {
				editor.plugin.imageDialog({
					showRemote : false,
					imageUrl : K('#picurlup').val(),
					clickFn : function(url, title, width, height, border, align) {
						K('#picurlVal').val(url);
						K('#picurl').attr('src',url);
						editor.hideDialog();
					}
				});
			});
		});
	});

	$(function(){
		// 奖品类型切换
		$(':radio').click(function(){
			if($(this).val()==1){
				$('.awardvalue').hide();
				$('[name=awardvalue]').val(0);
			}else {
				$('.awardvalue').show();
			}
		});
	});
</script>