<?php $this->widget('ext.kindeditor.KindEditorWidget' , array('items' => array('items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',)))); ?>
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
								<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress2_cur.png" />
								<p>上传奖品</p>
							</a>
						</li>
						<?php if($event->lotterytype): //如果有抽奖，则显示第三步?>
							<li class="lotteryAward">
								<a href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
									<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/progress3_unset.png" />
									<p>设置抽奖</p>
								</a>
							</li>
						<?php endif;?>
					</ol>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
			<?php if(!$award->awardname):?><!--如果为修改，则不显示其它奖品信息-->
			<!--管理页面-->
			<div class="block clearboth" style="margin:0;">
				<ul class="photo photos backstage_img">
					<?php if($awards):?>
						<?php foreach($awards as $v):?>
							<li class="award_<?php echo $v->awardid;?>">
								<a href=""><img src="<?php echo $v->awardpic?>" /></a>
								<div class="con">
									<a href="<?php echo $this->createUrl('/p/event/awardEdit',array('id'=>$v->awardid,'eventid'=>$event->eventid,'cpid'=>$cpid,'manage'=>$manage));?>"><i class="edit">编辑</i></a>
									<a href="javascript:void(0)" onclick="remAward(<?php echo $v->awardid?>);"><i>删除</i></a>
								</div>
								<p><?php echo $v->awardname;?><em class="grey">(<?=$v->num?>个)</em></p>
							</li>
						<?php endforeach;?>
					<?php endif?>
				</ul>
				<div class="clearboth"></div>
			</div>
			<?php endif;?>

			<!--上传奖品-->
			<div class="block fatie">
				<form class="backstage_input" id="awardForm" method="post" action="<?php echo $this->createUrl('/p/event/awardEdit',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">
					<input type="hidden" value="<?=$manage?>" name="manage"/>
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="eventid" value="<?php echo $event->eventid?>"/>
						<input type="hidden" name="id" value="<?php echo $award->awardid?>"/>
						<tr>
							<th width="15%">奖品名称：</th>
							<td width="85%"><input style="width:390px;" type="text"  name="awardname"/></td>
						</tr>
						<tr>
							<th>奖品数量：</th>
							<td><input style="width:390px;" type="text" name="num"/></td>
						</tr>
						<tr>
							<th>奖品类型：</th>
							<td>
								<?php foreach(Yii::app()->params['Event']['awardType'] as $k=>$v):?>
									<input<?php if($k==1) echo " checked='checked' "?> class="<?php echo $k;?>" style="width:14px; height:14px; border:0;" type="radio" value="<?php echo $k;?>" 
									name="awardtype" />
									<label><?php echo $v;?></label>
								<?php endforeach;?>
							</td>
						</tr>
						<tr style="display:none;" class="awardvalue">
							<th width="15%">红包/金币值：</th>
							<td width="35%">
								<input style="width:180px;" type="text" name="awardvalue"/>
								<span>用于自动发奖，该奖品所表示的红包/金币值，将按照此值自动发放到账户中</span>
							</td>
						</tr>
						<tr>
							<th>上传图片：</th>
							<td>
								<input type="hidden" name="awardpic" id="picurlVal" value="<?php echo $award->awardpic;?>"/>
								<img id="picurl" src="<?php echo $award->awardpic ? $award->awardpic : Yii::app()->params['default_upload_img']?>" width="100px" height="100px"/>
								<input class="upload_img" type="button" id="picurlUp" value="选择图片" />
								<span class="grey">长宽比最好为100:100,仅支持jpg/gif/png格式图片，大小不能超过2M</span>
							</td>
						</tr>
						<tr>
							<td></td>
							<td class="grey quote">
								<p><em>PS:</em>奖品请认真填写，活动发布后后便不可删除，只能编辑，一个活动最少添加3个奖品</p>
								<p>
									<cite>
									<?php if($manage || !$event->lotterytype):?>
										<a class="btn_blue" href="<?php echo $this->createUrl('/p/event/eventList',array('cpid'=>$cpid));?>">确定</a>
									<?php else:?>
										<?php if(count($awards) >= 3):?>
										<a class="btn_blue" href="<?php echo $this->createUrl('/p/event/lotteryAward',array('cpid'=>$cpid,'eventid'=>$event->eventid));?>">下一步</a>
										<?php endif;?>
									<?php endif;?>
									</cite>
									<input class="btn_blue" style="margin-right:15px; margin-top:3px;" type="submit" name="button" id="button" value="添&nbsp;&nbsp;&nbsp;&nbsp;加" />
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

	// 删除新闻
	function remAward(id){
		if(!window.confirm("确认删除吗？此操作不可回复")){
			return false;
		}
		$.post("<?php echo $this->createUrl('/p/event/awardDel')?>",{'awardid':id,'eventid':<?php echo $event->eventid;?>},function(result){
			if(result.status == true){
				$('.award_'+id).remove();
			}else{
				show_message('error',result.msg);
			}
		},'json');
	}


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

		$("#awardForm").validate({
			rules: {
				"awardname": {
					required: true,
				},
				"num": {
					required: true,
					number: true,
				},
				"awardvalue": {
					number:true,
				},
			},
			errorClass : 'ico error',
			errorPlacement: function(error, element) {  
		   		error.appendTo(element.parents('td'));  
			}
		});
	});
</script>