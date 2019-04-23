<?php
/**
 * 弹窗结构加载
 * 如果定义当前需要访问的方法，则执行相应方法，否则直接输出与方法名同名的模版内容
 * @author porter 
 * 2014-9-24
 */
;
class AjaxTplController  extends Controller{
	// 如果模版需要有逻辑操作  可以定义同名的方法
	public function actionLogin(){
		$html =  $this->renderpartial('login','',true); 
		$this->ajaxSucReturn('',$html);
	}

	// 如访问不存在的方法，则会执行此方法
	public function missingAction($actionID){
		$html =  $this->renderpartial($actionID,'',true); // 当renderpartial第三个参数为true时，直接返回模版内容结构，而不是渲染
		$this->ajaxSucReturn('',$html);
	}

	public function actionFollowCom(){
		$cpid = Yii::app()->request->getParam('cpid');
		$company = Company::model()->findByPk($cpid);
		$companyApi = CompanyApi::model()->findByPk($cpid);
		$p2pname = array();
		if($companyApi && $companyApi->relate_api){
			// 获取key和api
			// api参数 phone ：要查询的手机号 sign：由手机号和api中的key组成的Md5加密字符串 源api编码为utf-8
			$apiArr = explode('?key=' , $companyApi->relate_api);
			$key = isset($apiArr[1]) ? $apiArr[1] : '';
			$phone =  Member::model()->findByPk(Yii::app()->user->id)->mobile;
			$sign = md5($phone . $key);
			$url = $apiArr[0]  . "?phone=$phone&sign=$sign";
			
			$curlResult = HCurl::newInstance()->url($url)->get();
			$result = json_decode($curlResult['data'] , true);
			if(isset($result['status']) && $result['status'] == true){
				$p2pname = $result['username'];
				if(!is_array($p2pname)){
					$p2pname = array($p2pname);
				}
			}
		}
		$html = $this->renderpartial('followCom' , array('company' => $company , 'p2pname'=>$p2pname) , true);
		$this->ajaxSucReturn('' , $html);
	}
}
