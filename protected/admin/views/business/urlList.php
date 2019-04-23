<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>支付平台列表</h2>
</div>
<div class="clearfix">
    <div class="fl">
        <a href="<?php echo $this->createUrl('/Business/inviteUrl');?>" class="btn">创建url</a>
    </div>
</div>

<div class="data-table table-striped">
    <table class="">
    <thead>
        <tr>
            <th class="">用户名</th>
            <th class="">支付平台名</th>
            <th class="">url</th>
            <th class="">有效期至</th>
        </tr>
        <tbody>
        	<?php foreach($codes as $key=>$value){?>
                <tr>
                    <td><?php $username = Member::model()->findByPk($value->uid); echo $username ? $username->username : '设置错误，不存在';?></td>
                    <td><?php echo Business::model()->findByPk($value->pid)->shortname;?></a></td>
                    <td><?php echo InviteCode::model()->inviteUrl($value->code);?></td>
                    <td><?php echo date('Y-m-d H:m' , $value->dateline)?></td>
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
