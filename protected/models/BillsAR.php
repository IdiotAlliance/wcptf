<?php

/**
 * This is the model class for table "bills".
 *
 * The followings are the available columns in table 'bills':
 * @property string $id
 * @property integer $type
 * @property string $seller_id
 * @property double $bill
 */
class BillsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BillsAR the static model class
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
		return 'bills';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_id', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('bill', 'numerical'),
			array('seller_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, seller_id, bill', 'safe', 'on'=>'search'),
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
			'type' => 'Type',
			'seller_id' => 'Seller',
			'bill' => 'Bill',
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
		$criteria->compare('type',$this->type);
		$criteria->compare('seller_id',$this->seller_id,true);
		$criteria->compare('bill',$this->bill);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getBills($uid, $limit){
		return BillsAR::model()->findAll(array('condition'=>'seller_id=:userId',
											   'params'=>array(':userId'=>$uid),
											   'order'=>'ctime desc',
											   'limit'=>$limit));
	}
}