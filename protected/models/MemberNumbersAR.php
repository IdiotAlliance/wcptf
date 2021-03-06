<?php

/**
 * This is the model class for table "member_numbers".
 *
 * The followings are the available columns in table 'member_numbers':
 * @property string $number
 * @property string $vericode
 * @property string $expire
 */
class MemberNumbersAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberNumbersAR the static model class
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
		return 'member_numbers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('number', 'required'),
			array('number', 'length', 'max'=>16),
			array('vericode', 'length', 'max'=>8),
			array('expire', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('number, vericode, expire', 'safe', 'on'=>'search'),
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
			'number' => 'Number',
			'vericode' => 'Vericode',
			'expire' => 'Expire',
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

		$criteria->compare('number',$this->number,true);
		$criteria->compare('vericode',$this->vericode,true);
		$criteria->compare('expire',$this->expire,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 
	 */
	public static function getVerifiedNumbersByStoreId($sid){
		$requests = MemberNumbersAR::model()->findAll('store_id=:sid and verified=1', array(':sid'=>$sid));
		return $requests;
	}

	public static function getRequest($sid, $memberId){
		return MemberNumbersAR::model()->find('store_id=:sid and member_id=:memberId and verified = 1', 
											  array(':sid'=>$sid, ':memberId'=>$memberId));
	}

	/**
	 * Confirm the request of a member
	 */
	public static function confirmRequest($sid, $memberId){
		MemberNumbersAR::model()->delete('store_id=:sid and member_id=:memberId', 
										 array(':sid'=>$sid, ':memberId'=>$memberId));
	}
}