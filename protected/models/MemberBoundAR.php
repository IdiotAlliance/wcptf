<?php

/**
 * This is the model class for table "member_bound".
 *
 * The followings are the available columns in table 'member_bound':
 * @property integer $id
 * @property string $member_id
 * @property string $store_id
 * @property string $cardno
 * @property integer $credit
 * @property string $phone
 *
 * The followings are the available model relations:
 * @property Members $member
 */
class MemberBoundAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MemberBoundAR the static model class
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
		return 'member_bound';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('member_id, store_id', 'required'),
			array('id, credit', 'numerical', 'integerOnly'=>true),
			array('member_id, store_id', 'length', 'max'=>11),
			array('cardno', 'length', 'max'=>32),
			array('phone', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, member_id, store_id, cardno, credit, phone', 'safe', 'on'=>'search'),
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
			'member' => array(self::BELONGS_TO, 'Members', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'member_id' => 'Member',
			'store_id' => 'Store',
			'cardno' => 'Cardno',
			'credit' => 'Credit',
			'phone' => 'Phone',
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
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('cardno',$this->cardno,true);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('phone',$this->phone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Get bound members by store id
	 */
	public static function getBoundByStoreId($sid){
		$bounds = MemberBoundAR::model()->findAll('store_id=:sid', array(':sid' => $sid));
		return $bounds;
	}

	public static function getBoundByStoreAndMember($sid, $memberId){ 
		return MemberBoundAR::model()->find('store_id=:sid and member_id=:memberId', 
											   array(':sid' => $sid, ':memberId' => $memberId));
	}
}