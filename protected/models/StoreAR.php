<?php

/**
 * This is the model class for table "store".
 *
 * The followings are the available columns in table 'store':
 * @property string $id
 * @property integer $seller_id
 * @property string $brand_id
 * @property string $name
 * @property string $address
 * @property string $phone
 * @property integer $status
 * @property string $broadcast
 * @property string $stime
 * @property string $etime
 * @property double $start_price
 * @property double $takeaway_fee
 * @property integer $threshold
 * @property double $estimated_time
 * @property integer $deleted
 *
 * The followings are the available model relations:
 * @property Brand $brand
 */
class StoreAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreAR the static model class
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
		return 'store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('status, threshold, deleted', 'numerical', 'integerOnly'=>true),
			array('start_price, takeaway_fee, estimated_time', 'numerical'),
			array('brand_id', 'length', 'max'=>11),
			array('phone', 'length', 'max'=>16),
			array('address, broadcast', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, brand_id, name, address, phone, status, broadcast, stime, etime, start_price, takeaway_fee, threshold, estimated_time, deleted', 'safe', 'on'=>'search'),
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
			'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'brand_id' => 'Brand',
			'name' => 'Name',
			'address' => 'Address',
			'phone' => 'Phone',
			'status' => 'Status',
			'broadcast' => 'Broadcast',
			'stime' => 'Stime',
			'etime' => 'Etime',
			'start_price' => 'Start Price',
			'takeaway_fee' => 'Takeaway Fee',
			'threshold' => 'Threshold',
			'estimated_time' => 'Estimated Time',
			'deleted' => 'Deleted',
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
		$criteria->compare('brand_id',$this->brand_id,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('broadcast',$this->broadcast,true);
		$criteria->compare('stime',$this->stime,true);
		$criteria->compare('etime',$this->etime,true);
		$criteria->compare('start_price',$this->start_price);
		$criteria->compare('takeaway_fee',$this->takeaway_fee);
		$criteria->compare('threshold',$this->threshold);
		$criteria->compare('estimated_time',$this->estimated_time);
		$criteria->compare('deleted',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getStoreByUserId($userId){
		if($userId && $userId >= 0){
			return StoreAR::model()->findAll('seller_id=:userId',
									  array(':userId'=>$userId));
		}
	}

	public static function getUndeletedStoreByUserId($userId){
		if($userId && $userId >= 0){
			return StoreAR::model()->findAll('seller_id=:userId and deleted <> 1',
									  array(':userId'=>$userId));
		}
	}

	public static function nameExsits($userId, $name){
		return count(StoreAR::model()->findAll("seller_id={$userId} AND name='{$name}' AND deleted<>1")) > 0;
	}

}