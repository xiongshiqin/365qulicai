<div class="main-title">
    <h2>编辑活动</h2>
</div>
<?php $form = $this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
    <div class="form-item">
        <label class="item-label">活动标题<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->textField($eventInfo,'title',array('class'=>'text input-large')) ?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">发起人姓名<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->textField($eventInfo,'username',array('class'=>'text input-large')) ?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">活动类别<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->textField($eventInfo,'class',array('class'=>'text input-large')) ?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">活动状态<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->radioButtonList($eventInfo,'status',array(0=>'预览编辑版',1=>'申请发布',2=>'平台审核'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">活动类别<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->radioButtonList($eventInfo,'class',array(1=>'平台关注'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">是否有抽奖<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->textField($eventInfo,'likegift',array('class'=>'text input-large')) ?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">抽奖类型<span class="check-tips"></span></label>
        <div class="controls">
            <?php echo $form->radioButtonList($eventInfo,'lotterytype',array(0=>'砸金蛋',1=>'转盘',2=>'翻版'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">创建时间<span class="check-tips"></span></label>
        <div class="controls">
            <input  name="Event[dateline]" type="text" class="easyui-datebox" value="<?php echo date("Y-m-d",$eventInfo->dateline)?>"></input>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">活动内容<span class="check-tips"></span></label>
        <div class="textarea input-large">
           
            <textarea name="EventField[content]"><?php echo $eventInfo->event_field->content ?></textarea>
        </div>
    </div>
    
    <div class="form-item">
        <input  class="btn submit-btn ajax-post" type="button" value="提交">
        <input onclick="javascript:history.back(-1);return false;"  class="btn btn-return" type="button" value="返回">
    </div>
<?php $this->endWidget(); ?>
    
    
    
    
    
    