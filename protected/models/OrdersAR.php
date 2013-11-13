<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property string $id
 * @property string $seller_id
 * @property string $member_id
 * @property string $ctime
 * @property integer $status
 * @property string $address
 * @property string $description
 * @property string $duetime
 * @property double $total
 * @property integer $type
 * @property string $phone
 * @property string $order_no
 * @property integer $poster_id
 *
 * The followings are the available model relations:
 * @property OrderItems[] $orderItems
 * @property Users $member
 * @property Users $seller
 */
class OrdersAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrdersAR the static model class
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
		return 'orders';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('seller_id, member_id, ctime, status, total, phone, order_no, poster_id', 'required'),
			array('status, type, poster_id', 'numerical', 'integerOnly'=>true),
			array('total', 'numerical'),
			array('seller_id, member_id', 'length', 'max'=>11),
			array('phone, order_no', 'length', 'max'=>32),
			array('address, description, duetime', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, seller_id, member_id, ctime, status, address, description, duetime, total, type, phone, order_no, poster_id', 'safe', 'on'=>'search'),
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
			'orderItems' => array(self::HAS_MANY, 'OrderItemsAR', 'order_id'),
			'member' => array(self::BELONGS_TO, 'UsersAR', 'member_id'),
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
			'member_id' => 'Member',
			'ctime' => 'Ctime',
			'status' => 'Status',
			'address' => 'Address',
			'description' => 'Description',
			'duetime' => 'Duetime',
			'total' => 'Total',
			'type' => 'Type',
			'phone' => 'Phone',
			'order_no' => 'Order No',
			'poster_id' => 'Poster',
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
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('duetime',$this->duetime,true);
		$criteria->compare('total',$this->total);
		$criteria->compare('type',$this->type);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('order_no',$this->order_no,true);
		$criteria->compare('poster_id',$this->poster_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}