<!--内容区-->
<div id="wrap">
	<div class="contentR">
		<div class="sideR" style="width:265px;">
			<!--热门小组-->
			<div class="block block1">
				<h3>热门小组</h3>
                <?php if($group):?>
                    <ul class="group hot_xiaozuo">
                    	<?php foreach ($group  as $key=>$value) {?>
                            <li>
                                <div class="groupL">
                                	<a href="<?php echo $this->createUrl('group/index',array('gid'=>$value->gid));?>"><img src="<?php echo HComm::get_group_dir($value->gid)?>" /></a>
                                </div>
                                <div class="groupR">
                                    <h5>
                                    	<a href="<?php echo $this->createUrl('group/index',array('gid'=>$value->gid));?>">
											<?php echo $value->name;?>
                                        </a>
                                    </h5>
                                    <p><?php echo $value->follownum;?>人</p>
                                </div>
                            </li>
                        <?php };?>
                    </ul>
                <?php endif;?>
				<div class="clearboth"></div>
			</div>
		</div>

		<div class="mainarea">
			<!--小组-->
			<div class="block" >
				<h3><i>小组列表</i></h3>
                <?php if($topic):?>
                    <ul class="group xiaozu_list">
                        <?php foreach ($topic  as $key=>$value) {?>
                            <li>
                                <div class="groupL">
                                    <a href="<?php echo $this->createUrl('home/index', array('uid'=>$value->uid)); ?>" target="_blank"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
                                </div>
                                <div class="groupR">
                                    <h5><a href="<?php echo $this->createUrl('group/view', array('id'=>$value->topicid)); ?>"><?php echo  CHtml::encode($value->title);?></a></h5>
                                    <p>
                                        <a href="<?php echo $this->createUrl('group/view', array('id'=>$value->topicid)); ?>">
                                        <?php 
            	   		foreach($value->post as $p){
            		   		if($p->istopic){
            					echo HComm::truncate_utf8_string($p->content,135);
            				}
            			}
    			   ?>
                                        </a>
                                        <a href="<?php echo $this->createUrl('group/view', array('id'=>$value->topicid)); ?>" style="color:#1c7abe;">[查看更多]</a>
                                    </p>             
                                    <div class="author">
                                        <cite><em>评论&nbsp;&nbsp;</em><?php echo $value->replynum;?></cite>
                                        <a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a>
                                        <em><?php echo date("m-d H:i",$value->addtime);?></em>
                                        <em>来自：</em>
										<a href="<?php echo $this->createUrl('group/view', array('id'=>$value->topicid)); ?>"><?php echo $value->group->name?></a>
                                    </div>
                                </div>
                            </li>
    					<?php };?>
                    </ul>
                <?php endif;?>
				<div class="clearboth"></div>
			</div>
		</div>
	</div>
</div>