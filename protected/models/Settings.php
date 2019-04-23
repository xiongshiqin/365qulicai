<?php

/**
 * This is the model class for table "{{settings}}".
 *
 * The followings are the available columns in table '{{settings}}':
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Settings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{settings}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, value', 'required'),
			array('name', 'length', 'max'=>30),
			array('value', 'length', 'max'=>300),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, value', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'value' => 'Value',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('value',$this->value,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	// 设置参数 缓存
	public function set($name , $value){
		// $settings = Yii::app()->cache->get('Settings');
		// $settings[$name] = $value;
		// $value  = serialize($value); // 序列化值
		// Yii::app()->cache->set('settings' , $settings);

		// 如果存在这个参数，则修改，否则插入
		if(isset(Yii::app()->params['Settings'][$name])){
			$this->update(array('value'=>$value) , "name = " . $name);
		} else {
			$settings = new Settings();
			$settings->name = $name;
			$settings->value = $value;
			$settings->save();
		}
	}

	// 读取参数 缓存
	public function get($name){
		// $settings = Yii::app()->cache->get('Settings');
		// if(isset($settings[$name])){
		// 	return $settings[$name];
		// } else {
			return $this->find("name = " . $name)->value;
		// }
	}

	// 删除参数 缓存
	public function del($name){
		// $settings = Yii::app()->cache->get('Settings');
		// unset($settings[$name]);
		// Yii::app()->cache->set('settings' , $settings);

		$this->delete("name ==  $name");
	}

	//得到所有配置信息 缓存
	public function getAll(){
		// $settings = Yii::app()->cache->get('Settings');
		// if($settings){
		// 	return $settings;
		// } else {
			$res = $this->findAll();
			$settings = array();
			foreach($res as $val){
				$settings[$val->name] = unserialize($val->value);
			}
		// 	Yii::app()->cache->set('Settings' , $settings);
		// }
		return $settings;
	} 

}