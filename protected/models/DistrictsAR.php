<?php

/**
 * This is the model class for table "districts".
 *
 * The followings are the available columns in table 'districts':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $seller_id
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
			array('name, seller_id', 'required'),
			array('seller_id, daily_status', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, description, seller_id, daily_status', 'safe', 'on'=>'search'),
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
			'seller_id' => 'Seller',
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
		$criteria->compare('seller_id',$this->seller_id);
		$criteria->compare('daily_status',$this->daily_status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 根据用户id获取配送片区
	 * @param $userId 用户的id
	 */
	public function getDistrictsByUserId($userId){
		$districts = DistrictsAR::model()->findAll('seller_id=:userId', array(':userId'=>$userId));
		return $districts;
	}
	
	public function getDistrictById($id){
		$district = DistrictsAR::model()->find('id=:id', array(':id'=>$id));
		return $district;
	}
	
	public function deleteDistrictById($id){
		DistrictsAR::model()->deleteByPK($id);
	}
}