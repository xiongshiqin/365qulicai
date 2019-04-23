<?php
	$newstype = substr($news->classid ,0 ,1);
	if($newstype == '3'){
		$this->redirect(array('/news/newsList')); // 防止直接输入id访问后台公告
	}
?>
<!--内容区-->
<div id="wrap">
	<div class="content">
		<div class="block position no_bg">
			<?php
			if($newstype == '2'){ // 行业新闻
				$cate = Yii::app()->params['News']['category'][substr($news->classid ,0 ,1)][$news->classid];
				 $this->widget('zii.widgets.CBreadcrumbs', array(
					'separator'=>' > ',
					'links' => array(
						'新闻'=>$this->createUrl('/news/newsList'),
						$cate => $this->createUrl('/news/newsList' , array('type'=>$cate)),
						),
				));
			} else {
				 $this->widget('zii.widgets.CBreadcrumbs', array(
					'separator'=>' > ',
					'links' => array(
						'P2P理财'=>$this->createUrl('/p2p/list'),
						$news->pname => $this->createUrl('/p2p/index',array('cpid'=>$news->pid)),
						'新闻列表' => $this->createUrl('/p2p/newsList',array('cpid'=>$news->pid)),
						),
				)); 
			}
			
			 ?><!-- breadcrumbs -->
		</div>
	</div>

	<div class="contentR">
		<div class="sideR" style="display: block; position: fixed; margin-left: 758px;">
			<!--最新新闻-->
			<div class="block block1">
				<?php $this->widget('LastestNews',array('type'=>'p2p','skin'=>'pic'));?>
			</div>	
			<!--广告-->
			<?php if(($expandCpid = Yii::app()->request->cookies['expandCpid']) && $src = HComm::getAdPicUrl(2 , $expandCpid)):?>
				<div class="banner_L">
					<a target="_blank" href="<?php echo HComm::getAdPicUrl(2 , $expandCpid , 'url');?>">
						<!-- <img src="html/images/banner_L2.jpg" /> -->
						<img src="<?php echo $src;?>"/>
					</a>
				</div>
			<?php endif;?>
		</div>
			
		<div class="mainarea">
			<!--新闻-->
			<div class="block newsbulletin">
				<h1><?php echo $news->title;?></h1>
				<div class="newsline grey">
					分类 : <?php echo Yii::app()->params['News']['category'][substr($news->classid ,0 ,1)][$news->classid];?>&nbsp;&nbsp;&nbsp;&nbsp;
					<?php echo $news->viewnum?> 浏览&nbsp;&nbsp;<?php echo date('Y-m-d',$news->dateline);?>
				</div>

				 <!--广告
				<?php if(($expandCpid = Yii::app()->request->cookies['expandCpid']) && $src = HComm::getAdPicUrl(1 , $expandCpid)):?>
					<div class="banner_R">
						<a target="_blank" href="<?php echo HComm::getAdPicUrl(1 , $expandCpid , 'url');?>">
							<img src="<?php echo $src;?>"/>
						</a>
					</div>
				<?php endif;?> -->

				<?php if($newstype == '2' && $news->summary):?>
					<blockquote><span style="color:#999;">摘要：</span><?php echo $news->summary;?></blockquote>
				<?php endif;?>
				<?php if($news->pic):?>
					<center><img src="<?=$news->pic?>"/></center>
				<?php endif;?>
				<p><?php echo $news->content;?></p>
			</div>

			<?php
				if(isset(Yii::app()->user->cpid) && Yii::app()->user->cpid){ //分享链接
			 		$shareUrl = Yii::app()->request->hostInfo . $this->createUrl('/news/view' , array('id'=>$news->newsid , 'cpid'=>Yii::app()->user->cpid));
			 		$shortUrl = HComm::sinaurl($shareUrl);
				} else {
			 		$shareUrl = Yii::app()->request->hostInfo . $this->createUrl('/news/view' , array('id'=>$news->newsid));
			 		$shortUrl = $shareUrl; // 此处都有shortUrl是避免sinaurl的解析与反解析占用访问时间
				}
				
			 ?>
			<blockquote>
				<cite  class="bshare">
					分享到：
					<!-- <a target="_blank" title="分享到QQ好友" href="http://connect.qq.com/widget/shareqq/index.html?url=<?php echo urlencode($shareUrl);?>&title=&desc=<?php echo '理财派：' . $news->title?>&summary=&site=licaipi&pics=<?php echo urlencode(Yii::app()->request->hostInfo . '/html/images/share_logo.jpg'); ?>"></a> -->
					<a target="_blank" title="分享到QQ好友" href="http://connect.qq.com/widget/shareqq/index.html?url=<?php echo urlencode($shareUrl);?>&title=<?php echo '365趣理财：' . $news->title?>&desc=<?php echo '365趣理财：' . $news->title?>&summary=&site=365qulicai&pics=<?php echo urlencode(Yii::app()->request->hostInfo . '/html/images/share_logo1.png'); ?>"></a>
					<!-- <a class="bshare-weixin" title="分享到微信" href=""></a> -->
					<a target="_blank" class="bshare-sinaminiblog" title="分享到新浪微博" href="http://service.weibo.com/share/share.php?url=<?php echo urlencode($shortUrl);?>&title=<?php echo '365趣理财：' . $news->title?>&appkey=1343713053&pic=<?php echo urlencode(Yii::app()->request->hostInfo . '/html/images/share_logo1.png'); ?>"></a>
					<a target="_blank" class="bshare-qzone" title="分享到QQ空间" href="http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo urlencode($shortUrl)?>&title=&desc=<?php echo '365趣理财：' . $news->title?>&summary=&site=365qulicai&pics=<?php echo urlencode(Yii::app()->request->hostInfo . '/html/images/share_logo1.png'); ?>"></a>
			
				</cite>
				<span>
					<?php echo $news->title;?>
					<em><a href="<?=$shareUrl?>"><?=$shareUrl?></a></em>
				</span>

			</blockquote>

			<?php $this->widget('CommentWidget',array('type'=>'1' , 'toid'=>$news->newsid));?>
		</div>
	</div>
</div>
<script type="text/javascript">
	var timer;
	$(function(){ 
		// 最新新闻随着鼠标滚动而滚动
		$(window).scroll(function(){
			clearInterval(timer);
			var topScroll=getScroll();
			timer=setInterval(function(){
			if(topScroll >= 200){
				$(".sideR").animate({"top":"0px"},0);
			} else {
				$(".sideR").animate({"top":"200px"},0);
			}
			},0)
		})
	})
</script>
