<!--  edit by porter 此处为原始结构 修改name为传入的name而不是数组  value改为Y-m-d H:i:s 形式，后台需处理
 -->
 <?php if($this->model):?>
	<input type="text" class="timepicker" id="<?php echo $this->id; ?>" value="<?php echo date('Y-m-d H:i:s',$this->model->{$this->name}?$this->model->{$this->name}:$this->options['value']); ?>" name="<?php echo $this->name; ?>" />
<?php else:?>
	<input type="text" class="timepicker" id="<?php echo $this->id; ?>" value="<?php echo date('Y-m-d H:i:s',$this->value); ?>" name="<?php echo $this->name; ?>" />
<?php endif;?>
<script>
	$('.timepicker').attr('readonly',true);
</script>
