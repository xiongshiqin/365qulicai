<div class="main-title">
    <h2>编辑会员</h2>
</div>
<?php $form = $this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
        <div class="form-item">
            <label class="item-label">用户名<span class="check-tips">（用户名会作为默认的昵称，不能修改）</span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel,'username',array('class'=>'text input-large','disabled'=>'disabled')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">真实姓名<span class="check-tips">（用户密码不能少于6位）</span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->info,'realname',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">性别<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($memberModel->info,'gender',array(0=>'女',1=>'男',2=>'保密'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">QQ<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->info,'qq',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">微信号<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->info,'weixin',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">居住城市<span class="check-tips"></span></label>
            <div class="controls">
                <?php $this->widget("City" , array(
					'provinceidname' => "provinceid",		
					'cityidname' => "residecityid",
					'model' => $memberModel->info,		
				))?>				
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">最新个人签名记录<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->info,'sign',array('class'=>'text input-large')) ?>
            </div>
        </div>
        
        <div class="form-item">
            <label class="item-label">手机号码</label>
            <div class="controls">
                <?php echo $form->textField($memberModel,'mobile',array('class'=>'text input-large')) ?>
            </div>
        </div>
        
        <div class="form-item">
            <label class="item-label">邮箱<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel,'email',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">邮箱验证状态<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($memberModel,'emailstatus',array(0=>'未验证',1=>'验证'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">是否上传头像标志<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($memberModel,'avatarstatus',array(0=>'否',1=>'是'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">是否实名<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($memberModel,'realstatus',array(0=>'否',1=>'是'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">手机是否验证<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($memberModel,'mobilestatus',array(0=>'否',1=>'是'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">等级<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($memberModel,'groupid',array(0=>'1',1=>'2'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">积分数<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->count,'credit',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">积分总数<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->count,'credittotal',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">金币数<span class="check-tips">（用户密码不能少于6位）</span></label>
            <div class="controls">
                <?php echo $form->textField($memberModel->count,'gold',array('class'=>'text input-large')) ?>
            </div>
        </div>
        
        
        <div class="form-item">
            <input  class="btn submit-btn ajax-post" type="button" value="提交">
            <input onclick="javascript:history.back(-1);return false;"  class="btn btn-return" type="button" value="返回">
        </div>
    <?php $this->endWidget(); ?>
    
    
    
    
    