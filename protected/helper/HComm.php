<?php
/**
 * 基础的重用函数库
 */
class HComm{
	
	/**
	* 获取广告位的广告路径
	* @param int place 广告位
	* @param int cpid 公司id
	* @param string attr 要取的属性
	* @author porter
	**/
	public static function getAdPicUrl($place,$cpid = 0 , $attr = 'picurl'){
		if($place && $cpid){
			$model = new CompanyAdPic();
			$pic = $model->find("status = 1 and place = $place and cpid = $cpid");
			if($pic){
				$result = $pic->$attr;
				$attr == 'picurl' && $result = BASE_URL . $result;
				return $result;
			}
		}
		// return Yii::app()->params['default_ad_pic']; //默认
		return false;

	}

	//换行空格转行
	public static function str2br($str, $type=0, $url=0){	
		$search = array(' ', chr(10));
		$replace = array('&nbsp;&nbsp;', '<br/>');
		return $type ? str_replace($search, $replace, $str) : str_replace($replace, $search, $str);
	}
	
	//使用反斜线引用字符串
	public static function Aaddslashes($string, $force = 1) {
		if(is_array($string)) {
			$keys = array_keys($string);
			foreach($keys as $key) {
				$val = $string[$key];
				unset($string[$key]);
				$string[addslashes($key)] = self::Aaddslashes($val, $force);
			}
		} else {
			$string = addslashes($string);
		}
		return $string;
	}
	
	//去掉使用反斜线引用字符串中的反斜杠
	public static function Astripslashes($string) {
		if(empty($string)) return $string;
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = self::Astripslashes($val);
			}
		} else {
			$string = stripslashes($string);
		}
		return $string;
	}
	
	//把一些预定义的字符转换为 HTML 实体
	public static function Ahtmlspecialchars($string, $flags = null) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = self::Ahtmlspecialchars($val, $flags);
			}
		} else {
			if($flags === null) {
				$string = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $string);
				if(strpos($string, '&amp;#') !== false) {
					$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4}));)/', '&\\1', $string);
				}
			} else {
				if(PHP_VERSION < '5.4.0') {
					$string = htmlspecialchars($string, $flags);
				} else {
					if(strtolower(CHARSET) == 'utf-8') {
						$charset = 'UTF-8';
					} else {
						$charset = 'ISO-8859-1';
					}
					$string = htmlspecialchars($string, $flags, $charset);
				}
			}
		}
		return $string;
	}
	
	//切割字符
	public static function  cutstr($string, $length, $dot = '') {
		if(strlen($string) <= $length) {
			return $string;
		}
		$pre = '{%';
		$end = '%}';
		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), $string);
	
		$strcut = '';
		if(1) {
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t <= 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}
		$strcut = str_replace(array($pre.'&'.$end, $pre.'"'.$end, $pre.'<'.$end, $pre.'>'.$end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);
	
		return $strcut.$dot;
	}

	//截取字符串(UTF-8)
	public static function truncate_utf8_string($string, $length, $etc = '...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++)
        {
            if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0'))
            {
                if ($length < 1.0)
                {
                    break;
                }
                $result .= substr($string, $i, $number);
                $length -= 1.0;
                $i += $number - 1;
            }
            else
            {
                $result .= substr($string, $i, 1);
                $length -= 0.5;
            }
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen)
        {
            $result .= $etc;
        }
        return $result;
    }

	//从字符串$string里删除$s
	public static function delStr($s, $string, $separator=','){
		if (empty($string)) 
			return $string;
		
		return trim(str_replace($separator.$s.$separator, $separator, $separator.$string.$separator), $separator);
	}
	
	public static function random($length, $numeric = 0) {
		$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		$hash = '';
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed{mt_rand(0, $max)};
		}
		return $hash;
	}
	
	public static function set_dir($id, $dir = '.') {
		$id = sprintf("%09d", $id);
		$dir1 = substr($id, 0, 3);
		$dir2 = substr($id, 3, 2);
		$dir3 = substr($id, 5, 2);
		!is_dir($dir.'/'.$dir1) && mkdir($dir.'/'.$dir1, 0777);
		!is_dir($dir.'/'.$dir1.'/'.$dir2) && mkdir($dir.'/'.$dir1.'/'.$dir2, 0777);
		!is_dir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3) && mkdir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3, 0777);
		return $dir.'/'.$dir1.'/'.$dir2.'/'.$dir3;
	} 
	
	public static function get_dir($id) {
		$id = sprintf("%09d", $id);
		$dir1 = substr($id, 0, 3);
		$dir2 = substr($id, 3, 2);
		$dir3 = substr($id, 5, 2);
		return $dir1.'/'.$dir2.'/'.$dir3;
	}

	// 得到公司的logo by porter
	public static function get_com_dir($id , $type = 'm'){
		$id = sprintf("%06d", $id);
		$dir1 = substr($id, 0, 2);
		$dir2 = substr($id, 2, 2);
		$dir3 = substr($id, 4, 2);
		$path =  Yii::app()->params['cplogodir'] . "/" . $type . "/$dir1/$dir2/$dir3.jpg";	
		
		if(! file_exists(Yii::getPathOfAlias('webroot') . $path)){
			$path = Yii::app()->params['default_com_img'];
		}
		$path = BASE_URL . $path;
		return $path;
	}

	// 得到小组的头像 by porter
	public static function get_group_dir($id){
		$id = sprintf("%09d", $id);
		$dir1 = substr($id, 0, 3);
		$dir2 = substr($id, 3, 3);
		$dir3 = substr($id, 6, 3);
		$path =  Yii::app()->params['grouppicdir']."/$dir1/$dir2/$dir3.jpg";	
		
		if(! file_exists(Yii::getPathOfAlias('webroot') . $path)){
			$path = Yii::app()->params['default_group_img'];
		}
		$path = BASE_URL . $path;
		return $path;
	}
	
	//获得个人头像图片ID号
	public static function get_avatarid($id){
		return substr(sprintf("%09d", $id), 7, 2);
	}
	
	public static function getpath(){
		return Yii::app()->BasePath;
	}
	
	/**
	 * 将ip地址转换成整型，解决ip2long转化成整数后，是负的		long2ip
	 * 这是因为得到的结果是有符号整型，最大值是2147483647.要把它转化为无符号的   2147483647
	 * @param string $ip_address ip地址
	 * @return int  
	 */
	public static function ip2int($ip_address){
   		return bindec(decbin(ip2long($ip_address)));
	}
	
	//获得图书图片
	public static function bookpic($bookid, $type='s'){
		$type=($type=='s' || $type=='m') ? $type : 's';
		$imgpath=Yii::app()->params->bookdir.'/'.$type.'/'.self::get_dir($bookid).'/'.$type.'_'.self::get_avatarid($bookid).'.jpg';
		$imgfile=dirname(self::getpath()).$imgpath;
		
		if (file_exists($imgfile)) 
			return $imgpath;
		else 
			return '/images/book_'.$type.'.jpg';
	}
	
	//获取个人头像
	public static function avatar($uid, $type='s'){
		$type=($type=='s' || $type=='m') ? $type : 's';
		$imgpath=Yii::app()->params->avatardir.'/'.$type.'/'.self::get_dir($uid).'/'.self::get_avatarid($uid).'_'.$type.'.jpg';
		$imgfile=dirname(self::getpath()).$imgpath;
		
		if (file_exists($imgfile)) 
			return $imgpath;
		else 
			return '/images/avatar_'.$type.'.jpg';
	}

	public static function avatarpath($uid, $type='s'){
		$type=($type=='s' || $type=='m') ? $type : 's';
		$imgpath = Yii::app()->request->hostInfo . Yii::app()->params->avatardir.'/'.$type.'/'.self::get_dir($uid).'/'.self::get_avatarid($uid).'_'.$type.'.jpg';
		return $imgpath;
	}
	
	//得到 我还是昵称 
	public static function getNickname($uid, $username){
		return (Yii::app()->user->id != $uid && $uid && $username)? $username : '我';
	}
	
	//隐藏电话等信息
	public static function hideinfo($s, $hide=1, $star=2, $lenth=3){
		if (empty($s))
			return '';
		return ($hide==2)? $s: substr($s, $star, $lenth).'***'.substr($s, $star+$lenth);
	}
	
	//时间格式化
	public static function sgmdate($dateformat, $timestamp='', $format=1) {
		if(empty($timestamp)) 
			$timestamp = time();
		
		$result = ''; 
		if($format) {
			$time = time() - $timestamp;
			if($time > 90*24*3600) {
				$result = gmdate($dateformat, $timestamp);
			} elseif($time > 30*24*3600) {
				$result = intval($time/(30*24*3600)).'月前';
			} elseif($time > 7*24*3600) {
				$result = intval($time/(7*24*3600)).'星期前';
			} elseif($time > 24*3600) {
				$result = intval($time/(24*3600)).'天前';
			} elseif ($time > 3600) {
				$result = intval($time/3600).'小时前';
			} elseif ($time > 60) {
				$result = intval($time/60).'分钟前';
			} elseif ($time > 0) {
				$result = $time.'秒钟前';
			} else {
				$result = '刚刚';
			}
		} else {
			$result = gmdate($dateformat, $timestamp);
		}
		return $result;
	}
	
	//编码
	public static function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
		$ckey_length = 4;
		$key = md5($key != '' ? $key : 'haoshuyou');
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);
	
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);
	
		$result = '';
		$box = range(0, 255);
	
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}
	
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}
	
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}
	
		if($operation == 'DECODE') {
			if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			return $keyc.str_replace('=', '', base64_encode($result));
		}
	
	}
	//qqshare  为QQ分享增加site formurl
	public static function  qqshare($sharearr){
		if (is_array($sharearr)) {
			$sharearr['site'] = Yii::app()->name;
			$sharearr['fromurl'] = Yii::app()->request->hostInfo;
		}
		return $sharearr;
	}
	
	//返回一个数值是上一个和下一个 
	public static function getNextPriv($arr, $i){
		$re = array('next'=>0, 'priv'=>0, 'corrent'=>0);
		if (is_array($arr)) {
			$arr_2 = array_flip($arr);
			$count = count($arr);
			if ($count==1) {
				$re['next']=$re['priv']=$arr[0];
			}else {
				$re['next'] = $arr[$arr_2[$i] + 1] ? $arr[$arr_2[$i] + 1] : $arr[0];
				$re['priv'] = $arr[$arr_2[$i] - 1] ? $arr[$arr_2[$i] - 1] : $arr[$count-1];
			}
		}
		$re['corrent'] = $arr_2[$i]+1;
		return $re;		
	}
	
	public static function getInviteCode($num =2){
		$re = array();
		$code_arr = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
							'0','1','2','3','4','5','6','7','8','9');
							
		$num = intval($num)	;						
		for ($i = 0; $i < $num; $i++){
			$tmp_arr = array_rand($code_arr, 4);
			$re[] =  $code_arr[$tmp_arr[0]] . $code_arr[$tmp_arr[1]] . $code_arr[$tmp_arr[2]] . $code_arr[$tmp_arr[3]];
		}
		return $re;
	}
	
	// 读取当前用户等级
	public static function creditLevel($uid=null){
	 	$uid = empty($uid)? Yii::app()->user->id : $uid;
		$creditLevel = Yii::app()->params['params_credit']['credit_level'];
		$userCredit = MemberCount::model()->findByPk($uid)->credit;
		$level = 'LV1';
		foreach($creditLevel as $key => $v){
			if($userCredit < $v){
				$level = $key;
				break;
			}
		}
		return $level;
	}

	//更新积分
	public static function updateCredit($code, $uid=0){
	    if (! $credit = Yii::app()->params['params_credit']['credit'][$code]) 
	    	return false;
	    $uid = empty($uid)? Yii::app()->user->id : $uid;
	    MemberCount::model()->findByPk($uid)->saveCounters(array('credit'=>$credit[2])); //更新积分
	    MemberCount::model()->findByPk($uid)->saveCounters(array('gold'=>$credit[3])); //更新金币
	    	    
	    $CreditLog = new CreditLog();
	    $CreditLog->uid = $uid;
	    $CreditLog->ruleid = $credit[0];
	    $CreditLog->content = $credit[1];
	    $CreditLog->num = $credit[2];
	    $CreditLog->gold = $credit[3];
	    $CreditLog->dateline = time();
	    
	    if($CreditLog->validate() && $CreditLog->save())
    		return true;
    	    else 
    		return false;
	}

	//得到IP
	public static function getIP() { 
		if (@$_SERVER["HTTP_X_FORWARDED_FOR"]) 
			$ip = $_SERVER["HTTP_X_FORWARDED_FOR"]; 
		else if (@$_SERVER["HTTP_CLIENT_IP"]) 
			$ip = $_SERVER["HTTP_CLIENT_IP"]; 
		else if (@$_SERVER["REMOTE_ADDR"]) 
			$ip = $_SERVER["REMOTE_ADDR"]; 
		else if (@getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR"); 
		else if (@getenv("HTTP_CLIENT_IP")) 
			$ip = getenv("HTTP_CLIENT_IP"); 
		else if (@getenv("REMOTE_ADDR")) 
			$ip = getenv("REMOTE_ADDR"); 
		else 
			$ip = 0; 
		return ip2long($ip); 
	}
	
	/**
	 * 发送短信
	 *
	 * @param int $mobile    手机号
	 * @param char $message  发送内容
	 * @return 
	 */
	public static function sendSms($mobile, $message){
		$res = 'fail';
		if (!empty($mobile) && !empty($message)) {
			// http://124.172.250.160/WebService.asmx/mt?Sn=lcp&Pwd=nmkij225&mobile=13501593761&content=test;
		
			//$res  = file_get_contents('http://'.Yii::app()->params->sms['host'].'/WebService.asmx/mt?Sn='.Yii::app()->params->sms['name'].'&Pwd='.Yii::app()->params->sms['pwd'].'&mobile='.$mobile.'&content='.rawurlencode($message));
			// http://124.172.250.160/WebService.asmx/mt?Sn=lcp&Pwd=nmkij225&mobile=13501593761&content=test;
			$smsapi  = 'http://sms.1xinxi.cn/asmx/smsservice.aspx'; //短信网关
			$user    = '18576421507'; //短信平台帐号
			$pass    = '9DB08227186D8149C60D3A74495D'; //短信平台密码
	 		$phone   = $mobile;//要发送短信的手机号码
	 		$sign    = '365趣理财';
			$sendurl = $smsapi."?type=pt&sign=".$sign."&name=".$user."&pwd=".$pass."&mobile=".$phone."&content=".urlencode($message);
			//$res     = substr(file_get_contents($sendurl), 0, 1) ;
			$res     = file_get_contents($sendurl);
		}	
		return $res;
	}


	/**
	 * 导出二维报表
	 *
	 * @param char  $fileName  excel文件名称
	 * @param array $title     excel文件内容头部标题
	 * @param array $data      excel文件内容，二维数组
	 * @return 
	 */

	public static function exportExcel( $fileName, $title = array(''), $data = array('') ){

		Yii::import('application.extensions.phpExcel.*');
		require_once('phpExcel.php');

		array_unshift($data, $title);

		//p($data);exit;

		$xls = new Excel_XML('UTF-8', false, '表格1');
		
		$xls->addArray($data);

		$xls->generateXML($fileName);

		exit;

	}

	/**
	 * 发邮件
	 *
	 * @param char  $replyTo  接收方邮箱地址
	 * @param char $subject  邮件标题
	 * @param char $body     邮件内容
	 * @return 
	 */

	public static function sendMail( $sendTo, $subject, $body ){

		Yii::import('application.extensions.phpMailer.*');
		require_once('phpmailer.class.php');

		$mail = new PHPmailer();

		$mail->SMTPDebug = 1;                    			// 1：关闭错误信息提示；2：开启错误提示
		$mail->IsSMTP();									// 启用SMTP
		$mail->CharSet 	= "utf-8";							// 这里指定字符集！
		$mail->Encoding = "base64"; 
		//$mail->SMTPSecure = "ssl";   
		$mail->Host     = "smtp.mxhichina.com";				//SMTP服务器
		$mail->Port     = 25;
		
		$mail->SMTPAuth = true;								//开启SMTP认证
		$mail->Username = "service@licaipi.com";			// SMTP用户名
		$mail->Password = "Servlicai678@#$";				// SMTP密码

		$mail->From     = "service@licaipi.com";			//发件人地址
		$mail->FromName = "service@licaipi.com";				//发件人
		$mail->AddAddress( $sendTo );						//添加收件人
		//$mail->AddAddress("ellen@example.com");
		//$mail->AddReplyTo($email);						//回复地址
		$mail->WordWrap = 50;                               //设置每行字符长度
		/** 附件设置
		$mail->AddAttachment("/var/tmp/file.tar.gz");		// 添加附件
		$mail->AddAttachment("/tmp/image.jpg", "new.jpg");	// 添加附件,并指定名称
		*/

		$mail->IsHTML(true);								// 是否HTML格式邮件

		$mail->Subject  = $subject;							//邮件主题
		$mail->Body     = $body;							//邮件内容
		//$mail->AltBody  = "This is the body in plain text for non-HTML mail clients";	//邮件正文不支持HTML的备用显示
		//echo 1;exit;
		if(!$mail->Send()){
		   return -1;   
		}else{
			return 1;
		}

	}

	// 下载
	public static function download($path , $filename){
		header("Content-type:text/html;charset=utf-8"); 
		// $file_name="cookie.jpg"; 
		//用以解决中文不能显示出来的问题 
		$filename=iconv("utf-8","gb2312",$filename); 
		$file_path=$path . $filename; 
		//首先要判断给定的文件存在与否 
		if(!file_exists($file_path)){ 
			echo "没有该文件文件"; 
			return ; 
		} 
		$fp=fopen($file_path,"r"); 
		$file_size=filesize($file_path); 
		//下载文件需要用到的头 
		Header("Content-type: application/octet-stream"); 
		Header("Accept-Ranges: bytes"); 
		Header("Accept-Length:".$file_size); 
		Header("Content-Disposition: attachment; filename=".$filename); 
		$buffer=1024; 
		$file_count=0; 
		//向浏览器返回数据 
		while(!feof($fp) && $file_count<$file_size){ 
		$file_con=fread($fp,$buffer); 
		$file_count+=$buffer; 
		echo $file_con; 
		} 
		fclose($fp);
	}

	/** 加密数组
	* @param array $auth
	* return string
	**/
	public static function encodeAuth($auth){
		$noUse = substr(md5(mt_rand(1,100)) , 0 , 4);
		$auth = implode('-' , $auth);
		return $noUse . base64_encode($auth);
	}

	/** 解密字符
	* @param string $auth
	* return array
	**/
	public static function decodeAuth($auth){
		$auth = base64_decode(substr($auth, 4));
		return explode('-' , $auth);
	}

	/** 生成新浪短地址
	* @param string $url 要生成的地址
	**/
	public static function sinaurl($url, $key = '1335371408') {
		$url = urlencode($url);
		$opts['http'] = array('method' => "GET", 'timeout'=>60,);
		$context = stream_context_create($opts);
		$url = "http://api.t.sina.com.cn/short_url/shorten.json?source=$key&url_long=$url";
		$html =  @file_get_contents($url,false,$context);
		$url = json_decode($html,true);
		if (!empty($url[0]['url_short'])) {
			return $url[0]['url_short'];
		}
	}

	/** 解析新浪短地址
	* @param string $url 要解析的短地址
	**/
	public static function expandurl($short_url , $key = '1335371408'){
	    $apiUrl='http://api.t.sina.com.cn/short_url/expand.json?source='.$key.'&url_short='.$short_url;
	 
	    $response = file_get_contents($apiUrl);
	    $json = json_decode($response);
	    return $json[0]->url_long;
	}

}

