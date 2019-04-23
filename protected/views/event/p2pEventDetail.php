<!--内容区-->
<div id="wrap">
	<!--<div class="content">
		我的位置
		<div class="block position no_bg">
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'优惠活动'=>$this->createUrl('/event/p2pEvents'),
				$event->title => $this->createUrl('/event/p2pEventDetail',array('eventid'=>$event->eventid)),
				),
		)); ?>
		</div>

	</div>-->

	<div class="contentR">
		<div class="sideR">
			<!--第三方支付-->
			<div class="block ptwoplicai">
				<dl>
					<dt><a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $event->p2pid));?>"><img src="<?php echo HComm::get_com_dir($event->p2pid);?>" /></a></dt>
					<dd class="third_logo" style="margin-top:12px;">
						<?php $this->widget('CompanyRelationship' , array('cpid' => $event->p2pid))?>
					</dd>
				</dl>
			</div>

			<?php if($eventLike):?>
				<!--最近点赞的人-->
				<div class="block block1">
					<h3>最近点赞的粉丝<!--small><a href="">（查看更多）</a></small--></h3>
					<ul class="member">
						<?php foreach($eventLike as $v):?>
							<li>
								<a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><img src="<?php echo HComm::avatar($v->uid)?>" /></a>
								<p><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><?php echo $v->username;?></a></p>
							</li>
						<?php endforeach;?>
					</ul>
					<div style="clear:both;"></div>
				</div>
			<?php endif;?>

			<?php if($eventAwardLog):?>
				<!--奖励发放记录-->
				<div class="block block1">
					<h3>奖励发放记录<!--small><a href="">（查看更多）</a></small--></h3>
					<ul class="group business aeward_fafan">
						<?php foreach($eventAwardLog as $v):?>
							<li>
								<!--div class="groupL"><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><img src="<?php echo HComm::avatar($v->uid)?>" /></a></div-->
								<div class="groupR quote">
									<p><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><?php echo $v->username?></a>获得&nbsp;<em><?php echo $v->awardname;?></em></p>
								</div>
							</li>
						<?php endforeach;?>
					</ul>
					<div style="clear:both;"></div>
				</div>
			<?php endif;?>

			<?php if($companyServices):?>
				<!--联系活动主办方-->
				<div class="block block1">
					<h3>联系<?php echo $company->name;?>客服</h3>
					<ol class="quote contact">
						<?php foreach($companyServices as $v):?>
							<li>
							 	<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $v->qq;?>&site=qq&menu=yes">
								<img border="0" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/qq.jpg" alt="<?=$v->nickname?>" title="<?=$v->nickname?>"/>						
								<span style="position:relative;top:-3px;left:-3px;"><?php echo $v->nickname;?></span></a>
								<span style="position:relative;top:-3px;left:-1px; font-size:12px;"><?php echo $v->qq;?></span>
							</li>
						<?php endforeach;?>
						<div class="clearboth"></div>
					</ol>
				</div>
			<?php endif;?>

			<!--广告-->
			<?php if($src = HComm::getAdPicUrl(2 , $event->p2pid)):?>
				<div class="banner_L">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(2 , $event->p2pid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>

			<!--抽奖小秘绝-->
			<div class="block block1">
				<!-- <h3>抽奖小秘绝</h3> -->
				<div class="secret" style="">
					<!-- <p>1、关注平台并绑定帐号,中奖率提高20%</p> -->
					<p>抽奖攻略：邀请好友越多，中奖率越高</p>
					<!-- <p>3、平台投资越多，中奖率越高</p> -->
				</div>
			</div>
		</div>

		<div class="mainarea">
			<!--活动-->
			<div class="block introduce avti">
				<h4><?php echo $event->title;?></h4>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<th width="10%">活动时间：</th>
					<td colspan="3"><?php echo date('Y-m-d H:i',$event->starttime)?>　到　<?php echo date('Y-m-d H:i',$event->endtime)?></td>
					<td align="right">
					<em class="obvious">
					<span id="liked"><?php echo $event->likenum;?></span>人点赞
					<i>|</i><span><?php echo $event->viewnum;?></span>人浏览
					</em>
					
					</td>
				  </tr>
				  <tr>
					<th>发起平台：</th>
					<td width="15%"><a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid' => $event->p2pid));?>"><?php echo $company->name;?></a></td>
					<th width="10%">活动类型：</th>
					<td><?php echo Yii::app()->params['Event']['lotterytype'][$event->lotterytype]?></td>
					<td  class="grey event_<?php echo $event->eventid?>" align="right" valign="top" style="padding-top:4px; padding-right:4px;">
						<?php if(Yii::app()->user->id && EventLike::model()->exists("eventid  = " . $event->eventid . " and uid = " . Yii::app()->user->id)):?>		
							<span class="yizan_icon">已赞</span>
						<?php else:?>
							<a href="javascript:void(0)" class="praise"  data-action="likeEvent" data-params="<?php echo $event->eventid?>">
								<span>点赞</span>
							</a>
						<?php endif;?>
					</td>
				  </tr>
				</table>

				<!--活动内容-->
				<div class="block newsbulletin"  style="margin-top:20px;">			
					<h2>活动内容</h2>
					<p>
						<?php echo nl2br($event->event_field->content);?>
					</p>
				</div>


				<!--活动奖品-->
				<div class="block yellow">
					<h3>活动奖品</h3>
					<ul class="photo prize_img">
						<?php if($lotterySet):?>
							<?php foreach($lotterySet as $v):?>
								<li>
									<span><img src="<?php echo Yii::app()->request->baseUrl .  $v->event_award->awardpic; ?>" /></span>
									<p><em><?php echo $v->awardname;?></em></p>
								</li>
							<?php endforeach;?>
						<?php endif;?>
					</ul><div class="clearboth"></div>
				</div>

				<!--抽奖-->
				<div class="block yellow">
					<h3>点赞即可抽奖</h3>
					<?php 
						$this->widget('application.extensions.lotteryWidget.lotteryWidget', array(
						  'lotid' => $lottery->lotid,
						  'levnum' => $lottery->awardnum,
						  'lotterytype' => $event->lotterytype,
						));
					?>
					<div class="clearboth"></div>
				</div>

				<!--中奖名单-->
				<div class="block yellow clearboth">
					<h3>中奖名单</h3>
					<ul class="name_list">
						<?php if($lotteryAwardList):?>
							<?php foreach($lotteryAwardList as $v):?>
								<li>
									<cite><?php echo date('m-d H:i' , $v->dateline)?></cite>
									<p><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid' => $v->uid));?>"><?php echo $v->username;?></a><em>抽中</em><span style=""><?php echo $v->awardname;?></span></p>
								</li>
							<?php endforeach;?>
						<?php else:?>
							<span class="grey">　　暂无中奖名单</span>
						<?php endif;?>
					</ul>
					<div class="clearboth"></div>
				</div>

				<!--抽奖机会-->
				<?php if($myInfo):?>
					<div class="help clearboth" style="margin-bottom:35px;">
						<?php if($myInfo->log):?>
							我抽中：
							<em>
								<?php 
									foreach(unserialize($myInfo->log) as $log){ 
										echo $log . '　'; 
									}
								?>
							</em>
						<?php else:?>
							暂未获得奖品。
						<?php endif;?>　
						我还有<em><?=$myInfo->canlotterynum;?></em>次抽奖机会。
						我邀请了<em><?php echo $myInfo->invitenum;?></em>个人，获得了<em><?php echo $myInfo->invitenum;?></em>次抽奖机会
						
						<!--邀请好友 -->
						<?php if(Yii::app()->user->id):?>
							<?php if(EventLike::model()->exists("uid = " . Yii::app()->user->id . ' and eventid = ' . $event->eventid)):?>

								<p>邀请一个人可获得一次抽奖机会。<?php echo $inviteUrl?></p>
		
								<div style="margin:10px 0px;display:none;" class="eventInvite copy_link quote">
									
									<form action="">
										
										<!--input style="width:185px;" id="inviteUrl" type="input" name="" value="<?php echo $inviteUrl?>" -->
										<!--a href="javascript:void(0);" onclick="setCopy($('#inviteUrl').val());">复制链接</a-->
									</form>
								</div>
								<!-- <script>
								$(function(){
									$('#inviteRightNow').click(function(){
										$('.eventInvite').toggle();
									});
								})
								</script> -->
							<?php endif;?>
						<?php endif;?>
					</div>
				<?php endif;?>

			</div>


			

			<!--我的评论-->
		<!-- 	<div class="block" >
				<h3><i>我的评论</i></h3>
				<div class="my_comment">
					<span><em>加入小组</em>与12162人一起讨论"上班那些事儿"</span>
				</div>

				<form class="fatie" id="form1" name="form1" method="post" action="">
					<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
						<tr>
							<td style="padding-bottom:0;"><textarea style="width:722px;" name="textarea" id="textarea" cols="45" rows="5"></textarea></td>
						</tr>
						<tr>
							<td align="right"><input class=" btn_blue" type="submit" name="button" id="button" value="发&nbsp;&nbsp;布" /></td>
						</tr>
					</table>
				</form>

				<div style="clear:both"></div>
			</div> -->

			<!--全部评论-->
			<!-- <div class="block" >
				<h3><i>全部评论</i></h3>
				<ul class="group">
					<li class="review">
						<div class="groupL">
							<a href=""><img src="images/touxiang.png" /></a>
							<p>1楼</p>
						</div>
						<div class="groupR postC">
							<h5><cite>&nbsp;&nbsp;&nbsp;&nbsp;7月23日 08:42</cite><a href="">碧水白露</a></h5>
							<p>毕业以后为了爱情只身一人来到了成都这个城市，起先在成都一家知名的青年旅舍工作了一年时间，去年9月辞职追随着自己的梦想徒步搭车走了川藏线，后</p>
							<div class="ding_pl"><a href="">顶</a>[1]&nbsp;&nbsp;<a href="">评论</a></div>
						</div>
					</li>
					<li class="review">
						<div class="groupL">
							<a href=""><img src="images/touxiang.png" /></a>
							<p>2楼</p>
						</div>
						<div class="groupR postC">
							<h5><cite>&nbsp;&nbsp;&nbsp;&nbsp;7月23日 08:42</cite><a href="">碧水白露</a></h5>
							<p>毕业以后为了爱情只身一人来到了成都这个城市，起先在成都一家知名的青年旅舍工作了一年时间，去年9月辞职追随着自己的梦想徒步搭车走了川藏线，后</p>
							<div class="ding_pl"><a href="">顶</a>[1]&nbsp;&nbsp;<a href="">评论</a></div>
						</div>
					</li>

					<li class="review">
						<div class="groupL">
							<a href=""><img src="images/touxiang.png" /></a>
							<p>6楼</p>
						</div>
						<div class="groupR postC">
							<h5><cite>&nbsp;&nbsp;&nbsp;&nbsp;7月23日 08:42</cite><a href="">碧水白露</a></h5>
							<p class="quote">引用<a href="">@汀渚白沙</a>的话：专业课的书也可以么？实在没什么好书╮(╯_╰)╭同城…真的很少看到南昌的呢…这儿会有么…</p>
							<p>毕业以后为了爱情只身一人来到了成都这个城市，起先在成都一家知名的青年旅舍工作了一年时间，去年9月辞职追随着自己的梦想徒步搭车走了川藏线，后</p>
							<div class="ding_pl"><a href="">顶</a>[1]&nbsp;&nbsp;<a href="">评论</a></div>
						</div>
					</li>
					<li class="review">
						<div class="groupL">
							<a href=""><img src="images/touxiang.png" /></a>
							<p>7楼</p>
						</div>
						<div class="groupR postC">
							<h5><cite>&nbsp;&nbsp;&nbsp;&nbsp;7月23日 08:42</cite><a href="">碧水白露</a></h5>
							<p class="quote">引用<a href="">@汀渚白沙</a>的话：专业课的书也可以么？实在没什么好书╮(╯_╰)╭同城…真的很少看到南昌的呢…这儿会有么…</p>
							<p>毕业以后为了爱情只身一人来到了成都这个城市，起先在成都一家知名的青年旅舍工作了一年时间，去年9月辞职追随着自己的梦想徒步搭车走了川藏线，后</p>
							<div class="ding_pl"><a href="">顶</a>[1]&nbsp;&nbsp;<a href="">评论</a></div>
						</div>
					</li>
				</ul>
				<div class="clearboth"></div>
				 <div class="pages" style="clear:both;">
					<ul class="pagelist">
						这里是分页
					</ul>
				</div> 
			</div> -->
		</div>
	</div>
</div>
<script>
	function setCopy(_sTxt){
	try{
	if(window.clipboardData) {
	    window.clipboardData.setData("Text", _sTxt);
	} else if(window.netscape) {
	    netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
	    var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
	    if(!clip) return;
	    var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
	    if(!trans) return;
	    trans.addDataFlavor('text/unicode');
	    var str = new Object();
	    var len = new Object();
	    var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
	    var copytext = _sTxt;
	    str.data = copytext;
	    trans.setTransferData("text/unicode", str, copytext.length*2);
	    var clipid = Components.interfaces.nsIClipboard;
	    if (!clip) return false;
	    clip.setData(trans, null, clipid.kGlobalClipboard);
	}
	}catch(e){}
	}
</script>