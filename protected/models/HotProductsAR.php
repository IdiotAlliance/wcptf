<?php

/**
 * This is the model class for table "hot_products".
 *
 * The followings are the available columns in table 'hot_products':
 * @property string $seller_id
 * @property string $desc
 * @property string $pic_id
 * @property string $pic_url
 * @property string $product_id
 *
 * The followings are the available model relations:
 * @property ProductType $product
 * @property Users $seller
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
			array('seller_id, desc, pic_id, pic_url, product_id', 'required'),
			array('seller_id, pic_id, product_id', 'length', 'max'=>11),
			array('desc, pic_url', 'length', 'max'=>128),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('seller_id, desc, pic_id, pic_url, product_id', 'safe', 'on'=>'search'),

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
			'product' => array(self::BELONGS_TO, 'ProductsAR', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'seller_id' => 'Seller',
			'desc' => 'Desc',
			'pic_id' => 'Pic',
			'pic_url' => 'Pic Url',
			'product_id' => 'Product',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
<<<<<<< .merge_file_H8R342
<<<<<<< .merge_file_Iu8QTw
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.


		$criteria=new CDbCriteria;

		$criteria->compare('seller_id',$this->seller_id,true);
		$criteria->compare('desc',$this->desc,true);
		$criteria->compare('pic_id',$this->pic_id,true);
		$criteria->compare('pic_url',$this->pic_url,true);
		$criteria->compare('product_id',$this->product_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function getHotProductsById($userId){
		$hots = HotProductsAR::model()->findAll('seller_id=:userId', array(':userId'=>$userId));
		return $hots;
	}
}
