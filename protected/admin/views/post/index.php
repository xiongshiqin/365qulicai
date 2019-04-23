<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>帖子列表</h2>
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
                <th class="">ID</th>
                <th class="">标题</th>
                <th class="">用户名称</th>
                <th class="">内容</th>
                <th class="">是否为主题帖</th>
                <th class="">时间</th>
                <th class="">操作</th>
            </tr>
        </thead>
        <tbody>
        	<?php foreach($grouppostInfo as $key=>$value){?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->postid?></td>
                    <td><?php echo $value->title?></td>
                    <td><?php echo $value->username?></td>   
                    <td width="500"><?php echo $value->content?></td>
                    <td><?php if($value->istopic){echo "是";}else{echo "否";}?></td>
                    <td><?php echo date('Y-m-d H:i:s',$value->dateline)?></td> 
                    <td></td>             
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