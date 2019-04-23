<?php /* @var $this Controller */ ?>
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/style.css" rel="stylesheet">
  <?php if ( isset($this->module->id) ): ?>
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/admin.css" rel="stylesheet">
  <?php else:?>
  <link href="<?php echo Yii::app()->request->baseUrl; ?>/html/css/financial.css" rel="stylesheet">
  <?php endif;?>
  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery-2.1.1.min.js"></script>
  <script language="javascript" type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/html/js/jquery.validate.js"></script>
  
  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
  
 </head>
 <body style="background:#f8f8f8;">
 <!--顶部-->
<div id="header">
    <div id="top">
        <div class="right">
            <?php if (Yii::app()->user->isGuest): ?>
            <a href="<?php echo $this->createUrl('/index/login'); ?>" class="btn_login">登录</a>
            <a href="<?php echo $this->createUrl('/index/reg'); ?>" class="btn_login btn_regis">注册</a>
            <?php else : ?>
            <a href="<?php echo $this->createUrl('/profile/index'); ?>" class="btn_login"><?php echo Yii::app()->user->name ; ?>的设置</a>     
            <a href="<?php echo $this->createUrl('/index/logout'); ?>" class="btn_login">退出</a>
            <?php endif;?>
        </div>

        <div class="left">
            <span>
                <a href="" style="float:left;">深圳</a>
                <i class="arrow"></i>
            </span>
            <a href="">收藏本站</a>
            <a href="">添加到桌面</a>
        </div>
    </div>
</div>

<!--导航-->
<div id="nav" style="background:#fff;">
    <div class="mainbav">
        <div class="left logo">
            <a href=""><img alt="<?php echo CHtml::encode(Yii::app()->name); ?>" src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/p2p_logo.png" /></a>
        </div>
        
        <ul class="nav_right">
            <li><a href="<?php echo $this->createUrl('/'); ?>">首页</a></li>
            <li><a href="<?php echo $this->createUrl('/P2p/list'); ?>">P2P理财</a></li>
            <li><a href="<?php echo $this->createUrl('/event/index'); ?>">优惠活动</a></li>
            <li class="selected"><a href="<?php echo $this->createUrl('/group/hot'); ?>">小组</a></li>
            <li><a href="<?php echo $this->createUrl('/home/index')?>">我的钱包</a></li>
            <li><a href="<?php echo $this->createUrl('/business/list')?>">第三方支付</a></li>
        </ul>
    </div>

    <!--子导航-->
    <div class="subnav_bg">
        <ul class="subnav">
            <?php if($this->id == 'group'): ?>
            <li class="selected"><a href="<?php echo $this->createUrl('/group/hot'); ?>">小组首页</a></li>
            <li><a href="<?php echo $this->createUrl('/group/mygroup'); ?>">我的小组</a></li>
            <?php elseif ($this->id == 'p2p') : ?>
            <li><a href="<?php echo $this->createUrl('/p2p/list'); ?>">平台导航首页</a></li>
            <li><a href="<?php echo $this->createUrl('/p2p/index'); ?>">平台首页</a></li>
            <?php endif;?>
        </ul>
    </div>
</div>

<div class="">
    <h4 class="news-title">信息提示</h4>
    <div class="news-content">
        <div class="fl <?php echo $type;?>-ico">
            <em></em>
        </div>
        <div class="fr">
            <?php if('error' == $type):?>
            <h1 class="c_E64141">操作失败</h1>
            <?php else:?>
            <h1>操作成功</h1>
            <?php endif;?>
            <p class="mb10"><?php echo $message;?></p>
            <p><span><a href="<?php echo $url;?>">&gt;请点击此处返回</a></span></p>
        </div>
    </div>
</div>

<!--尾部-->
<div class="footerbg">
    <div id="footer">
        <!--右边-->
        <div class="footer_R">
            <dl>
                <dt><a href="" target="_blank"><img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/weixin_da.png" /></a></dt>
                <dd>
                    <p style="font-size:20px;">扫一扫关注</p>
                    <p><strong>微信公众号</strong></p>
                    <p class="ico_weixin">dsct88</p>
                </dd>
            </dl>       
        </div>

        <!--左边-->
        <div class="footer_L">
            <p>
                <a href="">关于推广平台</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="">免责声明</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="">隐私声明</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="">联系方式</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="">意见反馈</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                <a href="">友情链接</a>
            </p>
            <p>©Copyright 2014 All Rights Reserved QianBaoMiMa.com</p>
            <p>广ICP备12013288 号<img src="<?php echo Yii::app()->request->baseUrl; ?>/html/images/pic.gif" /></p>
        </div>
    </div>
</div>

</body>
</html>
