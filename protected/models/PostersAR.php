<?php

/**
 * This is the model class for table "posters".
 *
 * The followings are the available columns in table 'posters':
 * @property string $id
 * @property string $name
 * @property string $phone
 * @property string $description
 * @property string $seller_id
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
			array('name, seller_id', 'required'),
			array('name, phone', 'length', 'max'=>32),
			array('seller_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, phone, description, seller_id', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'seller_id'),
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
			'seller_id' => 'Seller',
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
		$criteria->compare('seller_id',$this->seller_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	/**
	 * 根据用户id获取邮递员的信息
	 * @param unknown $userId
	 * @return unknown
	 */
	public function getPostersByUserId($userId){
		$posters = PostersAR::model()->findAll('seller_id=:userId', array(':userId'=>$userId));
		return $posters;
	}
	
	public function getPosterById($id){
		$poster = PostersAR::model()->find('id=:id', array(':id'=>$id));
		return $poster;
	}
	
	public function deletePosterById($id){
		PostersAR::model()->delete('id=:id', array(':id'=>$id));
	}

	/*
		查找有效的派送人员
	*/
	public function getWorkPosters($seller_id){
		$posters = PostersAR::model()->findAll('seller_id=:seller_id', array(':seller_id'=>$seller_id));
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