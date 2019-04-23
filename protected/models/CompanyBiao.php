<?php

/**
 * This is the model class for table "{{company_biao}}".
 *
 * The followings are the available columns in table '{{company_biao}}':
 * @property string $id
 * @property integer $cpid
 * @property string $cpname
 * @property string $title
 * @property double $money
 * @property double $profityear
 * @property integer $timelimit
 * @property double $interestrate
 * @property string $award
 * @property integer $repaymenttype
 * @property integer $itemtype
 * @property string $datelinepublish
 * @property integer $uid
 * @property integer $viewnum
 * @property integer $order
 * @property string $dateline
 */
class CompanyBiao extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CompanyBiao the static model class
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
		return '{{company_biao}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, money, profityear, timelimit, interestrate,itemtype, datelinepublish,repaymenttype', 'required'),
			// array('cpid, timelimit, repaymenttype, itemtype, uid, viewnum, order', 'numerical', 'integerOnly'=>true),
			// array('money, profityear, interestrate', 'numerical'),
			// array('cpname, award, datelinepublish, dateline', 'length', 'max'=>10),
			// array('title', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, cpid, cpname, title, money, profityear, timelimit, interestrate, award, repaymenttype, itemtype, datelinepublish, uid, viewnum, order, dateline', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO ,'Company','cpid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cpid' => 'Cpid',
			'cpname' => 'Cpname',
			'title' => 'Title',
			'money' => 'Money',
			'profityear' => 'Profityear',
			'timelimit' => 'Timelimit',
			'interestrate' => 'Interestrate',
			'award' => 'Award',
			'repaymenttype' => 'Repaymenttype',
			'itemtype' => 'Itemtype',
			'datelinepublish' => 'Datelinepublish',
			'uid' => 'Uid',
			'viewnum' => 'Viewnum',
			'order' => 'Order',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('cpid',$this->cpid);
		$criteria->compare('cpname',$this->cpname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('profityear',$this->profityear);
		$criteria->compare('timelimit',$this->timelimit);
		$criteria->compare('interestrate',$this->interestrate);
		$criteria->compare('award',$this->award,true);
		$criteria->compare('repaymenttype',$this->repaymenttype);
		$criteria->compare('itemtype',$this->itemtype);
		$criteria->compare('datelinepublish',$this->datelinepublish,true);
		$criteria->compare('uid',$this->uid);
		$criteria->compare('viewnum',$this->viewnum);
		$criteria->compare('order',$this->order);
		$criteria->compare('dateline',$this->dateline,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	protected function beforeSave(){
		if (parent::beforeSave()) {
			if ($this->isNewRecord) { 
				$this->cpname = Company::model()->findByPk($this->cpid)->name;
				$this->uid = Yii::app()->user->id;
				$this->timelimit = $this->timelimit ? $this->timelimit : 1; // 周期默认为1
				$this->dateline = time();
			}
		}
		return true;
	}
}