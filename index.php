<?php
// change the following paths if necessary
$yii = dirname(__FILE__).'/framework/yii.php';
$config = dirname(__FILE__).'/protected/config/main.php';


defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

define('BASE_URL','http://'.$_SERVER['HTTP_HOST']);
define('PROTECTED_PATH',dirname(__FILE__).'/protected/'); //项目protected文件夹路径
define('IMG_PATH',dirname(__FILE__).'/data/attached/image/'); // 上传图片路径

require_once($yii);

// edit by porter at 2014年9月15日 10:28:09 加载公共文件
require(PROTECTED_PATH.'common/functions.php');
// end edit
Yii::createWebApplication($config)->run();



// edit by porter at 2014年12月15日 09:49:27 初始化全局设置 将数据库settings存放到参数中
// $config['params']['Settings'] = Settings::model()->getAll();
// Settings::model()->set('test' , 'aaa');
// Yii::app()->params['Settings'] = Settings::model()->getAll();
