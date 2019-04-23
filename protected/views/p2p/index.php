<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">
			<!--公司介绍-->
			<div class="block ptwoplicai">
				<dl>
					<dt><a href="<?=$company->siteurl?>" target="_blank"><img src="<?php echo HComm::get_com_dir($company->cpid);?>" /></a></dt>
					<dd><a target="_blank" href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid'=>$company->cpid))?>">&gt;查看公司介绍</a><a target="_blank" href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid'=>$company->cpid))?>" style="margin:0;">&gt;查看公司证件</a></dd>
					<?php if(!Yii::app()->user->isGuest && CompanyEmployee::model()->exists("status = 1 and cpid = " . $company->cpid . " and uid = " . Yii::app()->user->id)):?>
						<dd style="text-align:left;"><a href="<?php echo $this->createUrl('/p/p2p/index',array('cpid'=>$company->cpid));?>">&gt;管理平台信息</a></dd>
					<?php endif;?>
				</dl>
			</div>

			<!--最新关注的派友-->
			<div class="block block1">
				<h3>最新粉丝</h3>
				<ul class="member">
					<?php if($fens):?>
						<?php foreach($fens as $v):?>
							<li>
								<a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>">
									<img src="<?php echo HComm::avatar($v->uid)?>" />
								</a>
								<p><a target="_blank" href="<?php echo $this->createUrl('/home/index' , array('uid'=>$v->uid))?>"><?php echo  $v->username;?></a></p>
							</li>
						<?php endforeach;?>
					<?php endif;?>
					
				</ul>
				<div style="clear:both;"></div>
			</div>

			<?php if($services):?>
			<!--联系我们-->
			<div class="block block1">
				<h3><!--cite class="grey">请说是来自理财派的派友</cite-->在线客服</h3>
				<ol class="quote contact">
						<?php foreach($services as $v):?>
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

			<!--新闻公告-->
			<div class="block block1">
				<h3>
					最新新闻
					<small><a target="_blank" href="<?php echo Yii::app()->createUrl('/p2p/newsList',array('cpid'=>$company->cpid));?>">（查看更多）</a></small>
				</h3>
				<ul class="msgtitlelist">
					<?php foreach($lastestNews as $news):?>
						<li><a target="_blank" href="<?php echo Yii::app()->createUrl('/news/view',array('id'=>$news->newsid))?>"><?php echo $news->title?></a></li>
					<?php endforeach;?>
				</ul>
			</div>
			<!--关注有惊喜-->
			<?php if($company->weixin):?>
				<div class="block block1 third_weixing">
					<h3>关注<em><?=$company->name?></em>订阅号</h3>
					<p><img src="<?php echo Yii::app()->request->baseUrl . $company->weixin; ?>" /></p>
				</div>
			<?php endif;?>
			<!--banner-->
			<!-- <div class="block banner small_banner">
				<a target="_blank" href="<?php echo HComm::getAdPicUrl(3,$company->cpid , 'url');?>">
					<img src="<?php echo HComm::getAdPicUrl(3,$company->cpid);?>" />
				</a>
			</div> -->

			<!--广告-->
			<?php if($src = HComm::getAdPicUrl(2 , $company->cpid)):?>
				<div class="banner_L">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(2 , $company->cpid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>

		</div>

		<div class="mainarea">
			<!--平台介绍-->
			<div class="block introduce">
				<h4><?php echo $company->name;?></h4>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
				  <tr>
					<th width="10%">平台网址：</th>
					<td colspan="2"><a target="_blank" href="<?=$company->siteurl?>"><?=$company->siteurl?></a></td>
					<td colspan="2" align="right">
					<em class="obvious">
					<span class='likenum'><?php echo $company->follow_num;?></span>粉丝<i>|</i><span><?php echo $company->view_num;?></span>浏览
					<!--<span><?php echo $company->event_num;?></span>活动-->
					</em>
					</td>
				  </tr>
				  <tr>
					<th>平台地址：</th>
					<td><?php echo $company->resideprovince;?>｜ <?php echo $company->city;?> </td>
					<th>上线时间：</th>
					<td colspan="2"><?php echo date('Y-m-d' , $company->onlinetime);?></td>
				  </tr>
				  <tr>
					<th>注册资金：</th>
					<td width="22%"><?php echo $company->capital?>万元</td>
					<th width="10%">周&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;期：</th>
					<td width="31%"><?php echo $company->cyclelow?$company->cyclelow:'一年'?>－<?php echo $company->cyclehigh?$company->cyclehigh:'一年';?></td>
					<td width="18%" class="join" rowspan="2" align="right">
						<div class="comRelation_<?php echo $company->cpid;?>">
							<?php $this->widget('CompanyRelationship' , array('cpid' => $company->cpid))?>
						</div>
						
					</td>
				  </tr>
				  <tr>
					<th>月&nbsp;收&nbsp;益&nbsp;：</th>
					<td><?=($company->profitlow)?>%－<?=($company->profithigh)?>%</td>
					<?php if($company->payment):?>
						<th>支付平台：</th>
						<td>
							<a href="<?php echo $this->createUrl('/business/index' , array('id'=>$company->payid));?>" target="_blank"><?=$company->payment;?> <?php if($company->host) echo "<span style='color: #de0808;'>&nbsp;&nbsp;资金托管</span>";?></a>
						</td>
					<?php endif;?>
				  </tr>
				</table>
				
				<!--更多-->
				<div class="more more1">
					<a target="_blank" href="<?php echo $this->createUrl('/p2p/othersInfo' , array('cpid'=>$company->cpid))?>">更多公司状况</a>
				</div>

			</div>
			
			<!--广告-->
			<?php if($src = HComm::getAdPicUrl(1 , $company->cpid)):?>
				<div class="banner_R">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(1 , $company->cpid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>

			<!--平台活动-->
			<?php if($events):?>
				<div class="block activities">
					<h3>
						平台活动
						<em class="obviouss">[<span><?php echo $company->event_num;?></span>活动]
					</h3>
					<table width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<th class="wenzi_R" style="padding-left:15px;" width="41%">标题</th>
							<th width="12%">活动类型</th>
							<th width="8%">人气</th>
						  	<th width="8%">关注</th>
							<th width="31%">时间</th>
						</tr>
						<?php foreach($events as $k=>$v):?>
							<tr class="<?php if($k==count($events)-1) echo 'last';?>">
								<td class="wenzi_R">
									<a target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail' , array('eventid'=>$v->eventid));?>">
										<?php echo $v->title;?>
									</a>
								</td>
								<td><?php echo Yii::app()->params['Event']['type'][$v->type]?></td>
								<td><?php echo $v->viewnum?></td>
								<td><?php echo $v->likenum;?></td>
								<td class="grey"><?php echo date('m-d H:i' , $v->starttime);?><small>&nbsp;至&nbsp;</small><?php echo date('m-d H:i' , $v->endtime);?></td>
							</tr>
						<?php endforeach;?>
					</table>

					<!--更多-->
					<div class="more">
						<a target="_blank" href="<?php echo $this->createUrl('/event/p2pEvents' , array('cpid' => $company->cpid , 'tab'=>'one'));?>">查看更多</a>
					</div>
				</div>
			<?php endif;?>

			<!--发标播报-->
			<div class="block activities broadcast">
				<h3>发标播报</h3>
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
					<?php if($biaos):?>
						<?php foreach($biaos as $key => $biao):?>
						<tr class=" <?php if($key==0) echo 'no_padding'; else if($key==count($biaos)-1) echo 'last'; ?>">
							<td width="40%">
								<p class="wenzi_R">
									<a target="_blank" href="<?php echo $biao->company->siteurl?>">
										<?php echo $biao->cpname?>－<?php echo $biao->title;?>
									</a>
								</p>
								<p>
								年化：<em style="margin-right:16px;"><?php echo $biao->profityear;?>%</em>
								奖励：<em><?php echo $biao->award;?>%</em>
								</p>
							</td>
							<td width="20%">
								<p><?php echo $biao->money;?><small>&nbsp;元</small></p>
								<p>
									期限：
									<em>
										<?php if($biao->itemtype == 1):?>
											秒标
										<?php elseif($biao->itemtype == 2):?>
											<?php echo $biao->timelimit;?>天
										<?php else:?>
											<?php echo $biao->timelimit;?>个月
										<?php endif;?>
									</em>
								</p>
							</td>
							<td width="20%">
								<p><?php echo Yii::app()->params['Biaos']['repaymenttype'][$biao->repaymenttype];?> </p>
								<p>万元收益：<em style="color:#FF7A25;"><?php echo $biao->expectprofit; ?></em></p>
							</td>
							<td width="20%">
								<p><?php echo date('m-d H:i',$biao->datelinepublish);?><small>&nbsp;发出</small></p>
								<p><a class="interest" href="javascript:void(0)" data-action="addBiaoLike" data-params="<?php echo $biao->id . ',' . $biao->cpid?>">感兴趣</a></p>
								<!-- <p class="quote"><a target="_blank" href="<?php echo $biao->company->siteurl?>">进入平台</a></p> -->
							</td>
						</tr>
						<?php endforeach;?>
					<?php endif;?>
				</table>

				<!--更多-->
				<div class="more">
					<a target="_blank" href="<?php echo $this->createUrl('/p2p/biaoList',array('cpid'=>$company->cpid));?>">查看更多</a>
				</div>

			</div>

			<!--平台相册-->
			<?php if(count($albums) > 0):?>
				<div class="block">
					<h3>平台相册</h3>
					<ul class="photo">
						<?php if($albums):?>
							<?php foreach($albums as $album):?>
							<li>
								<p>
									<a target="_blank" href="<?php echo $this->createUrl('/p2p/albumDetail' , array('albumid' => $album->id , 'cpid' => $company->cpid))?>">
										<img src="<?php echo Yii::app()->request->baseUrl.$album->url; ?>" />
									</a>
								</p>
							</li>
							<?php endforeach;?>
						<?php endif;?>
					</ul>

					<!--更多-->
					<div class="more clearboth">
						<a target="_blank" href="<?php echo $this->createUrl('/p2p/albumList',array('cpid'=>$company->cpid))?>">查看更多</a>
					</div>
				</div>
			<?php endif;?>
			
			
			<!--企业视频-->
			<?php if(count($videos) > 0):?>
				<div class="block" style="margin-bottom:5px;">
					<h3>企业视频<small><a target="_blank" href="<?php echo $this->createUrl('/p2p/videoList',array('cpid'=>$company->cpid));?>">（查看更多）</a></small></h3>
					<ul class="video">
						<?php if($videos):?>
							<?php foreach($videos as $video):?>
								<li><embed allowfullscreen="true" id="movie_player" width="330" height="240" type="application/x-shockwave-flash" src="<?php echo $video->url;?>" quality="high">
								<p><a><?php echo $video->title;?></a></p>
								</li>
							<?php endforeach;?>
						<?php endif;?>
					</ul>
					<div class="clearboth"></div>
				</div>
			<?php endif;?>
		</div>
		
	</div>
</div>