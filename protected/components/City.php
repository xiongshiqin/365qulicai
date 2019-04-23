<?php
/**
 * 省市联动
  * @author porter 
 */
Yii::import('zii.widgets.CPortlet');

class City extends CPortlet
{
	public $model;
	public $provinceidname = 'resideprovinceid'; // 默认省份字段名
	public $cityidname = 'cityid'; // 默认城市字段名
	public $curPro; // 当前model省份id
	public $curCity; //当前model城市id
	public $option = array(
		'resideprovinceid' => 110000 , // 北京
		'cityid' => 110100 , // 市辖区
		);

	public function init()
	{
		$model = $this->model;
		$pro = $this->provinceidname;
		$city = $this->cityidname;

		$this->curPro = isset($model->$pro) ? $model->$pro : $this->option['resideprovinceid'];
		$this->curCity = isset($model->$city) ? $model->$city : $this->option['cityid'];
		parent::init();
	}	

	protected function renderContent()
	{
		$this->render('city');
	}
}