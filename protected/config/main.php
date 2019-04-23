<?php
//config
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'理财派 - 投资理财就上理财派 p2p理财|互联网理财|屌丝理财|互联网金融|信用卡',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.helper.*' 
	),

	'modules'=>array(
		'gii' => array (
						'class' => 'system.gii.GiiModule',
						'password' => 'licaipilwx789',
						'ipFilters' => array (
								'127.0.0.1',
								'::1' 
						) 
				) ,
		'p' ,
	),

	// application components
	'components'=>array(
		'user' => array (
				'identityCookie'=>array('domain'=>'.365qulicai.cn'),   
				'allowAutoLogin' => true,
				'loginUrl'=>array('index/login'),
				'stateKeyPrefix'=>'web',
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=365qulicai',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'k_', 
			'enableProfiling'=>YII_DEBUG,
			'enableParamLogging'=>YII_DEBUG,
		),
		
		'errorHandler'=>array(
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
		                'routes'=>array(
		                        array(
		                                'class'=>'CFileLogRoute',
		                                'levels'=>'error, warning',
		                        ),
		                        // // 下面显示页面日志
		                        // array(
		                        //         'class'=>'CWebLogRoute',
		                        //         'levels'=>'trace',     //级别为trace
		                        //         'categories'=>'system.db.*' //只显示关于数据库信息,包括数据库连接,数据库执行语句
		                        // ),
		                ),
		),
	),
	'charset'=>'utf-8',
    'language'=>'zh_cn',
    
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'defaultController'=>'index',   	
	'params' => require(dirname(__FILE__).'/params.php'),
);
