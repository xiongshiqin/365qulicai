<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	// public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

	/**
	 * @return string the page title. Defaults to the controller name and the action name.
	 */
	
	public function init(){ // edit by porter at 2014年12月15日 09:49:27 初始化全局设置 将数据库settings存放到参数中
		Yii::app()->params['Settings'] = Settings::model()->getAll();
	}

	public function redirectMessage($message, $url, $type='error', $delay=3, $script='', $layout='simple')
	{
	    $this->layout = $layout == null? false : '//layouts/main';
	    if(is_array($url))
	    {
	        $route=isset($url[0]) ? $url[0] : '';
	        $url=$this->createUrl($route,array_splice($url,1));
	    }
	    $this->render('//comm/redirect', array(
	        'message' => $message,
	        'url' => $url,
	        'type' => $type, //error success
	        'delay' => $delay,
	        'script' => $script,
	    ));
	    Yii::app()->end();
	}
	
	//  ajax信息返回成功  
	public function ajaxSucReturn($msg='' , $data = ''){
		echo json_encode(array('status' => true , 'msg' => $msg , 'data' => $data));
		exit();
	}

	// ajax信息返回失败
	public function ajaxErrReturn($msg='' , $data = ''){
		echo json_encode(array('status' => false, 'msg' => $msg , 'data' => $data));
		exit();
	}

}