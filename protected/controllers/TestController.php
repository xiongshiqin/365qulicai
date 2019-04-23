<?php
/**
 * 测试点 
 *
 */
class TestController extends Controller
{
	function ActionIndex(){
		echo md5('123456'.md5('sdgf'));exit;
		$user = Member::model()->find('username=?', array($this->username));
		print_r($user);
	}
	
	//头像上传
	public function actionAvatar(){
		$au = new HAvatar();
		//var_dump($au);exit('aaaa');
		if ( $re = $au->processRequest() ) {
			//Member::model()->updateCounters(array('avatarstatus'=>1), 'uid='.$uid);
			//$this->redirect($this->createUrl('test/avatar'));
			exit();
		}

		$urlCameraFlash = $au->renderHtml( Yii::app()->user->id );
		$this->render('avatar', array('urlCameraFlash'=>$urlCameraFlash));
	}
	
	//编辑器使用
	public function actionKindeditor(){
		$this->render('kindeditor');
	}
	
	
	public function actionPhpInfo(){
		phpinfo();
		exit;
	}
	
	public function actionTestError()
	{
		throw new CHttpException(404,'The requested page does not exist.');
		
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function actionColorbox(){
		$this->render('colorbox');
	}
	
	public function actionSms(){
		$mobile = '15767915200';
		$message = '你好，你注册的验证码是: 232342';
		HComm::sendSms($mobile, $message);
		exit('ok');
	}

	//Excel文件生成类
	public function actionexportExcel(){
		//excel文件标题
		$title = array('1','2','3','4');
		//Excel文件内容，二维数组
		$data = array(
						array('a','b','c','d'),
						array('e','f','g','h')
				);
		//excel文件名称
		$fileName = '表格1';

		$newExcel = HComm::exportExcel( $fileName, $title, $data );
		exit;

	}


	//邮件发送类; SMTP 信息需要再配置
	public function actionsendMail(){
		//接受邮件地址
		$sendTo = '317436499@qq.com';

		//邮件标题
		$subject = 'test';

		//邮件内容
		$body = 'test';

		$result = HComm::sendMail( $sendTo, $subject, $body );

		if ( $result == -1 ){ //发送失败返回-1
			$this->redirectMessage('邮件发送失败', Yii::app()->request->urlReferrer);

		}else{
			$this->redirectMessage('邮件发送成功', Yii::app()->request->urlReferrer, 'success');

		}

	}

	public function actionCurl(){
		$result = HCurl::newInstance()->url('www.baidu.com')->get();
		mydebug($result);
	}


	//curl抓取百度百家P2P新闻测试方法
	//time: 2014-12-18
	public function actionNewsSpider( $second=30 ) {

		$page     = empty($_GET['page']) ? 1 : (int)Yii::app()->request->getParam('page');
		$pagesize = empty($_GET['pagesize']) ? 10 : (int)Yii::app()->request->getParam('pagesize');

		$type = empty($_GET['word']) ? 'listarticle&labelid='.$_GET['labelid'] : 'search&word='.$_GET['word'];

		
		$dest_url    = 'http://baijia.baidu.com/?tn='.$type;
		//echo $dest_url;exit;

		//$cURLObj = 
		$result = HCurl::newInstance()->timeout($second)->url($dest_url)->get();		

		header('Content-Type:text/html;charset=utf-8');
		//标题和article的ID
		$pattern_article = '|<h3><a href="(.*)/article/(.*)" target="_blank" mon="(.*)">(.*)</a></h3>\s*<p class="feeds-item-text">(.*)\s?<a href="(.*)\s?" target="_blank" class="feeds-item-more" mon="(.*)</a></p>|i';
		preg_match_all($pattern_article, $result['data'], $matches);
		$articleid    = $matches[2];  	//新闻唯一ID
		$news_title   = $matches[4];		//新闻标题
		$news_summary = $matches[5];	//新闻摘要
		$news_url     = $matches[6];		//新闻链接
		//mydebug($matches);
		//var_dump($articleid);
		//var_dump($news_title);
		//var_dump($news_summary);
		//var_dump($news_url);
		//exit;

		//图片地址
		$pattern_pic = '|<p class="feeds-item-pic"><a href="(.*)" target="_blank" mon="(.*)"><img src="(.*)"/></a></p>|i';
		preg_match_all($pattern_pic, $result['data'], $matches);
		$news_pic = $matches[3];
		array_pop($news_pic); //页面中最后一个不是图片路径
		//var_dump($matches[1]);
		//var_dump($news_pic);
		//exit;

		//是否有图片
		$pattern_existpic = '|<div class="feeds-item-detail (.*)">|i';
		preg_match_all($pattern_existpic, $result['data'], $matches);
		$news_existpic = $matches['1'];
		array_pop($news_existpic);
		//array_pop($news_existpic);
		//var_dump($articleid);
		//var_dump($news_existpic);
		//exit;

		//mydebug($news_existpic);
		//按照新闻列表的长度，重新组合新闻列表的图片
		$news_pic1 = array();
		$kb = 0; //定义访问图片数组的键值静态变量
		foreach ($news_existpic as $key => $value) {		
			if ($value != '') {				
				$news_pic1[$key] = $news_pic[$kb];
				$kb++;
			}else{
				$news_pic1[$key] = '';
			}
		}

		//var_dump($news_pic1);
		//exit;

		//组装news新闻数组
		$news = array();
		//$news_arr = $news_id;
		foreach ($news_pic1 as $k1 => $v1) {			
			foreach ($articleid as $k2 => $v2) {
				if ($k2 == $k1) {
					$news[$k2]['articleid']  = $v2;
					//echo $v1;exit;
					if ($v1 != '') {

						$ch = curl_init();
					    $timeout = 10;
					    curl_setopt ($ch, CURLOPT_URL, $v1);
					    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
					    curl_setopt ($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en; rv:1.9.2) Gecko/20100115 Firefox/3.6 GTBDFff GTB7.0');
					    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
					    $file = curl_exec($ch);
					    curl_close($ch);				    

						$file_path = IMG_PATH.'newsspider/';
						if (!is_dir($file_path)) {
							mkdir($file_path,0777,true);
						}

						$filename = uniqid().'.'.substr($v1, -3, 3);
						$fp = @fopen($file_path.$filename,'w');
						@fwrite($fp, $file);
						fclose($fp);
						$news[$k2]['pic'] = '/data/attached/image/newsspider/'.$filename;						
						//echo $news[$k2]['pic'];exit;
					}else{
						$news[$k2]['pic'] = '';
					}
					$news[$k2]['title'] = $news_title[$k2];					
					$news[$k2]['summary'] = $news_summary[$k2];					
					$news[$k2]['url'] = $news_url[$k2];					
				}
			}
		}
		
		unset($articleid);
		unset($news_title);
		unset($news_summary);
		unset($news_pic);
		unset($news_pic1);
		unset($news_existpic);

		//var_dump($news);
		//exit;

		//拿到新闻数组的新闻链接，进一步抓取新闻详细内容
		foreach ($news_url as $key => $url) {
			$result1 = file_get_contents($url);
			//mydebug($result1);
			$pattern_detail = '|<p class="text">(.*)\s*</p>|';
			preg_match_all($pattern_detail, $result1, $matches1);
			$detail = $matches1[1];
			$content = '';
			foreach ($detail as $key1 => $value1) {
				$content .= '<p>'.$value1.'</p>';
			}
			$news_content[$key] =  $content;
		}

		//var_dump($news_content);
		//查询到已经存在的pid（百家的articleID）
		$articleids = News::model()->findAll(array(
				'select'   =>"articleid",
				'condition'=>"pname='baijia'",
				//'order'	   => "dateline ASC"		
				));
		$exist_ids = array();
		foreach ($articleids as $key => $value){
			$exist_ids[] = $value->attributes['articleid'];
		}
		//var_dump($exist_ids);
		//exit;
		//再一次组装新闻数组
		foreach ($news as $key => &$value) {
			if (!in_array($value['articleid'], $exist_ids)) {

				$news[$key]['exist'] = 0;
				foreach ($news_content as $k => $v) {
					if ($key == $k) {
						$news[$key]['content'] = $v;
					}
				}				
			}else{
				$news[$key]['exist'] = 1;
			}
		}

		//var_dump($news);
		//exit;
		
		//var_dump($exist_ids);exit;
		//将新闻数组循环插入到数据库中
		$new_insert = 0;
		foreach ($news as $k1 => $v1) {
			//去重处理
			if ($v1['exist'] == 0 ) { 
				$model            = new News();
				$model->articleid = $v1['articleid'];				
				$model->pic       = $v1['pic'];
				$model->title     = $v1['title'];
				$model->summary   = $v1['summary'];
				$model->content   = $v1['content'];
				$model->pid       = 0;
				$model->uid       = 1;			
				$model->classid   = 201;
				$model->status    = 1;
				$model->username  = '百度百家';
				$model->pname     = 'baijia';
				//var_dump($model);exit;
				if ($model->save()){
					$new_insert++;
				}
			}
		}
		echo "新增".$new_insert."条行业新闻";
	}

	public function actionSinaurl(){
		$url = 'http://www.licaipi.com/index.php?r=news/view&id=348';
		echo HComm::sinaurl($url);
	}

	public function actionTest(){
		$a = 5;
		$b = 10;
		swap($a , $b);
		print($a . '---' . $b);
	}	
}
function swap($a , $b){ //php只有引用，没有指针，故无法使用改变内存地址方式交换数值
	$p;
	$p = $a;
	$a = $b;
	$b = $p;
}