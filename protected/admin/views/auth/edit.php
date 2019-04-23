<div class="main-title">
    <h2>编辑平台</h2>
</div>
<?php $form = $this->beginWidget('CActiveForm', array('htmlOptions'=>array('class'=>'form-horizontal'))); ?>
        <div class="form-item">
            <label class="item-label">平台名称<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'name',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">公司名称<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'companyname',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">公司网址<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'siteurl',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">公司基本介绍<span class="check-tips"></span></label>
            <div class="textarea input-large">
                <textarea name="CompanyInfo[info]"><?php echo $companyInfo->company_info->info?></textarea>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">公司主要业务<span class="check-tips"></span></label>
            <div class="textarea input-large">
                <textarea name="CompanyInfo[mainbissness]"><?php echo $companyInfo->company_info->mainbissness?></textarea>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">老板姓名<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo->company_info,'boss_name',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">老板手机<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo->company_info,'boss_mobile',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">运营总监姓名<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo->company_info,'operation_name',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">运营总监手机<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo->company_info,'operation_mobile',array('class'=>'text input-large')) ?>
            </div>
        </div>
        
        <div class="form-item">
            <label class="item-label">运营状态<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($companyInfo,'status',array(-2=>'跑路',-1=>'倒闭',0=>'提现困难',1=>'正常'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">注册资金<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'capital',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">公司法人<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'legalperson',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">所在省市<span class="check-tips"></span></label>
            <div class="controls">
                <?php $this->widget("City" , array(
					'provinceidname' => "resideprovinceid",		
					'cityidname' => "cityid",
					'model' => $companyInfo,		
				))?>				
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">开业时间<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'onlinetime',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">公司地址<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'address',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">首选的第三方支付<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'payment',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">是否托管<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($companyInfo,'host',array(0=>'否',1=>'是'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">联系电话<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'telphone',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">月收益最低<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'profitlow',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">月收益最高<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'profithigh',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">是否开通<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($companyInfo,'isopen',array(-1=>'关闭',0=>'申请中',1=>'申请通过',2=>'申请开通','3'=>'已开通'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">坐标经度<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'lat',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">坐标维度<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'lng',array('class'=>'text input-large')) ?>
            </div>
        </div>
        
        <div class="form-item">
            <label class="item-label">微信图片地址<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'weixin',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">微博地址<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'weibo',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">企业QQ<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->textField($companyInfo,'qq',array('class'=>'text input-large')) ?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">是否VIP<span class="check-tips"></span></label>
            <div class="controls">
                <?php echo $form->radioButtonList($companyInfo,'isvip',array(0=>'否',1=>'是'),array('separator'=>'&nbsp&nbsp&nbsp'))?>
            </div>
        </div>
        <div class="form-item">
            <label class="item-label">VIP到期时间<span class="check-tips"></span></label>
            <div class="controls">
            	<input  name="Company[vip_time]" type="text" class="easyui-datebox" value="<?php echo date("Y-m-d",$companyInfo->vip_time)?>"></input> 
            </div>
        </div> 
        
        
        <div class="form-item">
            <input  class="btn submit-btn ajax-post" type="button" value="提交">
            <input onclick="javascript:history.back(-1);return false;"  class="btn btn-return" type="button" value="返回">
        </div>
    <?php $this->endWidget(); ?>
    
    
    
    
    
    