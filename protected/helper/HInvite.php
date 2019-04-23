<?php

/**
*	处理各种邀请连接
* @author porter 2014-11-21
*/

class HInvite{
	const REG_1 = 'pingtai';
	const REG_2 = 'yuangong';
	const REG_3 = 'touziren';
	const REG_4 = 'pengyou';
	const REG_5 = 'huodong';
	const REG_6 = 'xitong';
	const REG_7 = 'yewuyuan';

	// 1.邀请平台 此邀请码可以注册并申请开通平台  （系统发放）
	// 2.邀请员工 此邀请码邀请的人可以注册并默认申请成为该公司员工 （平台管理员发放）
	// 3.邀请平台投资人  此邀请码可以注册并批量使用，默认关注该平台 （公司内部员工发放）
	// 4.邀请注册 此邀请码可以邀请注册并在自己邀请人里面显示 （普通投资人发放）
	// 5.邀请参加活动  此邀请码可以注册并跳转到活动页 （普通投资人发放）
	// 6.邀请注册 系统发放的可用来注册的连接，只能使用一次 (系统发放)
	// 7.第三方支付业务员邀请平台入驻,只使用多次，url有效期5天(业务员发放)

	// 处理当前通过何种连接注册的，并存入cookie
	public static function inviteInit($auth){
		$deAuth = self::decodeInvite($auth);
		$type = $deAuth[0];
		switch($type){
			case self::REG_1 : { // auth为 array(HInvite::REG_1 , 平台邀请码);
				$cCode = $deAuth[1];
				// 判断是否存在公司邀请码，存在则在申请公司时判断是否存在cookieREG_1
				if(InviteCode::model()->exists("class = 2 and code = '$cCode'")){
					$cookie = new CHttpCookie('REG_1' , $auth);
					$cookie->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['REG_1'] = $cookie;
				}
			} break;

			case self::REG_2 : { // auth 为 array(HInvite::REG_2 , 公司id);
				$cpid = $deAuth[1];
				if(Company::model()->exists("cpid = " . $cpid)){
					$cookie = new CHttpCookie('REG_2' , $auth);
					$cookie->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['REG_2'] = $cookie;

					if(Yii::app()->user->id){ // 如果登录了，则跳转至申请页面
						$url = Yii::app()->request->hostInfo . Yii::app()->createUrl('/p2p/employeeApply');
						header("Location:$url");
						exit();
					}
				}
			} break;

			case self::REG_3 : { // auth 为 array(HInvite::REG_3 , 公司id);
				$cpid = $deAuth[1];
				if(Company::model()->exists("cpid = " . $cpid)){
					$cookie = new CHttpCookie('REG_3' , $auth);
					$cookie->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['REG_3'] = $cookie;
				}
			} break;

			case self::REG_4 : { // auth 为 array(HInvite::REG_4 , 发出邀请的用户id)；
				$uid = $deAuth[1];
				if(is_numeric($uid) && Member::model()->exists("uid = $uid")){
					$cookie = new CHttpCookie('REG_4' , $auth);
					$cookie->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['REG_4'] = $cookie;
				}
			} break;

			case self::REG_5 : { // auth 为 array(HInvite::REG_5 , 活动id , 用户id);
				$eventid = $deAuth[1];
				$fromUid = $deAuth[2];
				if(Event::model()->exists("eventid = $eventid")){
					$cookie = new CHttpCookie('REG_5' , $auth);
					$cookie->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['REG_5'] = $cookie;
					
					if(Yii::app()->user->id) { // 登录跳转至活动页面
						$url = Yii::app()->createUrl('/event/p2pEventDetail' , array('eventid' => $eventid));
						header("Location:$url");
						exit();
					}

				}
			} break;

			case self::REG_6 : { // auth 为 array(HInvite::REG_6 , 系统个人邀请码);
				$code = $deAuth[1];
				if(InviteCode::model()->exists("class = 1 and code = '$code'")){
					$cookie = new CHttpCookie('REG_6' , $auth);
					$cookie->expire = time() + 60*60*24;  //有限期1天
					Yii::app()->request->cookies['REG_6'] = $cookie;
				}
			} break;

			case self::REG_7 : { // auth 为 array(HInvite::REG_7 , $code);
				$code = $deAuth[1];
				if(InviteCode::model()->find("class = 3 and code = '$code' and dateline > " . time())){
					$cookie = new CHttpCookie('REG_7' , $auth);
					$cookie->expire = time() + 60*60*24*5;// 验证码有效期5天
					Yii::app()->request->cookies['REG_7'] = $cookie;				}

					if(Yii::app()->user->id){ // 如果登录了，则跳转至申请页面
						$url = Yii::app()->request->hostInfo . Yii::app()->createUrl('/p2p/apply');
						header("Location:$url");
						exit();
					}
			} break;

			default : {
			} break;
		}
	}

	// 加密邀请码
	public static function encodeInvite($auth){
		$noUse = substr(md5(mt_rand(1,100)) , 0 , 4);
		$auth = implode('-' , $auth);
		return $noUse . base64_encode($auth);
	}

	//解密邀请码
	public static function decodeInvite($auth){
		$auth = base64_decode(substr($auth, 4));
		return explode('-' , $auth);
	}
}
