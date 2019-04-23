<?php
/**
 * 公共信息  例如城市
 * @author porter 
 * 2014-9-18
 */
		// // 没有model 查询数据库 方法一
		// getDb();  $db->createCommand($sql);
		// $rows = $command->queryAll();
		// // 没有model 查询数据库 方法二
		// $all = Yii::app()->db->createCommand()
		// 			->select('id,username,city_id')
		// 			->form('user')
		// 			->where(array('in','id',array(5,6)))
		// 			->queryAll();
class AjaxController  extends Controller{
	// 获得省份信息
	public function actionProvinceData(){
		$province = AreaProvince::model()->findAll();
		echo json_encode(CHtml::listData($province,'provinceid','pname'));
	}

	// 获得当前省份的城市信息
	public function actionCityData(){
		$provinceid = Yii::app()->request->getParam('provinceid');
		$city = AreaCity::model()->findAllByAttributes(array('provinceid'=>$provinceid));
		echo json_encode(CHtml::listData($city,'cityid','city'));
	}

	// 获得当前城市的区域信息
	public function actionAreaData(){
		$cityid = Yii::app()->request->getParam('cityid');
		$area = Area::model()->findByAttributes(array('cityid'=>$cityid));
		echo json_encode(CHtml::listData($area,'areaid','area'));
	}

	// 添加关注公司
	public function actionAddComRelation(){
		$cpid = Yii::app()->request->getParam('cpid');

		$follow = new CompanyFollow();
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn("needLogin");	
		}

		$follow->uid = Yii::app()->user->id;
		$follow->cpid = $cpid;
		if($follow->save()){
			$html = $this->widget('CompanyRelationship' , array('cpid' => $cpid) , true);
			$this->ajaxSucReturn('关注成功!',$html);
		}
		$this->ajaxErrReturn("操作失败!");
	}

	// 关联公司
	public function actionRelateCom(){
		$cpid = Yii::app()->request->getParam('cpid');
		$p2pname = Yii::app()->request->getParam('p2pname' , '');
		// 之前关注和关联是分开的，现在改成一个动作
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn("needLogin");	
		}

		$follow = CompanyFollow::model()->find("cpid = $cpid and uid = " . Yii::app()->user->id);
		if(! $follow){
			$follow = new CompanyFollow();
			$follow->uid = Yii::app()->user->id;
			$follow->cpid = $cpid;

			HComm::updateCredit('like_com'); //如果是新数据，代表关注
		}

		// if(! $follow){
		// 	$this->ajaxErrReturn('请先关注平台!');
		// }
		// if(! strlen($p2pname)){
		// 	$this->ajaxErrReturn('请输入平台帐号');
		// }
		$follow->p2pname = trim($p2pname);
		if($p2pname){
			// 检测关联用户名是否正确
			$companyApi = CompanyApi::model()->findByPk($cpid);
			if($companyApi && $companyApi->user_check){
				$apiArr = explode('?key=' , $companyApi->user_check);

				$key = isset($apiArr[1]) ? $apiArr[1] : '';
				$sign=md5($p2pname . $key);
				$url = $apiArr[0] . "?username=$p2pname&sign=$sign";
				$curlResult = HCurl::newInstance()->url($url)->get();
				$result = json_decode($curlResult['data'] , true);
				if($result['status'] !== true){
					$this->ajaxErrReturn("关联名在" . Company::model()->findByPk($cpid)->name . "上不存在");
				}
			}
			HComm::updateCredit('relation_com'); //如果有p2pname，代表关联
		}	
		if($follow->save()){
			$html = $this->widget('CompanyRelationship' , array('cpid' => $cpid) , true);
			$this->ajaxSucReturn('操作成功!',$html);
		}
		$this->ajaxErrReturn("操作失败!");

	}

	// 取消关注公司
	public function actionRemComRelation(){
		$cpid = Yii::app()->request->getParam('cpid');

		if(!Yii::app()->user->id){
			$this->ajaxErrReturn("needLogin");	
		}
		if(!$follow = CompanyFollow::model()->find("uid = :uid and cpid = :cpid",array(':uid'=>Yii::app()->user->id,':cpid'=>$cpid))){
			$this->ajaxErrReturn("您没有关注过该平台!");
		}
		if($follow->delete()){
			$html = $html = $this->widget('CompanyRelationship' , array('cpid' => $cpid) , true);
			$this->ajaxSucReturn('操作成功!',$html);
		}
		$this->ajaxErrReturn("操作失败!");
	}

	// 添加关注用户
	public function actionAddRelation(){
		$fuid = Yii::app()->request->getParam('fuid');

		$follow = new Follow();
		if(!Yii::app()->user->id){
			$this->ajaxErrReturn("needLogin");	
		}
		if(Follow::model()->exists("uid = :uid and fuid = :fuid",array(':uid'=>Yii::app()->user->id,':fuid'=>$fuid))){
			$this->ajaxErrReturn("您已经关注过该平台!");
		}
		$follow->uid = Yii::app()->user->id;
		$follow->fuid = $fuid;
		if($follow->save()){
			$html = $this->widget('Relationship' , array('fuid' => $fuid) , true);
			$this->ajaxSucReturn('操作成功!',$html);
		}
		$this->ajaxErrReturn("操作失败!");
	}

	// 取消关注用户
	public function actionRemRelation(){
		$fuid = Yii::app()->request->getParam('fuid');

		$follow = new Follow();
		if(!Yii::app()->user->id){
			$this->ajaxErrReturn("needLogin");	
		}
		if(!$follow = Follow::model()->find("uid = :uid and fuid = :fuid",array(':uid'=>Yii::app()->user->id,':fuid'=>$fuid))){
			$this->ajaxErrReturn("您没有关注过该平台!");
		}
		if($follow->delete()){
			$html = $this->widget('Relationship' , array('fuid' => $fuid) , true);
			$this->ajaxSucReturn('操作成功!',$html);
		}
		$this->ajaxErrReturn("操作失败!");
	}

	// 感兴趣的标
	public function actionAddBiaoLike(){
		$biaoid = Yii::app()->request->getParam('biaoid');
		$cpid = Yii::app()->request->getParam('cpid');
		if(!Yii::app()->user->id){
			$this->ajaxErrReturn('needLogin');
		}
		$biaoLike = new BiaoLike;
		
		if($biaoLike->exists("biaoid = $biaoid and uid = " . Yii::app()->user->id)){
			$biaoLike = $biaoLike->find("biaoid = $biaoid and uid = " . Yii::app()->user->id);
		}
		$biaoLike->biaoid = $biaoid;
		$biaoLike->uid = Yii::app()->user->id;
		$biaoLike->cpid = $cpid;
		$biaoLike->save();
		$html = $this->widget('BiaoRelation' , array('biaoid' => $biaoid) , true);
		$this->ajaxSucReturn('操作成功!' , $html);
	}

	// 删除感兴趣的标
	public function actionRemBiaoLike(){
		$biaoid = Yii::app()->request->getParam('biaoid');

		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');
		}
		BiaoLike::model()->deleteAll("biaoid = $biaoid and uid = " . Yii::app()->user->id);
		// $html = $this->widget('BiaoRelation' , array('biaoid' => $biaoid) , true);
		$this->ajaxSucReturn('操作成功');
	}

	// 设置关联平台的用户名
	public function actionSetFollowComUser(){
		$p2pname = Yii::app()->request->getParam('p2pname');
		$cpid = Yii::app()->request->getParam('cpid');

		$follow = CompanyFollow::model()->findByAttributes(array('uid'=>Yii::app()->user->id,'cpid'=>$cpid));
		$follow->p2pname = $p2pname;
		if($follow->save()){
			$this->ajaxSucReturn("操作成功!");
		}
		$this->ajaxErrReturn("操作失败!");
	}

	// 注册发送手机短信验证码
	public function actionGetSMSCode(){
		$telephone = Yii::app()->request->getParam('telephone');
		if(! is_numeric($telephone)){
			echo json_encode(array('status'=> false, 'msg'=> '手机号码格式错误'));
			exit();
		}
		$ip = HComm::getIP();
		$condition = "ip = '$ip' and mobile = $telephone";
		// 判断当前手机和ip在规定时间内是否已经发送过
		if(MsmSentLog::model()->exists($condition)){
			$msmSentLog = MsmSentLog::model()->find(array(
					'condition' => $condition,
					'order' => 'dateline desc',
						));
			// 如果90秒内发送过一次，则不发送
			if(time() - $msmSentLog->dateline < Yii::app()->params['sms']['delay']){
				echo json_encode(array('status'=> false, 'msg'=> '90秒内只能发送一次'));
				exit();
			}
		}

		$msmSentLog = new MsmSentLog();
		$code = rand(100000,999999);	
		$msmSentLog->ip = $ip;
		$msmSentLog->mobile = $telephone;
		$msmSentLog->code = $code;
		
		// 记录session
		Yii::app()->session['mobilecode_' . $telephone] = $code;

		//  先发送短信，再插入数据库
		$message = $message = '验证码为：'.$code;
		if(HComm::sendSms($telephone,$message) != 'fail'){
		  	$msmSentLog->save();
			echo json_encode(array('status'=> true, 'msg'=> '发送成功'));
			exit();
		}
		echo json_encode(array('status'=> false, 'msg'=> '发送失败'));
		exit();
	}

	// 检查手机验证码是否正确
	public function actionCheckSms(){
		$sms = Yii::app()->request->getParam('sms');
		$telephone = Yii::app()->request->getParam('telephone');
		if (Yii::app()->session['mobilecode_'.trim($telephone)] == strtolower($sms)){
			echo json_encode('true');
			exit();
		}
		echo json_encode(false);
	}

	// 检查邮箱是否有人注册过
	public function actionCheckEmail(){
		$email = Yii::app()->request->getParam('email');
		if(! Member::model()->exists("email = '$email'")){
			echo json_encode('true');
			exit();
		}
		echo json_encode(false);
	}

	// 检查手机号是否有人注册过
	public function actionCheckPhone(){
		$telephone = Yii::app()->request->getParam('telephone');
		if(! Member::model()->exists("mobile = '$telephone'")){
			echo json_encode('true');
			exit();
		}
		echo json_encode(false);
	}

	// 检测用户忘记密码页面填入的手机号是否存在于数据库
	public function actionCheckPhoneIsExists(){
		$telephone = Yii::app()->request->getParam('telephone');
		if(Member::model()->exists("mobile = $telephone")){
			echo json_encode('true');
			exit();
		}
		echo json_encode(false);
	}

	// 检测p2p平台是否存在， name和siteurl检测
	public function actionP2pIsExists(){
		$name = trim(Yii::app()->request->getParam('name'));
		$siteurl = trim(Yii::app()->request->getParam('siteurl'));
		if( Company::model()->exists("name = '$name'")){
			echo json_encode(false);
			exit();
		}
		if( Company::model()->exists("siteurl = '$siteurl'")){
			echo json_encode(false);
			exit();
		}
		echo json_encode(true);
	}

	// 检查邀请码是否被使用过或存在
	public function actionCheckInviteCode(){
		$inviteCode = trim(Yii::app()->request->getParam('inviteCode'));
		if(InviteCode::model()->exists("class = 1 and status = 0 and code = '$inviteCode'")){
			echo json_encode('true');
			exit();
		}
		echo json_encode(false);
	}

	// 检查用户名是否被注册过
	public function actionCheckUsername(){
		$username = trim(Yii::app()->request->getParam('username'));
		if(! Member::model()->exists("username = '$username'")){
			echo json_encode('true');
			exit();
		}
		echo json_encode(false);
	}

	public function actionDownload(){
		$path = Yii::app()->request->getParam('path');
		$filename = Yii::app()->request->getParam('filename');
		HComm::download($path , $filename);
	}

	// 评论
	public function actionReply(){
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');
		}
		if(!empty($_POST)){
			$commentModel = new Comment();
			$commentModel->toid = (int)Yii::app()->request->getParam('toid');
			$commentModel->type = (int)Yii::app()->request->getParam('type');
			$commentModel->parent_id = 0;
			$commentModel->content = htmlspecialchars(Yii::app()->request->getParam('content'));
			if($commentModel->save()){
				$userUrl = $this->createUrl('home/index',array('uid'=>$commentModel->uid)); 
				$userAvatar = HComm::avatar($commentModel->uid);
				$dateline =  date('Y-m-d H:i:s',$commentModel->dateline);
				$html = <<<EOF
					<li class="comment_{$commentModel->toid} review" comment_id="{$commentModel->cid}">
						<div class="groupL">
							<a target="_blank" href="{$userUrl}"><img src="{$userAvatar}" /></a>
						</div>
						<div class="groupR postC" >
							<h5>
								<cite>
									<a href="javascript:void(0)" class="ding">顶(<span>{$commentModel['likenum']}</span>)</a>
									&nbsp;&nbsp;&nbsp;&nbsp;$dateline
								</cite>
								<a target="_blank" href="{$userUrl}">{$commentModel->username}</a>
							</h5>
							<p>
								{$commentModel->content}
							</p>
						</div>
					</li>
EOF;
				$this->ajaxSucReturn('评论成功' , $html);
			} else {
			$this->ajaxErrReturn('未知错误!');
			}
		}
		$this->ajaxErrReturn('非法操作!');
	}
	// 二级评论
	public function actionSecondReply(){
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');
		}
		if(!empty($_POST)){
			$commentModel = new Comment();
			$commentModel->toid = (int)Yii::app()->request->getParam('toid');
			$commentModel->parent_id = (int)Yii::app()->request->getParam('comment_id');
			$commentModel->content = htmlspecialchars(Yii::app()->request->getParam('content'));
			if($commentModel->save()){
				$html = <<<EOF
					<dt>{$commentModel->username} : {$commentModel->content}</dt>
EOF;
				$this->ajaxSucReturn('回复成功' , $html);
			} else {
				$this->ajaxErrReturn('未知错误!');
			}
		}
		$this->ajaxErrReturn('非法操作!');
	}

	// 顶
	public function actionDing(){
		if(Yii::app()->user->isGuest){
			$this->ajaxErrReturn('needLogin');	
		}
		$comment_id = Yii::app()->request->getParam('comment_id');
		$commentLike = new CommentLike();

		$commentLike->like($comment_id);
		$this->ajaxSucReturn('' , Comment::model()->findByPk($comment_id)->likenum);
	}
}
