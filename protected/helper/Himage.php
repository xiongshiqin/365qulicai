<?php
/**
* author : beyond_dream
* date :2013-4-29 图片上传类 
**/
class Himage {

	public $size;		//定义的文件大小
	public $file;		//接收文件属性
	public $class;  	//上传类型 活动，个人，站点
	public $name;		//自定义的文件名
	public $dir;		//大图上传目录
	public $dir_thumb;	//小图上传目录
	public $thumb;		//是否缩略图
	public $err='';		//错误
	public $filepath = array(); //上传后，文件的具体路径
	
	//参数： 文件流，上传类型，大小，目录， 是否缩略图
	public function __construct($file, $class='event', $size=2, $thumb=1, $name=''){
		$this->size = $size * 1024 * 1024;
		$this->file = $file;
		$this->class = $class;
		$this->name = $name;
		$this->thumb = $thumb;
		
	}
	
	//上传
	public function upload(){
		if ($this->check_size() && $this->check_pix() && $this->check_type() && $this->check_class() && $this->check_dir()) {
			$imagename = time().rand(100,999);
			$this->name .= '/'.$imagename;
			
			if (! move_uploaded_file($this->file['tmp_name'], $this->dir .'/'.$imagename.'.jpg' ) ) {
				$this->err = '文件上传错误';
				return false;
			}else {
				array_push($this->filepath, $this->class.'/'.$this->name);
				
				require_once YII::app()->basePath. '/extensions/phpthumb/ThumbLib.inc.php';  
  
				$thumb = PhpThumbFactory::create($this->dir .'/'.$imagename.'.jpg');  
				$thumb->adaptiveResize(100, 100)->save($this->dir .'/'.$imagename.'_thumb.jpg'); 

				return true;
			}
		}else 
			return false;		
	}
	
	public function check_error(){
		if ($this->file['error']) {
			$this->err = '文件上传错误';
			return false;
		}else 
			return true;
	}
	public function is_uploaded_file(){
		if (!is_uploaded_file($this->file)) {
			$this->err = '文件上传途径不合法';
			return false;
		}else 
			return true;
	}
	
	//图像大小
	public function check_size(){
		if ($this->file['size'] < $this->size  && $this->file['size'] > 1000) {
			return true;
		}else {
			$this->err = '上传的图片大小最小1K，最大2M，去检查图片大小';
			return false;
		}
	}	
	
	//图像像素大小 100 x 100
	public function check_pix(){
		$re = getimagesize($this->file['tmp_name']);
		if ($re[0] >= 100  && $re[1] >= 100) {
			return true;
		}else {
			$this->err = '图片太小了，上传的图片高度和宽度都要大于100像素，请换个大一点的图片吧 :)';
			return false;
		}
	}		
	//文件类型
	public function check_type(){
		$type_arr = array('image/x-png', 'image/png', 'image/pjpeg', 'image/jpeg', 'image/jpg');
		if (in_array($this->file['type'], $type_arr)) {
			return true;
		}else {
			$this->err = '上传JPG，JPEG， GIF，PNG或BMP文件';
			return false;
		}
	}
	
	//检查上传类型
	public function check_class(){
		$class_arr = array('event', 'site', 'home', 'bookshare');
		if (in_array($this->class, $class_arr)) {
			return true;
		}else {
			$this->err = '文件上传类型错误';
			return false;
		}
	}
	
	//文件目录
	public function check_dir(){
		$this->name = date("Ymd");
		$this->dir = $this->getBasePath() . 'data' . DIRECTORY_SEPARATOR . $this->class . DIRECTORY_SEPARATOR .$this->name;
		$this->dir_thumb = $this->getBasePath() . 'data' . DIRECTORY_SEPARATOR . $this->class .'_thumb' . DIRECTORY_SEPARATOR .$this->name;
		if (!is_dir($this->dir)) {
			$res = @mkdir($this->dir, 0777);
			@touch($this->dir.'/index.html');
		}
		$res2 = 1;
		if ($this->thumb && !is_dir($this->dir_thumb)) {
			$res2 = @mkdir($this->dir_thumb, 0777);
			@touch($this->dir_thumb.'/index.html');
		}
		if (is_dir($this->dir) && is_dir($this->dir_thumb)) {
			return true;
		}else {
			$this->err = '文件目录错误';
			return false;
		}
	}
	
	// 用于存储的本地文件夹（尾部有一个 DIRECTORY_SEPARATOR）
	public function getBasePath()
	{
		$basePath = $_SERVER['SCRIPT_FILENAME'];
		$basePath = substr( $basePath, 0, strrpos($basePath, '/' ) + 1 );
		$basePath = str_replace( '/', DIRECTORY_SEPARATOR, $basePath );
		return $basePath;
	}

}