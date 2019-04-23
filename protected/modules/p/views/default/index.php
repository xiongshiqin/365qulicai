<?php
/* @var $this DefaultController */

$this->breadcrumbs=array(
	$this->module->id,
);
?>
<h1><?php echo $this->uniqueId . '/' . $this->action->id; ?></h1>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<!--小组成员-->
			<?php if($member):?> 
			<div class="block huiyuan">
				<h3><i>小组成员</i></h3>
				<ul class="member">
					<?php foreach ($member  as $key=>$value) {?>
					<li class="selected" style="margin-left:12px;">
						<a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><img src="<?php echo HComm::avatar($value->uid);?>" /></a>
						<p class="quote"><a href="<?php echo $this->createUrl('home/index',array('uid'=>$value->uid)); ?>"><?php echo $value->username;?></a></p>
						<p><a href="">设为副组长</a></p>
						<p><a href="">踢出小组</a></p>
					</li>
					<?php } ?>
				</ul>
				<div style="clear:both;"></div>
			</div>
			<?php endif;?>

<p>
This is the view content for action "<?php echo $this->action->id; ?>".
The action belongs to the controller "<?php echo get_class($this); ?>"
in the "<?php echo $this->module->id; ?>" module.
</p>
<p>
You may customize this page by editing <tt><?php echo __FILE__; ?></tt>
</p>