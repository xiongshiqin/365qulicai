<?php
/**
 *	检测用户名是否存在Api
 *	判断理财派传入的帐号在本站是否存在
 *
 *  $key	私有key		自定义私有key  用来验证
 *  $username  用户名		理财派上用户关联本平台是填写的账户名
 *  $sign	签名		md5($username . $key)
 * @return 成功 json_encode(array('status'=>true))  失败 json_encode(array('status'=>false));
 */


$dir = dirname(__FILE__);
include_once($dir."/../core/config.inc.php");

//接收参数
$key = 'licaipi';
$username = trim($_GET['username']);
$sign = trim($_GET['sign']);

//验证签名
if(md5($username . $key) != $sign){
	exit(json_encode(array('status'=>false)));
}

//查找用户
$sql = "select * from dw_user where username =  '{$username}' limit 1";
if( $username && $user = $mysql->db_fetch_array($sql)){
	exit(json_encode(array('status'=>true)));
}

exit(json_encode(array('status'=>false)));
