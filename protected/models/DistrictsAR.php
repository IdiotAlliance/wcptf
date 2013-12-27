<?php

/**
 * This is the model class for table "districts".
 *
 * The followings are the available columns in table 'districts':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $store_id
 * @property integer $daily_status
 */
class DistrictsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DistrictsAR the static model class
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
		return 'districts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, store_id', 'required'),
			array('store_id, daily_status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, store_id, daily_status', 'safe', 'on'=>'search'),
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
			'description' => 'Description',
			'store_id' => 'Store',
			'daily_status' => 'Daily Status',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('store_id',$this->store_id);
		$criteria->compare('daily_status',$this->daily_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * 根据用户id获取配送片区,包括已删除的地区
	 * @param $userId 用户的id
	 * @deprecated
	 */
	public function getDistrictsByUserId($userId){
		$districts = DistrictsAR::model()->findAll('store_id=:userId', array(':userId'=>$userId));
		return $districts;
	}
	
	/**
	 * 根据用户id获取配送片区,不包括已删除的地区
	 * @param $userId 用户的id
	 * @deprecated
	 */
	public function getUndeletedDistrictsByUserId($userId){
		$districts = DistrictsAR::model()->findAll('store_id=:userId and deleted<>1', 
												array(':userId'=>$userId));
		return $districts;
	}
	
	/**
	 * 
	 */
	public function getUndeletedDistrictsByStoreId($sid){
		return DistrictsAR::model()->findAll('store_id=:sid and deleted <> 1',
											 array(':sid'=>$sid));
	}

	public function getDistrictById($id){
		$district = DistrictsAR::model()->find('id=:id', array(':id'=>$id));
		return $district;
	}
	
	public function deleteDistrictById($id){
		$district = $this->getDistrictById($id);
		if($district){
			$district->deleted = 1;
			$district->update();
		}
	}

	/*
		获取片区名称
	*/
	public function getAreaName($areaId){
		$district =  DistrictsAR::model()->find('id=:areaId', array(':areaId'=>$areaId));
		if(!empty($district)){
			return $district->name;
		}else{
			return "无";
		}
	}
}