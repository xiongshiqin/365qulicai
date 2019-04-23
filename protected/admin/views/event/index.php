<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>活动列表</h2>
</div>
<div class="clearfix">
    <div class="fl">
        <a href="/admin1.php?s=/User/add.html" class="btn">新 增</a>
        <button target-form="ids" url="#" class="btn ajax-post">启 用</button>
        <button target-form="ids" url="#" class="btn ajax-post">禁 用</button>
        <button target-form="ids" url="#" class="btn ajax-post confirm">删 除</button>
    </div>

    <!-- 高级搜索 -->
    <div class="search-form fr clearfix">
        <div class="sleft">
            <input type="text" placeholder="请输入用户昵称或者ID" value="" class="search-input" name="nickname">
            <a url="/admin1.php?s=/User/index.html" id="search" href="javascript:;" class="sch-btn"><i class="btn-search"></i></a>
        </div>
    </div>
</div>

<div class="data-table table-striped">
    <table class="">
    	<thead>
            <tr>
                <th class="row-selected row-selected"><input type="checkbox" class="check-all"></th>
                <th class="">活动ID</th>
                <th class="">活动标题</th>
                <th class="">发起人姓名</th>
                <th class="">活动类型</th>
                <th class="">开始时间</th>
                <th class="">结束时间</th> 
                <th class="">活动状态</th>           
                <th class="">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($evenInfo as $key=>$value){?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->eventid?></td>
                    <td><?php echo $value->title?></td>
                    <td><?php echo $value->username?></td>   
                    <td><?php 
						switch($value->type){
							case 1: echo "平台活动";break;
							case 2: echo "线下活动";break;
						}
					?></td>
                    <td><?php echo date('Y-m-d H:i:s',$value->starttime)?></td>
                    <td><?php echo date('Y-m-d H:i:s',$value->endtime)?></td> 
                    <td width="200"><span class="status_info" style="cursor:pointer"><?php 
						switch($value->status){
                                                                                    case -1: echo '删除';break;
							case 0:echo '预览编辑版';break;
							case 1:echo '发布';break;
							case 2:echo "平台审核";break;
					}?></span>
                    	<select class="status_selected dp_none" eventid="<?php echo $value->eventid?>">
                            <option <?php if($value->status==-1){?>selected="selected"<?php }?> value="-1">删除</option>
                            <option <?php if($value->status==0){?>selected="selected"<?php }?> value="0">预览编辑版</option>
                            <option <?php if($value->status==1){?>selected="selected"<?php }?> value="1">发布</option>
                            <option <?php if($value->status==2){?>selected="selected"<?php }?> value="2">平台审核</option>
                        </select>
                    </td> 
                    <td><a href="<?php echo $this->createUrl('edit',array('id'=>$value->eventid));?>">编辑</a></td>             
                 </tr>
            <?php }?>
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
			var eventid=$(this).attr('eventid');
			$.post('/admin.php?r=event/ModifyStatus',{'value':val,'eventid':eventid},function(data){
				if(data==1){
					window.location.reload();
				}else{
					alert('操作失败')
				}
			})
		})
	})
</script>