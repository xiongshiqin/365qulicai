	<div class="main bc manage">        
		<?php $this->widget('ManageMenu',array(
			'selected' =>array('index/user'=>' current'),
		)); ?>  

		<div class="w800 fr">
			<div class="info-main">	
			<h3>会员信息</h3>			
			<?php if($users):?>
			<ul class="p-list">
        		<?php foreach ($users as $user) {?>
                <li>
                    <div class="fl"><a href="/index.php?r=home/index&uid=<?php echo $user->uid;?>" target="_blank"><img src="<?php echo HComm::avatar($user->uid);?>" width="48" height="48"></a></div>
                    <div class="share-content fr">
                    	<p class="f14">
                    		<a href="/index.php?r=home/index&uid=<?php echo $user->uid;?>" target="_blank"><?php echo $user->username;?></a>   
                    	</p>          
                    </div>
                </li>
               <?php }?>
            </ul>
            <?php endif;?>
            <!--page-->
			<div id="pager">    
		    <?php   
		    $this->widget('CLinkPager',array(    
		        'header'=>'',    
		        'firstPageLabel' => '首页',    
		        'lastPageLabel' => '末页',    
		        'prevPageLabel' => '上一页',    
		        'nextPageLabel' => '下一页',    
		        'pages' => $pages,    
		        'maxButtonCount'=>10,
		        )
		    );    
		    ?>    		
			</div>
			
			
        </div>
    </div>		