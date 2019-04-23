<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>邀请码列表</h2>
</div>
<div class="tab tab-wrap">
    <ul class="tab-nav nav tab_menu clearfix">
        <li <?php if($class==1){?>class="current"<?php }?> ><a href="<?php echo $this->createUrl('index',array('status'=>0,'class'=>1))?>">会员邀请码</a></li>
        <li <?php if($class==2){?>class="current"<?php }?> ><a href="<?php echo $this->createUrl('index',array('status'=>0,'class'=>2))?>">平台申请邀请码</a></li>                
    </ul>
    <div class="tab_content">
        <div class="selected_div">
            <div class="clearfix is_use">
            	<?php if($class==1){ //会员邀请码 ?>
                    <li class="btn btn_new <?php if($status==1){?>cur_btn_new<?php }?>"><a href="<?php echo $this->createUrl('index',array('status'=>1,'class'=>1))?>">已 使 用</a></li>
                    <li class="btn btn_new <?php if($status==0){?>cur_btn_new<?php }?>"><a href="<?php echo $this->createUrl('index',array('status'=>0,'class'=>1))?>">未 使 用</a></li>
                    <?php if($status==0){ ?>
                    	<a class="btn scyqm">生成邀请码</a>
                    <?php }?>
                <?php }?>
                <?php if($class==2){ //平台邀请码 ?>
                    <li class="btn btn_new <?php if($status==1){?>cur_btn_new<?php }?>"><a href="<?php echo $this->createUrl('index',array('status'=>1,'class'=>2))?>">已 使 用</a></li>
                    <li class="btn btn_new <?php if($status==0){?>cur_btn_new<?php }?>"><a href="<?php echo $this->createUrl('index',array('status'=>0,'class'=>2))?>">未 使 用</a></li>
                    <?php if($status==0){ ?>
                    	<a class="btn scyqm">生成邀请码</a>
                    <?php }?>
                <?php }?>
            </div>
            <div class=" data-table table-striped">
                <table style="width:1000px;">
                    <thead>
                        <tr>
                            <th class="">编码</th>
                            <th class="">邀请码</th>
                            <th class="">状态</th>
                            <th class="">使用人</th>
                            <th class="">链接</th>
                        </tr>
                    </thead>
                    <tbody>
                    	<?php foreach($inviteCodeInfo as $key=>$value){?>
                            <tr>
                                <td width="100"><?php echo $value->id ?></td>
                                <td width="200"><?php echo $value->code ?></td> 
                                <td width="100"><?php if($value->status){echo "已使用";}else{ echo "未使用";}  ?></td>
                                <td width="100"><?php echo $value->inviteid ?></td>     
                                <?php if($class == 1):?>
                                    <td width="500">
                                            <?php
                                                 //auth 为 array(HInvite::REG_6 , 系统个人邀请码);
                                            //    $baseUrl = Yii::app()->request->hostInfo . $this->createUrl('/index/reg');
                                                $baseUrl = "http://www.licaipi.com/index.php?r=/index/reg";
                                                $auth = HInvite::encodeInvite(array(HInvite::REG_6 , $value->code));
                                                echo $baseUrl . '&auth=' . $auth;
                                            ?>
                                    </td>           
                                <?php else:?>
                                    <td width="500">
                                            <?php
                                                         // auth为 array(HInvite::REG_1 , 平台邀请码);
                                                    //    $baseUrl = Yii::app()->request->hostInfo . $this->createUrl('/index/reg');
                                                        $baseUrl = "http://www.licaipi.com/index.php?r=/index/reg";
                                                        $auth = HInvite::encodeInvite(array(HInvite::REG_1 , $value->code));
                                                        echo $baseUrl . '&auth=' . $auth;
                                            ?>
                                            </td>           
                                <?php endif;?>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- 分页 -->
    <div id="page">
		<?php    //数据分页
            $this->widget('CLinkPager', array(
                'header'	=>	'',
                'firstPageLabel'	=> '首页',
                'lastPageLabel'	=> '末页',
                'prevPageLabel'	=> '上一页',
                'nextPageLabel'	=> '下一页',
                'pages'			=> $pages,
                'maxButtonCount'=> 5,
                'cssFile'=>false, 
                ));
         ?>
 	</div>
    <!-- /分页 -->
</div>
<!-- /主体部分(内容) -->   
<script>
	$(function(){
		/* 生成邀请码 */
		function getUrlParam(name){
	   		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象
	   		var r = window.location.search.substr(1).match(reg);  //匹配目标参数
	   		if (r!=null) return unescape(r[2]); return null; //返回参数值
	  	} 
  		var item_num=getUrlParam('class');
  
		$('.scyqm').click(function(){
			$.post("/admin.php?r=inviteCode/Apply",{'id' : '5','class':item_num},function(result){
				if(result.status == true){
					window.location.reload();
				} else{
					alert(result.msg);
				}
			},'json');
		})
		
		
		
	})
</script>      
