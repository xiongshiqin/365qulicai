<!-- 主体部分(内容) -->
<div class="main-title">
    <h2>平台列表</h2>
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
            <th class="">CPID</th>
            <th class="">平台名称</th>
            <th class="">公司名称</th>
            <th class="">发布时间</th>
            <th class="">信息</th>
            <th class="">收益</th>
            <th class="">运营状态</th>
            <th class="">是否开通</th>
            <th class="">操作</th>
        </tr>
        <tbody>
        	<?php foreach($companyInfo as $key=>$value){?>
                <tr>
                    <td><input type="checkbox" value="1" name="id[]" class="ids"></td>
                    <td><?php echo $value->cpid?></td>
                    <td><a href="<?php echo $this->createUrl('ShowInfo',array('id'=>$value->cpid));?>"><?php echo $value->name?></a></td>
                    <td><?php echo $value->companyname?></td>   
                    <td><?php echo date('Y-m-d H:i:s',$value->company_info->dateline)?></td>
                    <td></td>
                    <td><?php echo $value->profitlow.'--'.$value->profithigh?></td> 
                    <td><?php switch($value->status){case -2:echo "跑路";break;case -1: echo "倒闭";break;case 0:echo "提现困难";break;case 1:echo "正常";break; }?></td> 
                    <td width="200"><span class="isopen_info" style="cursor:pointer"><?php 
						switch($value->isopen){
							case -1:echo "关闭";break;
							case 0:echo "申请中";break;
							case 1:echo "申请通过";break;
							case 2:echo "申请开通";break;
							case 3:echo "开通";break;
							default:echo "其他";break;
						}?></span>
                        <select class="isopen_selected dp_none" companyid="<?php echo $value->cpid?>">
                        	<option <?php if($value->isopen==-1){?>selected="selected"<?php }?> value="-1" >关闭</option>
                            <option <?php if($value->isopen==0){?>selected="selected"<?php }?> value="0">申请中</option>
                            <option <?php if($value->isopen==1){?>selected="selected"<?php }?> value="1">申请通过</option>
                            <option <?php if($value->isopen==2){?>selected="selected"<?php }?> value="2">申请开通</option>
                            <option <?php if($value->isopen==3){?>selected="selected"<?php }?> value="3">开通</option>
                        </select>
                    </td>
                    <td><a href="<?php echo $this->createUrl('edit',array('cpid'=>$value->cpid))?>">编辑</a></td>             
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
			var cpid=$(this).attr('companyid');
			$.post('/admin.php?r=company/IsOpen',{'value':val,'cpid':cpid},function(data){
				if(data==1){
					window.location.reload();
				}else{
					alert('操作失败')
				}
			})
		})
	})
</script>