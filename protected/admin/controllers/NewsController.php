<?php
/*
*后台新闻审核管理
*/
class NewsController extends Controller{
	public function filters(){
		return array(
			'accessControl',
			);
	}
	
	public function accessRules(){
		return array(
		  	  array('deny', 
			            'users'=>array('?'),  
			        ),  
		);
	}
	public function actionIndex(){     //会员列表显示
		// 没有通过审核的新闻
		$newsModel=new News();
		$cri = new CDbCriteria();   //查询所有记录
		$cri->condition = " pid = 0 and classid != '301'";
		$total = $newsModel->count($cri);   //总条数
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$cri->order = 'newsid desc';
		$pager->applyLimit($cri);
		$news=$newsModel->findAll($cri );  //查询总数
		$data=array(
			'news'=>$news,
			'pages'	=> $pager,
		);
		$this->render('index',$data);
	}

	// 新闻审核
	public function actionCheck(){     
		// 没有通过审核的新闻
		$newsModel=new News();
		$cri = new CDbCriteria();   //查询所有记录
		$cri->condition = " pid = 0 and classid != '301' and status = 0";
		$total = $newsModel->count($cri);   //总条数
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$pager->applyLimit($cri);
		$news=$newsModel->findAll($cri );  //查询总数
		$data=array(
			'news'=>$news,
			'pages'	=> $pager,
		);
		$this->render('check',$data);
	}

	/* 编辑会员 */
	public function actionEdit(){
		$newsid = Yii::app()->request->getParam('newsid');
		$news = News::model()->findByPk($newsid);

		if(!empty($_POST)){    /* post提交 */
			$status = $_POST['status'];
			$news->status = $_POST['status'];
			$news->title = trim($_POST['title']);
			$news->pic = trim($_POST['pic']);
			$news->summary = trim($_POST['summary']);
			$news->content = ($_POST['content']);
			$news->save();
			$this->redirect(array('/news/index'));
		}
		$this->render('edit',array('news'=>$news));
	}

	// 后台新闻列表
	public function actionAdminNews(){
		$newsModel=new News();
		$cri = new CDbCriteria();   //查询所有记录
		$cri->condition = "classid = '301'";
		$total = $newsModel->count($cri);   //总条数
		$pager = new CPagination($total);  //实例化分页类
		$pager->pageSize = 10;   //设置每页显示条数
		$pager->applyLimit($cri);
		$news=$newsModel->findAll($cri );  //查询总数
		$data=array(
			'news'=>$news,
			'pages'	=> $pager,
		);
		$this->render('adminNews',$data);
	}

	// 添加后台新闻
	public function actionAddAdminNews(){
		$newsid = Yii::app()->request->getParam('newsid');
		$news = new News();
		if($newsid) {
			$news = News::model()->findByPk($newsid);
		}

		if(!empty($_POST)){    /* post提交 */
			$newsid = $_POST['newsid'];
			$news->title = $_POST['title'];
			$news->classid = '301';
			$news->content = ($_POST['content']);
			$news->order = $_POST['order'];
			$news->uid = 1;
			$news->username = 'admin';
			$news->status = 1;
			$news->save();
			$this->redirect(array('/news/adminNews'));
		}
		$this->render('addAdminNews',array('news'=>$news));
	}
}