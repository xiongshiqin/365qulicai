<?php
/**
 *	关联平台账号API
 *	根据理财派用户手机号获取P2P平台帐号
 *
 *  $key	私有key		自定义私有key  用来验证
 *  $phone  手机号		用户在理财派注册时的手机号码，并把此手机号码向P2P平台发送，根据这手机号查看是否有在P2P平台注册
 *  $sign	签名		md5($phone . $key)
 * @return 成功 json_encode(array('status'=>true , 'username'=>array()))  失败 json_encode(array('status'=>false));
 */


$dir = dirname(__FILE__);
include_once($dir."/../core/config.inc.php");

//接收参数
$key = 'licaipi';
$phone = trim($_GET['phone']);
$sign = trim($_GET['sign']);

//验证签名
if(md5($phone . $key) != $sign){
	exit(json_encode(array('status'=>false)));
}

//查找用户
$sql = "select * from dw_user where phone =  '{$phone}' limit 3";
if( $phone && $user = $mysql->db_fetch_arrays($sql)){
	$result = array();
	foreach($user as $v){
		//返回一律为UTF-8编码，请非UTF-8编码的自动转码为UTF-8
		//$result[] = iconv('GB2312', 'UTF-8', $v['username']);
		$result[] = $v['username'];
	}
	exit(json_encode(array('status'=>true , 'username'=>$result)));
}

exit(json_encode(array('status'=>false)));
