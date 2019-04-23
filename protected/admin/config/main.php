<?php
$admin = dirname(dirname(__FILE__));
$frontend = dirname($admin);
Yii::setPathOfAlias('admin', $admin);
$frontendArray = require_once($frontend.'/config/main.php');

$adminArray = array(
	'name'=>'后台管理系统',
	'basePath'=>$frontend,
    'viewPath'=>$admin . '/views',
	'controllerPath'=>$admin . '/controllers',
    'runtimePath'=>$admin . '/runtime',
	'import'=>array(	
		//'application.models.*',
		//'application.components.*',
	    'admin.models.*',
		'admin.components.*',
	),
	'components' => array (
		'user' => array (
						'identityCookie'=>array('domain'=>'.licaipi.cn'),   
						'allowAutoLogin' => true,
						'loginUrl'=>array('index/login'),
						'stateKeyPrefix'=>'admin',
				),
	),
	
				
	//'params'=>CMap::mergeArray(require($frontend.'/config/params.php'),require($backend.'/config/params.php3')),
	'params' => require(dirname(__FILE__).'/params.php'),
);
return CMap::mergeArray($frontendArray, $adminArray); 