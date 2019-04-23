<?php
/**
 * 理财派抽奖API

私有密钥 key  值自己设定  
类型  type	1 红包  2 金币
值    money	50
用户  username   lwx
签名  sign	md5(key + type + money + username)

www.licaipi.cn/licaipiapi.php?key=lwx123&type=1&money=50&username=porter&sign=3d722d535cb0f83091babfb49ee6ba53     红包测试地址
www.licaipi.cn/licaipiapi.php?key=lwx123&type=2&money=50&username=porter&sign=d847f8a33cda46c60c0e779b5611c855     金币测试地址
 */


$dir = dirname(__FILE__);
include_once($dir."/../core/config.inc.php");
include_once($dir."/../modules/account/account.class.php");

$key = 'lwx123';
$type = (int)$_GET['type'];
$money = (int)$_GET['money'];
$username = trim($_GET['username']);
$sign = trim($_GET['sign']);
$md5 = md5($key . $type . $money . $username);

(in_array($type, array(1, 2))  && $money && $username && $sign)  || exit('3');
$sign == $md5 || exit('1');

$sql = "select * from dw_user where username =  '{$username}' ";
if(! $user = $mysql->db_fetch_array($sql)){
	exit('2');
}

if (2 == $type) {  //红包
	$sql = "update dw_user set points = points + ".floor($money)." where user_id = ".$user['user_id'];
	$mysql->db_query($sql);
	exit('10');
	
}elseif (1 == $type){ //金币
	$data['operate_id'] = 1;
	$data['user_id'] = $user['user_id'];
	$data['money'] = $money;
	$data['type'] = 'extre_ward';
	$data['remark'] = '理财派平台抽奖红包:' . $money . '元';
	$result = accountClass::extrereward($data);
	exit('10');
}

exit('9');
