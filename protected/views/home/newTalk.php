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
			<!--发起私信-->
			<div class="block fatie">
				<h3>
					<i>发起私信</i>
				</h3>
				<form method="post" action="<?php echo $this->createUrl('/home/sendTalk')?>">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<input type="hidden" name="fuid" value="<?php echo $fuser->uid?>"/>
						<tr>
							<td colspan="2" class="sixinren">写给<img src="<?php echo HComm::avatar($fuser->uid, 'm'); ?>" /><?php echo $fuser->username;?>：</td>
						</tr>
						<tr>
							<td valign="top">内容：</td>
							<td><textarea style="height:140px;" id="content" name="content" cols="45" rows="5" onKeyUp="fun(this)"></textarea>
							<p style="padding-right:85px;"><cite>您还可以输入<i id="s">255</i>个字符</cite>&nbsp;</p>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
							<input class="btn_blue" type="submit" name="button" id="button" value="发&nbsp;&nbsp;&nbsp;送" />
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