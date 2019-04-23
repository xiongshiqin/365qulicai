
<!--内容区-->
<div id="wrap">
	<div class="contentL">
		<div class="sideL">
			<!--左导航-->
			<div class="block" >
				<dl class="message_center" style="min-height:210px;">
					<dt>消息中心</dt>
					<dd><a href="<?php echo $this->createUrl('/home/msgList')?>">系统通知</a></dd>
					<dd  class="selected"><a href="<?php echo $this->createUrl('/home/talkList')?>">我的私信</a></dd>
				</dl>
			</div>
			
		</div>

		<div class="mainarea eight">
			<!--我的私信-->
			<div class="block activities user_post">
				<h3>
					<i>我与<?php echo $fuser->username?>的私信</i>
				</h3>
				<div class="more more1">
					<input type="hidden" id="talkpage" value='2'/>
					<a onclick="loadData()">查看更多对话</a>
				</div>

				<ul class="group dialogue" id="msgs">
					<?php foreach($talks as $v):?>
						<li class="review <?php if(Yii::app()->user->id == $v['uid']) echo " review_right ";?>">
							<div class="groupL">
								<a href="<?php echo $this->createUrl('/home/index' , array('uid' => $v['uid']));?>">
									<img src="<?php echo HComm::avatar($v['uid'], 'm'); ?>" />
								</a>
								<p><?php echo $v['username'];?></p>
							</div>
							<div class="bialog_box">
								<p><?php echo $v['content'];?></p>
								<div class="report">
									<p>
										<cite><a href="">举报</a></cite>
										<?php echo date('Y-m-d H:i:s' , $v['dateline']);?>
									</p>
								</div>
							</div>
							<div class="jiantou" <?php if(Yii::app()->user->id != $v['uid']) echo " style='left:70px;' ";?>>&nbsp;</div>
						</li>
					<?php endforeach;?>
				</ul>
				<div class="clearboth"></div>
			</div>

			<!--我的回复-->
			<div class="block fatie">
				<h3>
					<i>我的回复</i>
				</h3>
				<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
					<tr>
						<td valign="top">内容：</td>
						<td><textarea style="height:140px;" id="content" name="content" cols="45" rows="5" onKeyUp="fun(this)"></textarea>
						<p style="padding-right:85px;"><cite>您还可以输入<i id="s">255</i>个字符</cite>&nbsp;</p>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td style="padding:0;">
						<input class="btn_blue" type="submit" name="button" id="sendMsg" value="发&nbsp;&nbsp;&nbsp;送" />
						</td>
					</tr>
				</table>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>
<script>
	// 加载私信信息
	function loadData(){
		var url = "<?php echo $this->createUrl('/home/talkData');?>";
		var data = {
			'talkid' : <?php echo $talkid;?>,
			'page' : $('#talkpage').val(),
		};

		ajaxpost(url,data,function(result){
			if(result.data){
				$('#msgs').prepend(result.data);
				// 修改分页page大小 
				$('#talkpage').val(parseInt($('#talkpage').val()) + 1);
			} else {
				$('.more').html("<a>没有更多了</a>");
			}

		},function(result){
			show_message('error' , result.msg);
		});
	}

	$(function(){
		// 发送消息提交事件
		$('#sendMsg').click(function(){
			var data = {
				'content' : $('#content').val(),
				'fuid' : <?php echo $fuser->uid;?>
			};
			var url = "<?php echo $this->createUrl('/home/sendTalk');?>";
			ajaxpost(url,data,function(result){
				$('#msgs').append(result.data);
			},function(result){
				show_message('error' , result.msg);
			});
		});

	})
	
	/* 对话框字数限制 */
	function fun(obj){
		var n=obj.value.length
		if(n>=255){
			show_message('error' , '最多只能输入255个汉字');
			obj.value = obj.value.substring(0,255)
		}
		document.getElementById('s').innerHTML=255-obj.value.length; 
	}
</script>
