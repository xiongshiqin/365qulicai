<!-- 主体部分(内容) -->
<div class="main-title">
    <h2><?php echo $companyInfo->name?></h2>
</div>

<a target="_blank" href="http://www.licaipi.com/index.php?r=/p2p/index&cpid=<?=$companyInfo->cpid?>"> 首页预览 </a>

<div class="data-table table-striped form-horizontal">
    <div class="form-item">
    	<p><span class="bold mr15">公司名称:</span><span><?php echo $companyInfo->companyname?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">公司网址:</span><span><?php echo $companyInfo->siteurl?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">运营状态:</span><span><?php echo $companyInfo->status?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">注册资金:</span><span><?php echo $companyInfo->capital?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">公司法人:</span><span><?php echo $companyInfo->legalperson?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">所在省,市:</span><span><?php echo $companyInfo->companyname?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">开业时间:</span><span><?php echo date('Y-m-d',$companyInfo->onlinetime)?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">公司地址:</span><span><?php echo $companyInfo->address?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">首选的第三方支付:</span><span><?php echo $companyInfo->payment?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">是否托管:</span><span><?php if($companyInfo->host){echo "是";}else{echo "否";}?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">联系电话:</span><span><?php echo $companyInfo->telphone?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">月收益:</span><span><?php echo $companyInfo->profitlow.'---'.$companyInfo->profithigh ?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">是否开通:</span><span><?php echo $companyInfo->isopen?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">坐标-经度:</span><span><?php echo $companyInfo->lat?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">坐标-纬度:</span><span><?php echo $companyInfo->lng?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">微信图片地址:</span><span><?php echo $companyInfo->weixin?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">微博地址:</span><span><?php echo $companyInfo->weibo?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">企业QQ:</span><span><?php echo $companyInfo->qq?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">活动数:</span><span><?php echo $companyInfo->event_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">公告数:</span><span><?php echo $companyInfo->news_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">会员数:</span><span><?php echo $companyInfo->member_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">关注数:</span><span><?php echo $companyInfo->follow_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">浏览数:</span><span><?php echo $companyInfo->view_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">视频数:</span><span><?php echo $companyInfo->video_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">图片数:</span><span><?php echo $companyInfo->pic_num?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">是否VIP:</span><span><?php if($companyInfo->isvip){echo "是";}else{echo "否";}?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">VIP到期时间:</span><span><?php echo date('Y-m-d',$companyInfo->vip_time)?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">申请时间:</span><span><?php echo date('Y-m-d',$companyInfo->dateline)?></span></p>
    </div>
    <div class="form-item">
    	<p><span class="bold mr15">开通时间:</span><span><?php echo date('Y-m-d',$companyInfo->opentime)?></span></p>
    </div>
 </div>
</div>
<!-- /主体部分(内容) -->   