<?php
return array (
	'adminEmail' => 'webmaster@example.com',
	'avatardir'=>'/data/avatar',   //个人头像目录
	'cplogodir'=>'/data/cplogo',   //公司logo目录
	'grouppicdir'=>'/data/grouppic',   //小组头像目录
	'default_com_img' => '/html/images/default_com_logo.jpg' , // 默认公司logo
	'default_group_img' => '/images/default_group.png' , // 默认小组头像
	'default_upload_img' =>  '/html/images/default_img.jpg' , // 默认上传图片logo
	'default_ad_pic' => "/html/images/small_banner.png" , // 默认广告图片
	'userlistnum'=>10, 
	'topicnum'=>20,
	'postnum'=>10, 
	'talk_pagesize' => 3, // 私信加载数据条数

	'empMobiles' => array(
		'13501593761' , // 高
		'13682352406' , // 熊
		'15814082748' , // 蒋
		'15767915200' , // 刘
		'13902453006' , 
		),

	'News' => array(
		'category' => array( // 新闻分类
				1 => array(
					'101' => '新闻公告',  // 1 平台新闻
					'102' => '最新动态',
					'103' => '媒体报道',
					'104' => '其他',
				),
				2 => array(
					'201' => '行业',  // p2p全部新闻
					// '202' => '政策法规',
					// '203' => '观点',
					'204' => '访谈',
					// '205' => '其他',
				),
				3 => array(
					'301' => '后台通知', // 后台通知
				),
			),
		),




	//短信
	'sms'=>array(
		'host'=>'124.172.250.160',
		'name'=>'lcp',
		'pwd'=>'nmkij225',
		'delay' =>90 , // 多少秒获取一次
	),	
	
	// 登陆  注册     平台申请入驻  找回密码  设置新密码 这几个页面的背景style="background:#f8f8f8;" 
	'specialBody' => array( // 这里都是小写的
		'index/index' , // 首页
		'index/login' , // 登录
		'index/reg' , // 注册
		'index/forgetpwd', // 忘记密码
		'p2p/apply' , //平台申请入驻
		'news/newsadd' , // 添加行业新闻
	),
	'group'=>array(
		1=>'书童',
		2=>'秀才',
		3=>'举人',
		4=>'进士',
		5=>'探花',
		6=>'榜眼',
		7=>'状元',
	),
    	'Company' => array(
    		'isopen' => array(
    			'-1' => '关闭',
	    		0 => '申请中',
	    		1 => '申请通过,后台添加资料',
	    		2 => '申请开通',
	    		3 => '开通',
		),
    		'newsClass' => array( // 新闻类型
    			1 => '新闻公告',
    			2 => '最新动态',
    			3 => '媒体报道',
    			4 => '其他',
		),
	),
    	
    	//  部门信息
    	'department' => array(
    		 1 => '客服',
    		 2 => '技术部',
    		 3 => '运营',
    		 4 => '其他'
    	),
    	// 自定义广告位位置
    	'adsPlace' => array(
    		 1 => '条形广告',
    		 2 => '方形广告',
    		),
	'groupclass' => array(
		1 => '互联网金融',
		2 => '信用卡',
		3 => '支付',
		4 => 'P2P',
	),
	'groupuser'=>array(
		9 => '组长',
		8 => '副组长',
		5 => 'VIP会员',
		1 => '普通成员',
		0 => '申请中',
		
	),
	'Biaos' => array(
		// 发标播报中的还款类型
		'repaymenttype' => array(
			1 => '先息后本',
			2 => '等额等息',
			3 => '到期本息',
		),

		// 标类型
		'itemtype' => array(
			3 => '月标',
			2 => '天标',
			1 => '秒标',
		),
	),
	// 活动
	'Event' => array(
		// 活动类型
		'type' => array(
			1 => '平台活动', // 默认
			2 => '微信活动', 
			3 => '注册活动',
			4 => '投标活动',
		),
		// 活动状态
		'status' => array(
			'-1' => '删除',
			0 => '预览编辑',
			1 => '申请发布',
			2 => '审核通过',
		),
		// 抽奖类型
		'lotterytype' => array(
			0 => '不抽奖',
			1 => '砸金蛋',
			2 => '幸运转盘',
			3 => '翻板',
		),
		// vip抽取限定
		'vip' => array(
			0 => '不限',
			1 => '限VIP客户抽取',
		),
		// 奖品类型
		'awardType' => array(
			1 => '实物',
			2 => '红包',
			3 => '金币',
		),
	),

	'pager'=>array(  
		'maxButtonCount'=>10,  
		'firstPageLabel'=>'首页',  
		'lastPageLabel'=>'末页',  
		'nextPageLabel'=>'下一页',  
		'prevPageLabel'=>'上一页',  
		'header'=>'',  
		'cssFile'=>false,   
   	 ),
    
	'params_credit' => require(dirname(__FILE__).'/params_credit.php'),
);