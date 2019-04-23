  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery.colorbox.js"></script>
<span id="datarbs"
	addrelation-url = "<?php echo $this->createUrl('/ajax/addRelation')?>" 
	remrelation-url = "<?php echo $this->createUrl('/ajax/remRelation')?>" 
	addcomrelation-url = "<?php echo $this->createUrl('/ajax/addComRelation')?>" 
	relate-com-url = "<?php echo $this->createUrl('/ajax/relateCom')?>" 
	remcomrelation-url = "<?php echo $this->createUrl('/ajax/remComRelation')?>" 
	set-follow-comuser = "<?php echo $this->createUrl('/ajax/setFollowComUser')?>"
	like-event = "<?php echo $this->createUrl('/event/likeEvent')?>"  
	login-url = "<?php echo $this->createUrl('/index/login');?>"  
	get-sms-code = "<?php echo $this->createUrl('/ajax/getSMSCode');?>"  
	praise-group = "<?php echo $this->createUrl('group/like')?>" 
	add-biaolike = "<?php echo $this->createUrl('ajax/addBiaoLike')?>" 
	rem-biaolike = "<?php echo $this->createUrl('ajax/remBiaoLIke')?>" 
 ></span>
<script>
$(document).ready(function(){
	$("#inlineClick").colorbox({inline:true, width:"625px"});
});
</script>
<p><a id='inlineClick' href="#inline_content"></a></p>
<div style='display:none'><div id='inline_content' style='padding:10px; background:#fff;'></div></div>
<!-- 弹窗结束-->
<span id="show_message" class="tishi_message" style="display:none;z-index:99999;"></span>
<!-- 弹窗结束-->

<!-- baidu tongji -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?e813a979313172a6a1447369de13acc1";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>