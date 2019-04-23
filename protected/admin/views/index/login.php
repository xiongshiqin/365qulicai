<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>理财派后台登陆</title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/css/base.css">
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/css/page.css">
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/common.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/js/js.js"></script> 
</head>

<body>
	<div class="login_box pr">
    	<img class="ml10" src="<?php echo Yii::app()->request->baseUrl ?>/html/admin1/images/mall_login_logo.gif" width="262" height="82" />
        <form id="login-form" action="<?php echo $this->createUrl('index/login');?>" method="post" class="lr-form">
        	<input type="hidden" value="0" id="remember" name="LoginForm[rememberMe]" tabindex="4">
        	<div class="login_input_item clearfix pr">
            	<i class="icon_login_user fl"></i>            	
                <input class="login_txt fl ml10 c_9" value="请填写用户名" id="lg_username" name="LoginForm[username]"  type="text" maxlength="60">
            </div> 
            <div class="login_input_item clearfix pr mt15">
            	<i class="icon_login_pwd fl"></i>
                <input class="login_txt fl ml10 c_9" id="password" name="LoginForm[password]" type="password">	
                <span class="login_txt_tishi pa c_9">请输入密码</span>
            </div> 
            <div class="login_input_item clearfix pr mt15">
            	<i class="icon_login_code fl"></i>
                <input class="login_txt login_txt_code fl ml10 c_9" id="lg_password" name="LoginForm[verifyCode]" value="请填写验证码">
                	
                <?php $this->widget('CCaptcha',array('showRefreshButton'=>false,'clickableImage'=>true,'imageOptions'=>array('alt'=>'点击换图','title'=>'点击换图','style'=>'cursor:pointer','class'=>'fl'))); ?>
                <a class="change_code fl ft14 mt10" href="#">换一张？</a>
            </div> 
            <input class="login_btn ft22 bold mt10" type="submit" value="登录"> 
         </form>
    </div>
    <script>
		$(function(){
			/* 登陆框获取焦点失去焦点*/
			$('.login_txt_tishi').click(function(){
			 	$(this).hide();
				$('#password').focus();
			})
			$('#password').focus(function(){
			 	$('.login_txt_tishi').hide();
			})
			
			$(".login_txt").blur(function(){     //失去焦点 				   
				if($(this).val()==""){   
					$(this).val(this.defaultValue);
					$(this).removeClass('c_3').addClass('c_9'); 
					$(this).next('.login_txt_tishi').css({display:'block'});
				}   
			}).focus(function(){  //获取焦点				
				if($(this).val()==this.defaultValue){   
					$(this).val(""); 
					$(this).removeClass('c_9').addClass('c_3');
				}								   
			}); 
			$('.change_code').click(function(){
				$('#yw0').click();
			})
			
		})
	</script>
    <script type="text/javascript">
	/* render默认加载 */
	jQuery(function($) {
	
	jQuery(document).on('click', '#yw0', function(){
		jQuery.ajax({
			url: "\/admin.php?r=index\/captcha&refresh=1",
			dataType: 'json',
			cache: false,
			success: function(data) {
				jQuery('#yw0').attr('src', data['url']);
				jQuery('body').data('captcha.hash', [data['hash1'], data['hash2']]);
			}
		});
		return false;
	});
	
	});
	/* /render默认加载 */
	</script>
</body>
</html>
