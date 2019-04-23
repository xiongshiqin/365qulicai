<select style="width:111px;" name="<?php echo $this->provinceidname;?>" id="resideprovinceid">
	<option value="">请选择</option>
</select>								
<select style="width:111px;" name="<?php echo $this->cityidname;?>" id="cityid">
	<option value="">请选择</option>
</select>	

<script>
	$(document).ready(function(){
		var curPro = '<?php echo $this->curPro?>';  //记录当前省份 如果没有 默认为北京
		var curCity = '<?php echo $this->curCity?>';  //记录当前城市 如果没有默认为 市辖区
		// 获取省份信息
		var provinceurl = "/index.php?r=ajax/provinceData";
		var cityurl = "/index.php?r=ajax/cityData";
		$.get(provinceurl,'',function(result){
			var province = "";
			$.each(result,function(index,value){
				province += "<option class='"+index+"' value='"+index+"'>"+value+"</option>";
			});
			$('#resideprovinceid').html(province);
			$('.'+curPro).attr('selected',true); // 初始化省份信息
			$('.'+curPro).change(); // 加载城市信息

		},'json');	

		// 获取当前省份的城市信息
		$('#resideprovinceid').change(function(){
			$.get(cityurl,{'provinceid':$(this).val()},function(result){
				var city = "";
				$.each(result,function(index,value){
					city += "<option class='"+index+"' value='"+index+"'>"+value+"</option>";
				});
				$('#cityid').html(city);
				$('.'+curCity).attr('selected',true); // 初始化城市信息
			},'json');
		});
	});
</script>