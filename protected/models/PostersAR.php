<?php

/**
 * This is the model class for table "posters".
 *
 * The followings are the available columns in table 'posters':
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $description
 * @property string $store_id
 *
 * The followings are the available model relations:
 * @property Users $seller
 */
class PostersAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PostersAR the static model class
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
		return 'posters';
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
			array('name, phone', 'length', 'max'=>32),
			array('store_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, phone, description, store_id', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'store_id'),
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
			'phone' => 'Phone',
			'description' => 'Description',
			'store_id' => 'Seller',
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
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('store_id',$this->store_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * 根据用户id获取邮递员的信息,包括已删除的用户
	 * @param unknown $userId
	 * @return unknown
	 */
	public function getPostersByUserId($userId){
		$posters = PostersAR::model()->findAll('store_id=:userId', array(':userId'=>$userId));
		return $posters;
	}
	
	/**
	 * 根据用户的id获取未删除的送货员id
	 * @param unknown $userId
	 * @deprecated
	 */
	public function getUndeletedPostersByUserId($userId){
		$posters = PostersAR::model()->findAll('store_id=:userId and deleted<>1', 
									array(':userId'=>$userId));
		return $posters;
	}

	public function getUndeletedPostersByStoreId($sid){
		return PostersAR::model()->findAll('store_id=:sid and deleted <> 1',
										   array(':sid'=>$sid));
	}
	
	public function getPosterById($id){
		$poster = PostersAR::model()->find('id=:id', array(':id'=>$id));
		return $poster;
	}
	
	public function deletePosterById($id){
		$poster = $this->getPosterById($id);
		if($poster){
			$poster->deleted = 1;
			$poster->update();
		}
	}

	/*
		查找有效的派送人员
	*/
	public function getWorkPosters($store_id){
		$posters = PostersAR::model()->findAll('store_id=:store_id and deleted=:deleted and daily_status=:dailyStatus', 
			array(':store_id'=>$store_id, ':deleted'=>0, ':dailyStatus'=>0));
		return $posters;
	}

	/*
		获取派送人员
	*/
	public function getPoster($posterId){
		$poster = PostersAR::model()->find('id=:posterId', array(':posterId'=>$posterId));
		return $poster;
	}
}