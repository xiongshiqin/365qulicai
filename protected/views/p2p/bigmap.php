<!--内容区-->
<div id="wrap">

	<div class="content">
		<div class="block position no_bg">
		公司地址：<?php echo $company->resideprovince . $company->city . $company->address;?>
		</div>
	</div>
	<div id='bigmap' style="position:relative; width:1024px; height:600px; ">
		
	ssss

	</div>

</div>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=85497cd8ff8eb641fe07cb1b2c851c03"></script>
<script type="text/javascript">
	// 百度地图API功能
	var map = new BMap.Map("bigmap");
	var point = new BMap.Point(<?php echo $company->lng;?>,<?php echo $company->lat;?>);
	map.centerAndZoom(point,15);
	map.enableScrollWheelZoom(true); //可用鼠标滚轮放大缩小

	map.centerAndZoom(point, 15);
	var marker = new BMap.Marker(point);// 创建标注
	map.addOverlay(marker);             // 将标注添加到地图中
	// marker.enableDragging();           // 可拖拽
	marker.disableDragging(); //标注不可拖动

</script>