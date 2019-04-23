<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>平台列表</h2>
</div>
<div class="clearfix">
    <div class="fl">
        <a href="<?php echo $this->createUrl('/news/index');?>" class="btn">首页</a>
        <a href="<?php echo $this->createUrl('/news/adminNews');?>" class="btn">后台新闻</a>
        <a href="<?php echo $this->createUrl('/news/addAdminNews');?>" class="btn">增加后台新闻</a>
    </div>
<div class="data-table table-striped">
    <table class="">
    <thead>
        <tr>
            <th class="row-selected row-selected"><input type="checkbox" class="check-all"></th>
            <th class="">CPID</th>
            <th class="">标题</th>
            <th class="">时间</th>
            <th class="">操作</th>
        </tr>
        <tbody>
        	<?php foreach($news as $key=>$value){?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->newsid?></td>
                    <td><a href="<?php echo $this->createUrl('edit',array('newsid'=>$value->newsid));?>"><?php echo $value->title?></a></td>
                    <td><?php echo date('Y-m-d H:i:s',$value->dateline)?></td>
                    <td><a href="<?php echo $this->createUrl('addAdminNews',array('newsid'=>$value->newsid))?>">编辑</a></td>             
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
		$('.isopen_info').click(function(){
			$(this).addClass('dp_none').next('.isopen_selected').removeClass('dp_none');			
		})
		$('.isopen_selected').change(function(){
			var val=$(this).val();
			var newsid=$(this).attr('newsid');
			$.post('/admin.php?r=company/IsOpen',{'value':val,'newsid':newsid},function(data){
				if(data==1){
					window.location.reload();
				}else{
					alert('操作失败')
				}
			})
		})
	})
</script>