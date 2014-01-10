<?php

/**
 * This is the model class for table "hot_products".
 *
 * The followings are the available columns in table 'hot_products':
 * @property string $store_id
 * @property string $desc
 * @property string $pic_id
 * @property string $product_id
 * @property string $picurl
 *
 * The followings are the available model relations:
 * @property Pictures $pic
 * @property Users $seller
 * @property Products $product
 */
class HotProductsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return HotProductsAR the static model class
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
		return 'hot_products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('store_id, product_id', 'required'),
			array('store_id, pic_id, product_id', 'length', 'max'=>11),
			array('desc', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('store_id, desc, pic_id, product_id', 'safe', 'on'=>'search'),
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
			'seller' => array(self::BELONGS_TO, 'UsersAR', 'store_id'),
			'product' => array(self::BELONGS_TO, 'ProductsAR', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'store_id' => 'Seller',
			'desc' => 'Desc',
			'pic_id' => 'Pic',
			'product_id' => 'Product',
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

		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('pic_id',$this->pic_id,true);
		$criteria->compare('product_id',$this->product_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * @deprecated
	 */
	public function getHotProductsById($sellerId){
		$hots = HotProductsAR::model()->findAll('store_id=:sellerId', array(':sellerId'=>$sellerId));
		return $hots;
	}

	public function getHotProductsByStoreId($sid){
		return HotProductsAR::model()->findAll('store_id=:sid', array(':sid'=>$sid));
	}
	
	public function deleteHotProductsByUserId($userId){
		HotProductsAR::model()->deleteAll('store_id=:store_id', array(':store_id'=>$userId));
	}
}