<?php
/**
 * KindEditor PHP
 *
 * 本PHP程序是演示程序，建议不要直接在实际项目中使用。
 * 如果您确定直接使用本程序，使用之前请仔细确认相关安全设置。
 *
 */

require_once 'JSON.php';

$php_path = dirname(__FILE__) . '/../../';
$php_url = dirname($_SERVER['PHP_SELF']) . '/../../';

//edit by porter at 2014年9月16日 11:19:01 修改文件上传路径
// 如果isCom为true 代表上传类型为公司logo  
$isCom = isset($_GET['isCom']) ? $_GET['isCom'] : '';
$comType = isset($_GET['comType']) ? $_GET['comType'] : 'm';
$isGroup = isset($_GET['isGroup']) ? $_GET['isGroup'] : '';
//文件保存目录路径    
if($isCom){
	$save_path = $_SERVER['DOCUMENT_ROOT'].'\\data\\cplogo\\' . $comType . '\\';
	$save_url = '/data/cplogo/' . $comType . '/';
} elseif($isGroup){
	$save_path = $_SERVER['DOCUMENT_ROOT'].'\\data\\grouppic\\';
	$save_url = '/data/grouppic/';
} else {
	$save_path = $_SERVER['DOCUMENT_ROOT'].'\\data\\attached\\';
	$save_url = '/data/attached/';
}
// end edit
// $save_path = $php_path . '../data/attached/';
// //文件保存目录URL
// $save_url = $php_url . '../data/attached/';
//定义允许上传的文件扩展名
$ext_arr = array(
	'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
	'flash' => array('swf', 'flv'),
	'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
	'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2'),
);
//最大文件大小
$max_size = 1000000;

// edit by porter at 2014年11月10日 12:10:04 realpath在linux服务器上返回空
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	$save_path = realpath($save_path) . '/'; 
} else {
  	$save_path = $path=str_replace('\\' , '/' , $save_path);
}

//PHP上传失败
if (!empty($_FILES['imgFile']['error'])) {
	switch($_FILES['imgFile']['error']){
		case '1':
			$error = '超过php.ini允许的大小。';
			break;
		case '2':
			$error = '超过表单允许的大小。';
			break;
		case '3':
			$error = '图片只有部分被上传。';
			break;
		case '4':
			$error = '请选择图片。';
			break;
		case '6':
			$error = '找不到临时目录。';
			break;
		case '7':
			$error = '写文件到硬盘出错。';
			break;
		case '8':
			$error = 'File upload stopped by extension。';
			break;
		case '999':
		default:
			$error = '未知错误。';
	}
	alert($error);
}

//有上传文件时
if (empty($_FILES) === false) {

	//原文件名
	$file_name = $_FILES['imgFile']['name'];
	//服务器上临时文件名
	$tmp_name = $_FILES['imgFile']['tmp_name'];
	//文件大小
	$file_size = $_FILES['imgFile']['size'];
	//检查文件名
	if (!$file_name) {
		alert("请选择文件。");
	}
	//检查目录
	if (@is_dir($save_path) === false) {
		alert("上传目录不存在。");
	}

	//检查目录写权限
	// if (@is_writable($save_path) === false) { // 注释 by porter at  2014年11月10日 11:34:42
	// 	alert("上传目录没有写权限。");
	// }
	//检查是否已上传
	if (@is_uploaded_file($tmp_name) === false) {
		alert("上传失败。");
	}
	if($isCom){
		$image_size   =   getimagesize($tmp_name);
		if($comType == 's'){
			if($image_size[0] / $image_size[1] < 0.8 || $image_size[0] / $image_size[1] > 1.2){
				alert("平台小logo应该为正方形");
			}
		} else {
			if($image_size[0]<180 || $image_size[0]>225){
				alert("平台logo宽度应该在180~220之间");
			}
			if($image_size[1] < 50 || $image_size[1] > 70){
				alert("平台logo高度应该在50~70之间");
			}
		}
		print( "图片的宽度： ".   $image_size[0]. " <br> ");
		print( "图片的高度： ".   $image_size[1]. " <br> ");
		print( "文件的格式为： ".   $image_size[2]. " <br> ");
	}
	//检查文件大小
	if ($file_size > $max_size) {
		alert("上传文件大小超过限制。");
	}
	//检查目录名
	$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
	if (empty($ext_arr[$dir_name])) {
		alert("目录名不正确。");
	}
	//获得文件扩展名
	$temp_arr = explode(".", $file_name);
	$file_ext = array_pop($temp_arr);
	$file_ext = trim($file_ext);
	$file_ext = strtolower($file_ext);
	//检查扩展名
	if (in_array($file_ext, $ext_arr[$dir_name]) === false) {
		alert("上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr[$dir_name]) . "格式。");
	}
	//创建文件夹
	if ($dir_name !== '') {
		// $save_path .= $dir_name . "/"; // edit by porter at 2014年12月9日 14:29:36 取消image文件夹
		// $save_url .= $dir_name . "/";
		if (!file_exists($save_path)) {
			@mkdir($save_path , 0777 , true);
		}
	}

	// edit by porter at 2014年9月20日 15:12:42 如果isCom不为0 目录形式采用id分割法，否则用时间
	if($isCom){
		$comDir = sprintf("%06d", $isCom);
		$dir1 = substr($comDir, 0, 2);
		$dir2 = substr($comDir, 2, 2);
		$dir3 = substr($comDir, 4, 2);
		$save_path .= $dir1 . "\\" . $dir2 ."\\";
		$save_url .= $dir1 . "/" . $dir2 ."/";
		// 新文件名
		$new_file_name = $dir3 . '.jpg' ;
	} else if($isGroup){
		$gDir = sprintf("%09d", $isGroup);
		$dir1 = substr($gDir, 0, 3);
		$dir2 = substr($gDir, 3, 3);
		$dir3 = substr($gDir, 6, 3);
		$save_path .= $dir1 . "\\" . $dir2 ."\\";
		$save_url .= $dir1 . "/" . $dir2 ."/";
		// 新文件名
		$new_file_name = $dir3 . '.jpg' ;
	} else {
		$ymd = date("Ymd");
		$save_path .= $ymd . "/";
		$save_url .= $ymd . "/";
		//新文件名
		$new_file_name = date("YmdHis") . '_' . rand(10000, 99999) . '.' . $file_ext;
	}
	if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') { // 防止linux目录不能读取\
  		$save_path = $path=str_replace('\\' , '/' , $save_path);
	}
	// end edit
	if (!file_exists($save_path)) {
		@mkdir($save_path,0777,true);
	}
	//移动文件
	$file_path = $save_path . $new_file_name;
	if (move_uploaded_file($tmp_name, $file_path) === false) {
		alert("上传文件失败。");
	}
	@chmod($file_path, 0644);
	$file_url = $save_url . $new_file_name;

	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 0, 'url' => $file_url));
	exit;
}

function alert($msg) {
	header('Content-type: text/html; charset=UTF-8');
	$json = new Services_JSON();
	echo $json->encode(array('error' => 1, 'message' => $msg));
	exit;
}
