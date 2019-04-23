
<style type="text/css">
	#prize_lottery {
margin: 10px auto;
margin-left: 66px;
margin-top: 20px;
}

#prize_lottery li {
float: left;
width: 200px;
height: 120px;
line-height: 120px;
margin: 1px;
font-size: 48px;
text-align: center;
color: #fff;
cursor: pointer;}
</style>

<ul id="prize_lottery"> 
	<li class="red" title="点击抽奖">1</li> 
	<li class="green" title="点击抽奖">2</li> 
	<li class="blue" title="点击抽奖">3</li> 
	<li class="purple" title="点击抽奖">4</li> 
	<li class="olive" title="点击抽奖">5</li> 
	<li class="brown" title="点击抽奖">6</li> 
</ul> 
<div class="clearboth" style="text-align:center; padding-top:10px;"><a style="display:none;" href="#" id="viewother">【翻开其他】</a></div> 
<div id="data"></div> 

<script>
$(function(){
	turnover("<?=$this->resultUrl?>" , <?=$this->lotid?>);

	//翻版抽奖查看其他奖项
	$("#viewother").click(function(){ 
		var mydata = $("#data").data("nolist"); //获取数据 
		var mydata2 = eval(mydata);//通过eval()函数可以将JSON转换成数组 

		$("#prize_lottery li").not($('#r')[0]).each(function(index){ 
			var pr = $(this); 
			pr.flip({ 
				direction:'bt', 
				color:'lightgrey', 
				content:mydata2[index], //奖品信息（未抽中） 
				onEnd:function(){ 
					pr.css({"font-size":"22px","line-height":"100px","color":"#333"}); 
					$("#viewother").hide(); 
				} 
			}); 
		}); 
		$("#data").removeData("nolist"); 
	}); 
});

</script>