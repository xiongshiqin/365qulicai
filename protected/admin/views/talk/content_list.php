<div class="main-title">
    <h2>帖子详情</h2>
</div>
<div class="data-table table-striped">
    <table class="">
    <thead>
        <tr>
            <th class="row-selected row-selected"><input type="checkbox" class="check-all"></th>
            <th class="">ID</th>
            <th class="">发起用户名称</th>
            <th >内容</th>
            <th class="">时间</th>
        </tr>
        <tbody>
        	<?php foreach($talkReplyInfo as $key=>$value){ ?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->replyid?></td>
                    <td><?php echo $value->username?></td>   
                    <td width="650"><?php echo $value->content?></td>
                    <td><?php echo date('Y-m-d H:i:s',$value->dateline)?></td>             
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