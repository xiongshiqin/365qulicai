<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>支付平台列表</h2>
</div>
<div class="clearfix">
    <div class="fl">
        <a style="display:none;" href="<?php echo $this->createUrl('/Business/edit');?>" class="btn">新增平台</a>
    </div>
</div>

<div class="data-table table-striped">
    <table class="">
    <thead>
        <tr>
            <th class="row-selected row-selected"><input type="checkbox" class="check-all"></th>
            <th class="">BID</th>
            <th class="">平台名称</th>
            <th class="">接入平台数</th>
            <th class="">创建时间</th>
            <th style="display:none;" class="">操作</th>
        </tr>
        <tbody>
        	<?php foreach($business as $key=>$value){?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->bid?></td>
                    <td><a href="javascript:void(0)"><?php echo $value->shortname?></a></td>
                    <td><?php echo $value->p2pnum?></td>
                    <td><?php echo date('Y-m-d' , $value->dateline);?></td>
                    <td style="display:none;"><a href="<?php echo $this->createUrl('/business/edit',array('bid'=>$value->bid))?>">编辑</a></td>             
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