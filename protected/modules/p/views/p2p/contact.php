<!--内容区-->
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=85497cd8ff8eb641fe07cb1b2c851c03"></script>
<style type="text/css">
	body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
</style>
<div id="wrap">
	<div class="contentL">
		<?php $this->widget('P2pMenu', array(
			'p2pid'=> $cpid,
			'selected' => 'contact', //选中状态
		)); ?>

		<div class="mainarea">
			<!--莱单-->
			<div class="block menu_btn">
				<a class="selected" href="">联系我们</a>
				<span>提示：拖动红色标记到相应位置即可完成设置</span>
			</div>

			<!--基本信息-->
			<div class="block" id="allmap" style="position:relative; width:800px; height:480px; margin-bottom:25px;">
			<!-- 	<p><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/backstage_map.png" /></p> -->
			</div>

		</div>
	</div>
</div>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("allmap");
	var point = new BMap.Point(<?php echo $company->lng;?>,<?php echo $company->lat;?>);

	// 如果为第一次设置，缩放级别为5，否则为15
	
	map.centerAndZoom(point,15);
	map.enableScrollWheelZoom(true);  // 可用鼠标放大引人缩小

	var marker = new BMap.Marker(point);// 创建标注
	map.addOverlay(marker);             // 将标注添加到地图中
	marker.enableDragging();           // 不可拖拽  marker.enableDragging();

	marker.addEventListener("dragend",function(e){
		var data = {
			'lat' : e.point.lat,
			'lng' : e.point.lng,
			'cpid': <?php echo $cpid;?>,
		}
		ajaxpost("<?php echo $this->createUrl('/p/p2p/setComCoords')?>",data,function(result){
			show_message('success' , result.msg);
		},function(result){
			show_message('error' , result.msg);
		});
	});
</script>