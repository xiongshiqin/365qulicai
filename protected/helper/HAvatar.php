<?php
/**
 * FLSAHS 头像上传 
 * @version $Id: CAvatar.class.php Wed Jun 06 16:23:30 CST 2012 16:23:30 $
 * @author: liuweixiong   365040381@qq.com 
 */

 class HAvatar {
 	public $avatardir= '';
 	public $avatarurl= '';
 	
 	public function __construct(){
 		$this->avatardir = $this->getBasePath() .  'data'.DIRECTORY_SEPARATOR.'avatar';
 		$this->avatarurl = $this->getBaseUrl() .  'data/avatar';
 		
 	}
 	// 本次页面请求的 url
	public function getThisUrl()
	{
		$thisUrl = $_SERVER['SCRIPT_NAME'];
		$thisUrl = "http://{$_SERVER['HTTP_HOST']}{$thisUrl}";
		return $thisUrl;
	}

	// 本次页面请求的 base-url（尾部有 /）
	public function getBaseUrl()
	{
		$baseUrl = $this->getThisUrl();
		$baseUrl = substr( $baseUrl, 0, strrpos( $baseUrl, '/' ) + 1 );
		return $baseUrl;
	}

	// 用于存储的本地文件夹（尾部有一个 DIRECTORY_SEPARATOR）
	public function getBasePath()
	{
		$basePath = $_SERVER['SCRIPT_FILENAME'];
		$basePath = substr( $basePath, 0, strrpos($basePath, '/' ) + 1 );
		$basePath = str_replace( '/', DIRECTORY_SEPARATOR, $basePath );
		return $basePath;
	}

	// 第一步：上传原始图片文件
	public function uploadAvatar( $uid )
	{
		header("Expires: 0");
        header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        header("Pragma: no-cache");
        header("Content-type: application/xml; charset=utf-8");

		// 检查上传文件的有效性
		if ( empty($_FILES['Filedata']) ) {
			return -3; // No photograph be upload!
		}

		// 本地临时存储位置
		$tmpPath = $this->getBasePath() . "data" . DIRECTORY_SEPARATOR . "{$uid}";
		

		// 如果临时存储的文件夹不存在，先创建它
		$dir = dirname( $tmpPath );
		if ( !file_exists( $dir ) ) {
			@mkdir( $dir, 0777, true );
		}

		// 如果同名的临时文件已经存在，先删除它
		if ( file_exists($tmpPath) ) {
			@unlink($tmpPath);
		}

		// 把上传的图片文件保存到预定位置
		if ( @copy($_FILES['Filedata']['tmp_name'], $tmpPath) || @move_uploaded_file($_FILES['Filedata']['tmp_name'], $tmpPath)) {
			@unlink($_FILES['Filedata']['tmp_name']);
			list($width, $height, $type, $attr) = getimagesize($tmpPath);
			if ( $width < 10 || $height < 10 || $type == 4 ) {
				//@unlink($tmpPath);
				//return -2; // Invalid photograph!
			}
		} else {
			@unlink($_FILES['Filedata']['tmp_name']);
			return -4; // Can not write to the data/tmp folder!
		}

		// 用于访问临时图片文件的 url
		$tmpUrl = $this->getBaseUrl() . "data/{$uid}";
		return $tmpUrl;
	}

	public function flashdata_decode($s) {
		$r = '';
		$l = strlen($s);
		for($i=0; $i<$l; $i=$i+2) {
			$k1 = ord($s[$i]) - 48;
			$k1 -= $k1 > 9 ? 7 : 0;
			$k2 = ord($s[$i+1]) - 48;
			$k2 -= $k2 > 9 ? 7 : 0;
			$r .= chr($k1 << 4 | $k2);
		}
		return $r;
	}

	// 第二步：上传分割后的三个图片数据流
	public function rectAvatar( $uid )
	{
		header("Expires: 0");
        header("Cache-Control: private, post-check=0, pre-check=0, max-age=0", FALSE);
        header("Pragma: no-cache");
        header("Content-type: application/xml; charset=utf-8");

		// 从 $_POST 中提取出三个图片数据流
		//$bigavatar    = $this->flashdata_decode( $_POST['avatar1'] );
		$middleavatar = $this->flashdata_decode( $_POST['avatar2'] );
		$smallavatar  = $this->flashdata_decode( $_POST['avatar3'] );
		if ( !$middleavatar || !$smallavatar ) {
			return '<root><message type="error" value="-2" /></root>';
		}
		
		$avatarpath = $this->get_avatar_path($uid) ;
        $avatarrealdir_s  = realpath( $this->avatardir. DIRECTORY_SEPARATOR .'s'.DIRECTORY_SEPARATOR. $avatarpath );
        $avatarrealdir_m  = realpath( $this->avatardir. DIRECTORY_SEPARATOR .'m'.DIRECTORY_SEPARATOR. $avatarpath );
        if(!is_dir( $avatarrealdir_s )) {
            $this->make_avatar_path( $uid, realpath($this->avatardir). DIRECTORY_SEPARATOR .'s' );
        }

        if(!is_dir( $avatarrealdir_m )) {
            $this->make_avatar_path( $uid, realpath($this->avatardir). DIRECTORY_SEPARATOR .'m' );
        }
        
        // 保存为图片文件
        $smallavatarfile = realpath( $this->avatardir) . DIRECTORY_SEPARATOR.'s'.DIRECTORY_SEPARATOR. $this->get_avatar_filepath($uid, 's');
        $middleavatarfile = realpath( $this->avatardir) . DIRECTORY_SEPARATOR.'m'.DIRECTORY_SEPARATOR. $this->get_avatar_filepath($uid, 'm');
		       if(!is_file($middleavatarfile)){ // edit by porter
			// 不存在代表第一次上传头像，第一次上传头像更新积分
			HComm::updateCredit('avatar' , $uid);
			Member::model()->updateByPk(Yii::app()->user->id , array('avatarstatus' => 1)); // 用户头像状态设置为已上传
		        }
		$success = 1;

		$fp = @fopen($middleavatarfile, 'wb');
		@fwrite($fp, $middleavatar);
		@fclose($fp);

		$fp = @fopen($smallavatarfile, 'wb');
		@fwrite($fp, $smallavatar);
		@fclose($fp);

		// 验证图片文件的正确性
		$middleinfo = @getimagesize($middleavatarfile);
		$smallinfo  = @getimagesize($smallavatarfile);
		if ( !$middleinfo || !$smallinfo || $middleinfo[2] == 4 || $smallinfo[2] == 4 ) {
			file_exists($middleavatarfile) && unlink($middleavatarfile);
			file_exists($smallavatarfile) && unlink($smallavatarfile);
			$success = 0;
		}

		// 删除临时存储的图片
		$tmpPath = $this->getBasePath() . "data" . DIRECTORY_SEPARATOR . "{$uid}";
		@unlink($tmpPath);

		return '<?xml version="1.0" ?><root><face success="' . $success . '"/></root>';
	}

	// 从客户端访问头像图片的 url
	public function getAvatarUrl( $uid, $size='m' )
	{
		return $this->getBaseUrl() . "data/{$uid}_{$size}.jpg";
	}

	// 处理 HTTP Request
	// 返回值：如果是可识别的 request，处理后返回 true；否则返回 false。
	public function processRequest()
	{
		// 从 input 参数里拆解出自定义参数
		$arr = array();
		if (isset($_GET['input'])) {
			parse_str( $_GET['input'], $arr );
			$uid = intval($arr['uid']);
		}
		

		if ( isset($_GET['a']) && $_GET['a'] == 'uploadavatar') {

			// 第一步：上传原始图片文件
			echo $this->uploadAvatar( $uid );
			return true;

		} else if ( isset($_GET['a']) &&  $_GET['a'] == 'rectavatar') {
		
			// 第二步：上传分割后的三个图片数据流
			echo $this->rectAvatar( $uid );
			//header('location:index.php?r=test/avatar');
			return 2;
		}

		return false;
	}

	// 编辑页面中包含 camera.swf 的 HTML 代码
	public function renderHtml( $uid )
	{
		// 把需要回传的自定义参数都组装在 input 里
		$input = urlencode( "uid={$uid}" );

		$baseUrl = $this->getBaseUrl();
		$uc_api = urlencode( $this->getThisUrl() );
		
		$urlCameraFlash = "{$baseUrl}images/camera.swf?ucapi={$uc_api}?r=home/avatar&input={$input}";
		$urlCameraFlash = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="447" height="477" id="mycamera" align="middle">
				<param name="allowScriptAccess" value="always" />
				<param name="scale" value="exactfit" />
				<param name="wmode" value="transparent" />
				<param name="quality" value="high" />
				<param name="bgcolor" value="#ffffff" />
				<param name="wmode" value="opaque"> 
				<param name="movie" value="'.$urlCameraFlash.'" />
				<param name="menu" value="false" />
				<embed src="'.$urlCameraFlash.'" quality="high" bgcolor="#ffffff" width="447" height="477" name="mycamera" align="middle" allowScriptAccess="always" allowFullScreen="false" scale="exactfit"  wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
			</object>';
		return $urlCameraFlash;
	}
	
	   /**
     * 获取指定uid的头像规范存放目录格式
     * 
     * @param int $uid uid编号
     * @return string 头像规范存放目录格式
     */
    public function get_avatar_path($uid) {
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        return $dir1.'/'.$dir2.'/'.$dir3;
    }

    /**
     * 在指定目录内，依据uid创建指定的头像规范存放目录
     * 
     * @param int $uid uid编号
     * @param string $dir 需要在哪个目录创建？
     */
    public function make_avatar_path($uid, $dir = '.') {
        $uid = sprintf("%09d", $uid);
        $dir1 = substr($uid, 0, 3);
        $dir2 = substr($uid, 3, 2);
        $dir3 = substr($uid, 5, 2);
        !is_dir($dir.'/'.$dir1) && mkdir($dir.'/'.$dir1, 0777);
        !is_dir($dir.'/'.$dir1.'/'.$dir2) && mkdir($dir.'/'.$dir1.'/'.$dir2, 0777);
        !is_dir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3) && mkdir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3, 0777);
    }

    /**
     * 获取指定uid的头像文件规范路径
     *
     * @param int $uid
     * @param string $size 头像尺寸，可选为'big', 'middle', 'small'
     * @param string $type 类型，可选为real或者virtual
     * @return unknown
     */
	public function get_avatar_filepath($uid, $size = 's', $type = '') {
		$size = in_array($size, array('b', 'm', 's')) ? $size : 's';
		$uid = abs(intval($uid));
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$typeadd = $type == 'real' ? '_real' : '';
		return  $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_$size.jpg";
	}
	
	/**
	 * 一次性清空指定uid用户已经存储的头像
	 *
	 * @param int $uid
	 */
	public function clear_avatar_file( $uid ){
	    $avatarsize = array( 1 => 'b', 2 => 'm', 3 => 's');
	    $avatartype = array( 'real', 'virtual' );
	    foreach ( $avatarsize as $size ){
	        foreach ( $avatartype as $type ){
	            $avatarrealpath = realpath( $this->avatardir) . DIRECTORY_SEPARATOR. $this->get_avatar_filepath($uid, $size, $type);
	            file_exists($avatarrealpath) && unlink($avatarrealpath);
	        }
	    }
	    return true;
	}
	
	public function getavatar($uid, $size){
		return $this->avatarurl . '/'. $this->get_avatar_filepath($uid, $size);
	}

 }