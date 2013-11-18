<?php

/**
 * This is the model class for table "order_items".
 *
 * The followings are the available columns in table 'order_items':
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property integer $number
 * @property double $price
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Products $product
 * @property Orders $order
 */
class OrderItemsAR extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderItemsAR the static model class
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
		return 'order_items';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('order_id, product_id, number, price, status', 'required'),
			array('number, status', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('order_id, product_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_id, product_id, number, price, status', 'safe', 'on'=>'search'),
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
			'product' => array(self::BELONGS_TO, 'ProductsAR', 'product_id'),
			'order' => array(self::BELONGS_TO, 'OrdersAR', 'order_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_id' => 'Order',
			'product_id' => 'Product',
			'number' => 'Number',
			'price' => 'Price',
			'status' => 'Status',
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
		$criteria->compare('order_id',$this->order_id,true);
		$criteria->compare('product_id',$this->product_id,true);
		$criteria->compare('number',$this->number);
		$criteria->compare('price',$this->price);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
		获取特定订单的子项
	*/
	public function getItems($order_id){
		$orderItems = OrderItemsAR::model()->findAll('order_id=:order_id', array(':order_id'=>$order_id));
		OrderItemsAR::model()->changeItemsToView($orderItems);
		return $orderItems;
	}

	/*
		获取特定for-AR订单的子项
	*/
	public function getTrueItems($order_id){
		$orderItems = OrderItemsAR::model()->findAll('order_id=:order_id', array(':order_id'=>$order_id));
		return $orderItems;
	}

	public function generateItems($order_id){
		$items = OrderItemsAR::model()->getTrueItems($order_id);
		$result = "";
		foreach ($items as $item) {
			$product = ProductsAR::model()->getProductById($item->product_id);
			if(!empty($product)){
				$pName = ProductsAR::model()->getProductById($item->product_id)->pname;
				$result = $result.$pName.'*'.$item->number." ";
			}
		}
		return $result;
	}

	/*
		删除特定订单的子项
	*/
	public function deleteItems($order_id){
		$orderItems = OrderItemsAR::model()->findAll('order_id=:order_id', array(':order_id'=>$order_id));
		foreach ($orderItems as $item) {
			$item->delete();
		}
	}
	public function changeItemsToView($items){
		foreach ($items as $item) {
			OrderItemsAR::model()->changeItemToView($item);
		}
	}

	public function changeItemToView($item){
		 $product = ProductsAR::model()->getProductById($item->product_id);
		 if(!empty($product)){
		 	$item->product_id = $product->pname;
			$typeId = $product->type_id;
			$typeName = ProductTypeAR::model()->getProductTypeById($typeId)->type_name;
			$item->product_id = $item->product_id.":".$typeName;
		}	
	}
	//获取item type
	public function getItemsType($itemId){
		$item = OrderItemsAR::model()->findByPk($itemId);
		$product = ProductsAR::model()->getProductById($item->product_id);
		if(!empty($product)){
			$typeId = $product->type_id;
			$typeName = ProductTypeAR::model()->getProductTypeById($typeId)->type_name;
			return $typeName;
		}
		return " ";
	}

	/*
		新建订单子项
	*/
	public function createItem($sellerId, $orderId, $productId, $num){
		$product = ProductsAR::model()->getProductByIdSeller($productId, $sellerId);
		if(!empty($product)){
			if($product->instore>=$num){
				$product = ProductsAR::model()->buyProduct($productId, $sellerId, $num);
				if($product->instore>=0){
					//成功购买
					$item = new OrderItemsAR;
					$item->order_id = $orderId;
					$item->product_id = $productId;
					$item->number = $num;
					$item->price = $product->price * $num;
					$item->status = 0;
					$item->save();
					return "ok";
				}else{
					//防止死锁，恢复
					$product = ProductsAR::model()->buyProduct($sellerId, $productId, -$num);
					return "number is not enough";
				}
			}else{
				return $product->id." number is not enough";
			}
		}else{
			return "product id is out";
		}
		
	}
}