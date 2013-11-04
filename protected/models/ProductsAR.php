<?php

/**
 * This is the model class for table "products".
 *
 * The followings are the available columns in table 'products':
 * @property string $id
 * @property string $seller_id
 * @property string $type_id
 * @property string $pname
 * @property double $price
 * @property integer $credit
 * @property string $description
 * @property string $stime
 * @property string $etime
 * @property integer $status
 * @property integer $instore
 * @property string $richtext
 * @property string $cover
 *
 * The followings are the available model relations:
 * @property OrderItems[] $orderItems
 * @property Pictures $cover0
 * @property ProductType $type
 * @property Users $seller
 */
class ProductsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ProductsAR the static model class
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
		return 'products';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_id, type_id, pname, stime, instore', 'required'),
			array('credit, status, instore', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('seller_id, type_id, cover', 'length', 'max'=>11),
			array('pname', 'length', 'max'=>256),
			array('description, etime, richtext', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, type_id, pname, price, credit, description, stime, etime, status, instore, richtext, cover', 'safe', 'on'=>'search'),
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
			'orderItems' => array(self::HAS_MANY, 'OrderItems', 'product_id'),
			'cover0' => array(self::BELONGS_TO, 'Pictures', 'cover'),
			'type' => array(self::BELONGS_TO, 'ProductType', 'type_id'),
			'seller' => array(self::BELONGS_TO, 'Users', 'seller_id'),
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
			'type_id' => 'Type',
			'pname' => 'Pname',
			'price' => 'Price',
			'credit' => 'Credit',
			'description' => 'Description',
			'stime' => 'Stime',
			'etime' => 'Etime',
			'status' => 'Status',
			'instore' => 'Instore',
			'richtext' => 'Richtext',
			'cover' => 'Cover',
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
		$criteria->compare('type_id',$this->type_id,true);
		$criteria->compare('pname',$this->pname,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('credit',$this->credit);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('stime',$this->stime,true);
		$criteria->compare('etime',$this->etime,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('instore',$this->instore);
		$criteria->compare('richtext',$this->richtext,true);
		$criteria->compare('cover',$this->cover,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}