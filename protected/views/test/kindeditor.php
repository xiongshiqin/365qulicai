
<?php $this->widget('ext.kindeditor.KindEditorWidget',array(
    'id'=>'post-content',   //对应表单中的 输入框ID 
    'items' => array(
        'width'=>'700px',
        'height'=>'300px',
        'themeType'=>'simple',
        'allowImageUpload'=>true,
        'allowFileManager'=>false,
        'items'=>array('bold', 'underline', 'removeformat', 'emoticons', 'image', 'link',),
    ),
)); ?>
<form>
	<input type="text" value="" name="title" />
	<textarea name="content" id="post-content">内容</textarea>
</form>