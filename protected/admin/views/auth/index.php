<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>平台列表</h2>
</div>
<div class="clearfix">
    <div class="fl">
        <a href="/admin1.php?s=/User/add.html" class="btn">实名认证</a>
        <a href="/admin1.php?s=/User/add.html" class="btn">邮箱认证</a>
    </div>
</div>

<div class="data-table table-striped">
    <table class="">
    <thead>
        <tr>
            <th class="row-selected row-selected"><input type="checkbox" class="check-all"></th>
            <th class="">UID</th>
            <th class="">申请用户</th>
            <th class="">真实姓名</th>
            <th class="">身份说明</th>
            <th class="">申请说明</th>
            <th class="">是否通过</th>
            <!-- <th class="">操作</th> -->
        </tr>
        <tbody>
        	<?php foreach($applies as $key=>$value){?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->uid?></td>
                    <td><a href="javascript:void(0)"><?php echo $value->member->username?></a></td>
                    <td><?php echo $value->member_info->realname?></td>
                    <td><?php echo $value->member_info->job;?></td>
                    <td><?php echo $value->remark;?></td>
                    <td width="200"><span class="status_info" style="cursor:pointer"><?php 
						switch($value->status){
							case -1:echo "删除";break;
							case 0:echo "申请中";break;
							case 1:echo "申请通过";break;
						}?></span>
                        <select class="status_selected dp_none" aid="<?php echo $value->id?>">
                    	        <option <?php if($value->status==-1){?>selected="selected"<?php }?> value="-1" >删除</option>
                                <option <?php if($value->status==0){?>selected="selected"<?php }?> value="0">申请中</option>
                                <option <?php if($value->status==1){?>selected="selected"<?php }?> value="1">申请通过</option>
                        </select>
                    </td>
                    <!-- <td><a href="<?php echo $this->createUrl('edit',array('uid'=>$value->uid))?>">编辑</a></td>              -->
                 </tr>
            <?php }?>
        </tbody>
    </thead>
    <tbody>
    	
     </tbody>
    </table>
</div>
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
<!-- /主体部分(内容) -->         
<script>
	$(function(){
		$('.status_info').click(function(){
			$(this).addClass('dp_none').next('.status_selected').removeClass('dp_none');			
		})
		$('.status_selected').change(function(){
			var val=$(this).val();
			var id=$(this).attr('aid');
			$.post('/admin.php?r=auth/status',{'value':val,'id':id},function(data){
				if(data==1){
					window.location.reload();
				}else{
					alert('操作失败')
				}
			})
		})
	})
</script>