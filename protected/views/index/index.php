<!--广告-->
 <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/slick.min.js"></script>

<style>
ul{list-style:none;}
.clearfix{clear:both;}
/*滚动banner图*/
 .slick {position: relative;}
 .slick .slick-list li{ width:100% ;overflow: hidden; height: 30%;}
 .slick .slick-list li img{width: 100%;height:188px;}
 .slick .slick-list li a{ display: block;width: 100%;}
 .slick .slick-dots{ position: absolute; bottom: 0.5em; left: 0;width: 100%; text-align: center;}
 .slick .slick-dots li{ display: inline-block;float: none}
 .slick .slick-dots li button{ float: left; border: none; background-color: #ccc; border-radius: 50%;font-size: 0;padding: 5px;margin-right: 5px;}
 .slick .slick-dots .slick-active button{ background-color: #ff6600;}
</style>


<style>
/* Slider */
.slick-slider
{
    position: relative;

    display: block;

    -moz-box-sizing: border-box;
         box-sizing: border-box;

    -webkit-user-select: none;
       -moz-user-select: none;
        -ms-user-select: none;
            user-select: none;

    -webkit-touch-callout: none;
    -khtml-user-select: none;
    -ms-touch-action: pan-y;
        touch-action: pan-y;
    -webkit-tap-highlight-color: transparent;
}

.slick-list
{
    position: relative;

    display: block;
    overflow: hidden;

    margin: 0;
    padding: 0;
}
.slick-list:focus
{
    outline: none;
}
.slick-list.dragging
{
    cursor: pointer;
    cursor: hand;
}

.slick-slider .slick-track,
.slick-slider .slick-list
{
    -webkit-transform: translate3d(0, 0, 0);
       -moz-transform: translate3d(0, 0, 0);
        -ms-transform: translate3d(0, 0, 0);
         -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);
}

.slick-track
{
    position: relative;
    top: 0;
    left: 0;

    display: block;
}
.slick-track:before,
.slick-track:after
{
    display: table;

    content: '';
}
.slick-track:after
{
    clear: both;
}
.slick-loading .slick-track
{
    visibility: hidden;
}

.slick-slide
{
    display: none;
    float: left;

    height: 100%;
    min-height: 1px;
}
[dir='rtl'] .slick-slide
{
    float: right;
}
.slick-slide img
{
    display: block;
}
.slick-slide.slick-loading img
{
    display: none;
}
.slick-slide.dragging img
{
    pointer-events: none;
}
.slick-initialized .slick-slide
{
    display: block;
}
.slick-loading .slick-slide
{
    visibility: hidden;
}
.slick-vertical .slick-slide
{
    display: block;

    height: auto;

    border: 1px solid transparent;
}
.slick-arrow.slick-hidden {
    display: none;
}
</style>

<div class='index-banner'>

<ul class="slick">
		<li><a href="https://www.lezhudai.com/?action=platform.register_guide&r=effd24d00a0fffcd6400a30cd49365cd">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/lezhudaiadv.jpg"/></a></li>
		<li><a href="https://www.lezhudai.com/?action=platform.register_guide&r=effd24d00a0fffcd6400a30cd49365cd">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/lezhudaiadv.jpg"/></a></li>
		<li><a href="https://www.lezhudai.com/?action=platform.register_guide&r=effd24d00a0fffcd6400a30cd49365cd">
		<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/lezhudaiadv.jpg"/></a></li>
</ul>

</div>


<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR">
			<!--热门用户-->
			<div class="block new-block">
				<h3>热门用户</h3>
				<ul class="member" style="margin-top:10px;">
					<?php foreach($users as $user):?>
						<li style="margin:5px 7px;">
							<a href="javascript:void(0);"><img src="<?php echo HComm::avatar($user->uid);?>" /></a>
							<p><a href="javascript:void(0);"><?=$user->username?></a></p>
						</li>
					<?php endforeach;?>
				</ul>
				<div style="clear:both;"></div>
			</div>

			<!--平台公告新闻-->
			<!-- <div class="block new-block auto">
				<h3><cite><a target="_blank" href="<?php echo $this->createUrl('/p2p/newsNotice')?>">更多&gt;&gt;</a></cite>平台活动</h3>
				<ul class="msgtitlelist" style="padding:0;">
					<?php foreach($events as $n):?>
					<li class="nobgli">
						<span>【<a target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid'=>$n->p2pid));?>"><?=$n->company->name?></a>】</span>
						<a target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail' , array('eventid'=>$n->eventid));?>"><?=$n->title;?></a>
					</li>
				<?php endforeach;?>
				</ul><div class="clearboth"></div>
			</div> -->

			<!--广告-->
			<!-- <div class="block" style="height:102px;">
				<img src="html/images/money_banner.jpg" width="266px" height="102px" />
			</div> -->
		</div>

		<div class="mainarea">
			<!--最新推荐-->
			<div class="block new-block clearboth">
				<h3><cite><a target="_blank" href="<?php echo $this->createUrl('/news/newsList')?>">更多&gt;&gt;</a></cite><i>热门新闻</i></h3>
				<ul class="industry_news">
					<li class="index_news">
						<div class="industry_newsL">
							<a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[0]['newsid']))?>"/><img src="<?=$p2pNews[0]['pic']?>" /></a>
						</div>
						<div class="industry_newsR">
							<h5><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[0]['newsid']))?>"><?=$p2pNews[0]['title']?></a></h5>
							<p><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[0]['newsid']))?>"><?=$p2pNews[0]['summary']?></a><a class="with_blue" href="">[详细]</a></p>
						</div>
					</li>	
					<li class="index_news">
						<div class="industry_newsL">
							<a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[1]['newsid']))?>"/><img src="<?=$p2pNews[1]['pic']?>" /></a>
						</div>
						<div class="industry_newsR">
							<h5><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[1]['newsid']))?>"><?=$p2pNews[1]['title']?></a></h5>
							<p><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[1]['newsid']))?>"><?=$p2pNews[1]['summary']?></a><a class="with_blue" href="">[详细]</a></p>
						</div>
					</li>
				</ul><div class="clearboth"></div>				
				
				<ul class="msgtitlelist" style="padding-bottom:7px;">
					<?php for($i=2;$i<count($p2pNews);$i++):?>
						<li class="news_list"><a target="_blank" href="<?php echo $this->createUrl('/news/view' , array('id'=>$p2pNews[$i]['newsid']))?>"><?=$p2pNews[$i]['title']?></a></li>
					<?php endfor;?>
				</ul><div class="clearboth"></div>
			</div>

			<!--最新活动-->
			<!-- <div class="block new-block clearboth">
				<h3><cite><a target="_blank" href="<?php echo $this->createUrl('/event/p2pEvents')?>">更多&gt;&gt;</a></cite><i>最新活动</i></h3>
				<ol class="luckdraw">
				<?php foreach($lotteryEvents as $event):?>
						<li>
							<h4><a target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail' , array('eventid'=>$event->eventid));?>"><?=$event->company->name?>－<?=$event->title?></a></h4>
							<div class="luckdraws">
								<div class="luckdrawL"><img src="<?php echo Yii::app()->request->baseUrl . '/html/images/luckdrawimg' . $event->lotterytype . '.jpg'; ?>" /></div>
								<div class="luckdrawR">
									<h5>
										<?=Yii::app()->params['Event']['lotterytype'][$event->lotterytype]?>
									</h5>
									<p>活动时间：<?php echo date('Y-m-d h:i' , $event->starttime);?></p>
									<p>结束时间：<?php echo date('Y-m-d h:i' , $event->endtime);?></p>
								</div>
								<div class="clearboth"></div>
							</div>
							<p><em><?=$event->likenum?></em>人己成功抽到大奖</p>
							<p><a class="canyu_btn" target="_blank" href="<?php echo $this->createUrl('/event/p2pEventDetail' , array('eventid'=>$event->eventid));?>">立即参与</a></p>
						</li>
					<?php endforeach;?>
				</ol>
				<div class="clearboth"></div>
			</div> -->
		</div>
	</div>
	
	<div class="content">
		<!--热门平台-->
		<div class="block navigation new-block">
			<h3><cite><a target="_blank" href="<?php echo $this->createUrl('/p2p/list')?>">更多&gt;&gt;</a></cite><i>热门平台</i></h3>
			<ul class="my_platformy new_platform">
				<?php foreach($companies as $company):?>
					<li class='companies'>
						<p class="logoimg"><a target="_blank" href="<?=$company->siteurl?>"><img src="<?php echo HComm::get_com_dir($company->cpid);?>" /></a></p>
						<div class="navigation_text">
							<p><i>月收益：</i><?=$company->profitlow?>%-<?=$company->profithigh?>%</p>
							<!--p><i>活&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;动：</i><?=$company->event_num?></p-->
							<p><i>粉&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;丝：</i>
							<?=$company->follow_num?>
							
							</p>
						</div>
						<div class="join" style="display:none;">
							<div class="comRelation_<?php echo $company->cpid;?>">
								<?php $this->widget('CompanyRelationship' , array('cpid' => $company->cpid))?>
							</div>
						</div>
					</li>
				<?php endforeach;?>
			</ul>
			<div class="clearboth"></div>
		</div>
	</div>
	
	<div class="content">
		<!--新标播报-->
		<!-- <div class="block new-block">
			<h3><cite><a target="_blank" href="<?php echo $this->createUrl('/p2p/choiceBiao')?>">更多&gt;&gt;</a></cite><i>新标播报</i></h3>
			<ol class="luckdraw newprofit">
				<?php foreach($biaos as $biao):?>
					<li>
						<h4><a target="_blank" href="<?php echo $this->createUrl('p2p/index' , array('cpid'=>$biao->cpid));?>">
							<img src="<?php echo HComm::get_com_dir($biao->cpid , 's')?>" />
							<?=$biao->cpname?>－<?=$biao->title;?></a></h4>

						<div class="profit">
							<div>万元收益<i><small>￥</small><?=$biao->expectprofit?></i></div>
							<p>标金额 : <?=$biao->money?>元</p>
						</div>
					
						<table class="broadcasts" cellpadding="0"  cellspacing="0" border="0" width="100%">
							<tr>
								<th width="30%">类型</th>
								<td><?=Yii::app()->params['Biaos']['itemtype'][$biao->itemtype]?></td>
							</tr>
							<tr>
								<th>年利率</th>
								<td><?=$biao->profityear?>%</td>
							</tr>
							<tr>
								<th>奖励</th>
								<td><?=$biao->award?>%</td>
							</tr>
							<tr>
								<th>期限</th>
								<td>	
									<?php if($biao->itemtype == 1):?>
										秒标
									<?php elseif($biao->itemtype == 2):?>
										<?php echo $biao->timelimit;?>天
									<?php else:?>
										<?php echo $biao->timelimit;?>个月
									<?php endif;?>
								</td>
							</tr>
							<tr>
								<th>发出时间</th>
								<td><?=date('m-d h:i' , $biao->datelinepublish)?></td>
							</tr>
						</table>
						<p style="text-align:center;"><a class="canyu_btn" target="_blank" href="<?php echo $this->createUrl('/p2p/index' , array('cpid'=>$biao->cpid));?>">了解详情</a></p>
					</li>
				<?php endforeach;?>
			</ol>
			<div class="clearboth"></div>
		</div> -->
	</div>
</div>
<script>
	$(function(){
		$('.companies').hover(function(){
			$('.join').hide();
			$(this).find('.join').show();
		}) 
	});

	$(document).ready(function(){
	 	$('.slick').slick({
			dots:true,
			autoplay:true,
			autoplaySpeed:2000,
			arrows:false,
			}); 
	});	

</script>
