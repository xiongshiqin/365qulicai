<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>用户列表</h2>
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
        <th class="">MID</th>
        <th class="">真实姓名</th>
        <th class="">积分总数</th>
        <th class="">金币数</th>
        <th class="">最后登录时间</th>
        <th class="">最后登录IP</th>
        <th class="">状态</th>
        <th class="">操作</th>
        </tr>
    </thead>
    <tbody>
    	<?php foreach($memberInfo as $k=>$v){?>
            <tr>
                <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                <td><?php echo $v->username;?></td>
                <td><?php echo $v->info->realname;?></td>
                <td><?php echo $v->count->credittotal;?></td>
                <td><?php echo $v->count->gold;?></td>
                <td><span><?php echo date('Y-m-d H:i:s',$v->member_status->lastvisit);?></span></td>
                <td><span><?php echo long2ip($v->member_status->lastip);?></span></td>
                <td><?php if($v->status){echo "正常";}else{ echo "冻结";}?></td>
                <td><a class="authorize" href="<?php echo $this->createUrl('edit',array('uid'=>$v->uid))?>">编辑</a></td>
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
