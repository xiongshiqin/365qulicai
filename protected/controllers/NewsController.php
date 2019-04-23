<?php
/**
* 优惠活动
*
*/
class NewsController  extends Controller
{
	public function actions(){
	}

	public function filters(){ 
		return array(
			'accessControl',
		);
	}

	public function accessRules(){
		return array(
			// array('allow',
			// 'actions'=>array(),
			// ),
			
			array('deny',
			'users'=>array('?'),
			'actions' => array('newsAdd'),
			),
		);
	}

	// 发表新闻
	public function actionNewsAdd(){
		if(!empty($_POST)){
			$news = new News();
			$news->classid = $_POST['classid'];
			$news->title = trim($_POST['title']);
			$news->pic = $_POST['pic'];
			$news->summary = htmlspecialchars(trim($_POST['summary']));
			$news->content = (trim($_POST['content'])); // 文本编辑器 可不要htmlspecialchars
			if($news->save()){
				$this->redirectMessage("发表成功，请等待后台审核...." , $this->createUrl('/news/newsList') ,  'success' , 3);
			}
		}
		$this->render('newsAdd');
	}

	// 新闻列表
	public function actionNewsList(){
		$type = Yii::app()->request->getParam('type');
		$render = 'newsList'; // 公司新闻和行业新闻采用不同的view
		if(! $type){
			//如果没有设置type,type默认为分类配置的第一个Key
			$cate = Yii::app()->params['News']['category'][2];
			$type = current($cate);
		}
		$criteria = new CDbCriteria();
		$rows=Yii::app()->params['postnum'];
		if(in_array($type , array('all' , 'my'))){ // 如果type为公司新闻,
			$render = 'comNews';
			if($type == 'all'){
				$criteria->condition = "pid != 0 and status = 1";
			} else {
				//我关注的公司
				if(Yii::app()->user->isGuest){
					$this->redirect(array('/Index/login'));
				}
				$cfollows = CompanyFollow::model()->findAll("uid = " . Yii::app()->user->id);
				$cpids = array(-1);
				// 转成模板中遍历的格式
				foreach($cfollows as $v){
					$cpids[] = $v->cpid;
				}
				$cpids = implode(',' , $cpids);		
				$criteria->condition = "pid in ($cpids) and status = 1";
			}
		} else {
			$cate = Yii::app()->params['News']['category'][2];
			$cate = array_flip($cate);
			$type = $cate[$type];
			$criteria->condition = "classid = $type and status = 1";
		}
		$count = count(News::model()->findAll($criteria)); 

		$pager = new CPagination($count); 
		$pager->pageSize = $rows;             
		$pager->applyLimit($criteria); 

		$criteria->order = 't.dateline desc';

		$news = News::model()->findAll($criteria);

		$this->pageTitle = 'P2P网贷新闻_提供P2P网贷行业相关资讯_理财派';

		$this->render($render,array(
				'news'=>$news,
				'pages'=>$pager,
				'type' => $type,
				));
	}

	// 新闻详情
	public function actionView(){
		$newsid = Yii::app()->request->getParam('id');
		$news = News::model()->findByPk($newsid);

		if($expandCpid = Yii::app()->request->getParam('cpid' , 0)){ // 是否为推广新闻连接进来的
			$cookie = new CHttpCookie('expandCpid' , $expandCpid);
			$cookie->expire = time() + 60*30;  //有限期30分钟
			Yii::app()->request->cookies['expandCpid'] = $cookie;
		}

		// 访问次数+1
		$cookies = Yii::app()->request->getCookies();
		if (! isset($cookies['view'.$news->newsid])) {
			$news->viewnum = $news->viewnum + 1;
			$news->save();	
			
			$cookie = new CHttpCookie('view'.$news->newsid, 1);
			$cookie->expire = time()+60*5;  //5分钟增加浏览次数1次
			Yii::app()->request->cookies['view'.$news->newsid] = $cookie;
		}
		
	
		if($news->pid){
			$this->pageTitle = $news->title . '_' . $news->pname . '_P2P新闻_网贷资讯_理财派';
		} else {
			$this->pageTitle = $news->title . '_P2P新闻_网贷资讯_理财派';
		}
		
		$this->render("view" , array(
					'news'=>$news,
					));
	}
}