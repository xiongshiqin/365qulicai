
<!--大地图-->
<div id='bigmap1' style="position:relative; width:900px; height:500px; "></div>


<script>
	
	
	var map1 = new BMap.Map("bigmap1");
	var point1 = new BMap.Point(<?php echo $company->lng;?>,<?php echo $company->lat;?>);
	map1.centerAndZoom(point1,15);
	map1.enableScrollWheelZoom(true); //可用鼠标滚轮放大缩小

	map1.centerAndZoom(point1,15);
	var marker1 = new BMap.Marker(point1);// 创建标注
	map1.addOverlay(marker1);             // 将标注添加到地图中
	//marker.enableDragging();           // 可拖拽
	marker1.disableDragging(); //标注不可拖动


</script>
