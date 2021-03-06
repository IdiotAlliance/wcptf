<?php

/**
 * This is the model class for table "store_env".
 *
 * The followings are the available columns in table 'store_env':
 * @property string $id
 * @property string $seller_id
 * @property string $pic_id
 *
 * The followings are the available model relations:
 * @property Pictures $pic
 * @property Users $seller
 */
class StoreEnvAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StoreEnvAR the static model class
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
		return 'store_env';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_id, pic_id', 'required'),
			array('seller_id, pic_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, pic_id', 'safe', 'on'=>'search'),
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
			'pic' => array(self::BELONGS_TO, 'PicturesAR', 'pic_id'),
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
			'seller_id' => 'Seller',
			'pic_id' => 'Pic',
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
		$criteria->compare('seller_id',$this->seller_id,true);
		$criteria->compare('pic_id',$this->pic_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * 根据用户信息获取店内环境的图片id数组
	 * @param unknown $userId
	 */
	public function getStoreEnvByUserId($userId){
		$env = StoreEnvAR::model()->findAll('seller_id=:userId', array('userId'=>$userId));
		return $env;
	}
}