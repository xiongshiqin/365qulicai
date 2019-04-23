
<!--内容区-->
<div id="wrap">
	<div class="content">
		<!--我的位置-->
		<div class="block position no_bg">
			<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'separator'=>' > ',
			'links' => array(
				'P2P理财'=>$this->createUrl('/p2p/list'),
				$company->name => $this->createUrl('/p2p/index',array('cpid'=>$cpid)),
				'公司相册' => $this->createUrl('/p2p/albumList' , array('cpid' => $cpid)),
				),
			)); ?><!-- breadcrumbs -->
		</div>

	</div>

	<div class="contentR">
		<div class="sideR">
			<!--最新新闻-->
			<div class="block block1">
				<?php $this->widget("LastestNews",array('cpid'=>$cpid))?>
			</div>

		</div>

		<div class="mainarea">
			<!--图片内容-->
			<div class="block newsbulletin">
				<div class="photo_line">
					<span class="photo_R quote"><a href="<?php echo $this->createUrl('/p2p/albumList',array('cpid'=>$cpid))?>">&gt;浏览所有照片</a></span>
					<span class="photo_L grey">第<span class="order"></span>张/共<?php echo count($albums);?>张</span>
					<span class="quote">
					<a title="用方向键←可以向前翻页" class="pre">上一张</a>&nbsp;/				
					<a title="用方向键→可以向后翻页" class="next">下一张</a>
					</span>
				</div>
				<input type="hidden" value="<?php echo $albumid;?>" id="aid"/>
				<div id="parent">
					<?php foreach($albums as $v):?>
						<div class="album album_<?php echo $v->id?>" style="display:none;" val="<?php echo $v->id?>">
							<p style="text-align:center;">
							<img src="<?php echo BASE_URL . $v->url;?>" /></p>
						</div>
					<?php endforeach;?>
				</div>
			</div>

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
							<p>3楼</p>
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
							<p>4楼</p>
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
							<p>5楼</p>
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
				<div class="pages" style="clear:both;">
					<ul class="pagelist">
						<li><a href="" target="_blank">&lt;</a></li>
						<li><a href="" target="_blank">1</a></li>
						<li><a href="" target="_blank">2</a></li>
						<li class="thisclass"><a href="" target="_blank">3</a></li>
						<li><a href="" target="_blank">4</a></li>
						<li style="background:none;"><a href="" target="_blank">...</a></li>
						<li><a href="" target="_blank">50</a></li>
						<li><a href="" target="_blank">&gt;</a></li>
					</ul>
				</div>
			</div> 

			<div class="block" >
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
			</div>
			-->
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		// 显示点击的图片
		 var album_id = <?php echo $albumid;?>;
		$('.album_' + album_id).show();

		//初始化当前是第几张图片
		$('.order').html(parseInt( $('.album_' + album_id).index()) + 1);

		// 上一张
		$('.pre').click(function(){
			// alert('1');
			var cur = $('#aid').val();
			// 如果存在上一个,则当前消失，上一个显示，更新cur
			if($('.album_' + cur).prev().length != 0){
				$('.album_' + cur).prev().show();
				$('.album_' + cur).hide();
				$('#aid').val($('.album_' + cur).prev().attr('val'));
				$('.order').html(parseInt( $('.album_' + $('#aid').val()).index()) + 1); // 此处没用cur因为cur变了
			}
		});

		// 下一张
		$('.next').click(function(){
			// alert('2');
			var cur = $('#aid').val();
			if($('.album_' + cur).next().length != 0){
				$('.album_' + cur).next().show();
				$('.album_' + cur).hide();
				$('#aid').val($('.album_' + cur).next().attr('val'));
				$('.order').html(parseInt( $('.album_' + $('#aid').val()).index()) + 1);
			}
			
		})
	});
</script>