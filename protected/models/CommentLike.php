<?php

/**
 * This is the model class for table "{{comment_like}}".
 *
 * The followings are the available columns in table '{{comment_like}}':
 * @property integer $id
 * @property integer $cid
 * @property integer $uid
 * @property integer $op
 * @property integer $dateline
 */
class CommentLike extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CommentLike the static model class
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
		return '{{comment_like}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('cid, uid', 'required'),
			array('cid, uid, op, dateline', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cid, uid, op, dateline', 'safe', 'on'=>'search'),
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
			'cid' => 'Cid',
			'uid' => 'Uid',
			'op' => 'Op',
			'dateline' => 'Dateline',
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
		$criteria->compare('cid',$this->cid);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('op',$this->op);
		$criteria->compare('dateline',$this->dateline);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) {
				$this->dateline = time();
			}
		}
		return true;
	}
	protected function afterSave(){
		parent::afterSave();
		if ($this->isNewRecord) {
			if($this->op == 1){
				Comment::model()->updateCounters(array('likenum'=>1) , 'cid = ' . $this->cid);
			} else {
				Comment::model()->updateCounters(array('dislikenum'=>1) , 'cid = ' . $this->cid);
			}
		}
		return true;
	}

	// 顶
	public function like($cid , $do='like'){
		$uid = Yii::app()->user->id;
		$op = $do == 'like' ? 1 : 0;
		if(! $this->exists("cid = $cid and uid = $uid and op = $op")){
			$commentLike = new CommentLike();
			$commentLike->cid = $cid;
			$commentLike->uid = $uid;
			$commentLike->save();
		}
		return true;
	}
}