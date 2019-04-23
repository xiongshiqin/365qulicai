<?php
class lotteryWidget extends CWidget {

	public $assets = '';
	public $skin = 'rotary'; 
	public $levnum = 3; // 默认三等奖
	public $lotid = 0;
	public $resultUrl = null;
	public $lotterytype = 1;

	public function init() {
		$skinArr = array(
			1 => 'egg',
			2 => 'rotary',
			3 => 'turn',
			);
		$this->skin = $skinArr[$this->lotterytype];
		// 抽奖结果url
		$this->resultUrl = Yii::app()->createUrl('/lottery/lotteryResult');  // 动态判断不同奖项的访问方法

		$this->assets = Yii::app()->assetManager->publish(dirname(__FILE__).DIRECTORY_SEPARATOR.'assets');
		
		Yii::app()->clientScript
		->registerScriptFile( $this->assets.'/js/jQueryRotate.2.2.js' )
		->registerScriptFile( $this->assets.'/js/jquery.easing.min.js' )
		->registerScriptFile( $this->assets.'/js/jquery.flip.min.js' )
		->registerScriptFile( $this->assets.'/js/lottery.js' )
		->registerCssFile( $this->assets.'/css/zhuanpan.css' )
		->registerCssFile( $this->assets.'/css/zhuanpanapi.css' )
		->registerCssFile( $this->assets.'/css/turntable.css' ); 
		
		// Yii::app()->getClientScript()->registerScript('startbtn',"
		// 	$('#startbtn').click(function() { lottery( '" . $resultUrl . "' , " .  $this->lotid . ");});
		// ");

		parent::init();
	}

	public function run(){
		$this->render($this->skin);		
	}
}
?>