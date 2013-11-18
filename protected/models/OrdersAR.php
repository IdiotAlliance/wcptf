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
			array('seller_id, member_id, ctime, status, total, phone, poster_id', 'required'),
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
			'area_id' => "area",
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
		$criteria->compare('area_id',$this->area_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/*
		设置派送人员
	*/
	public function setPoster($orderId, $posterId){
		$order = OrdersAR::model()->find('id=:orderId', array(':orderId'=>$orderId));
		$order->poster_id = $posterId;
		$order->save();
	}
	/*
		获取商家ID
	*/
	public function getUserId($orderId){
		$order = OrdersAR::model()->find('id=:orderId', array(':orderId'=>$orderId));
		return $order->seller_id;
	}

	/*
		获取未派送的订单地点过滤
	*/
	public function filterNotSend($userId, $date, $place){
		$orders = OrdersAR::model()->findAll(array('condition'=>'seller_id=:userId and status=:status1', 
			'params'=>array(':userId'=>$userId, ':status1'=>0), 'order'=>'ctime DESC',));
		$orders = OrdersAR::model()->filterDate($orders, $date);
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}
	/*
		获取已派送的订单
	*/
	public function filterSended($userId, $date, $place){
		$orders = OrdersAR::model()->findAll(array('condition'=>'seller_id=:userId and status=:status1', 
			'params'=>array(':userId'=>$userId, ':status1'=>1,), 'order'=>'ctime DESC',));
		$orders = OrdersAR::model()->filterDate($orders, $date);
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}
	/*
		获取已取消的订单
	*/
	public function filterCancel($userId, $date, $place){
		$orders = OrdersAR::model()->findAll(array('condition'=>'seller_id=:userId and status=:status1', 
			'params'=>array(':userId'=>$userId, ':status1'=>3), 'order'=>'ctime DESC',));
		$orders = OrdersAR::model()->filterDate($orders, $date);
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}

	public function filterDate($orders, $date){
		$newOrder = array();
		foreach ($orders as $order) {
			if(OrdersAR::model()->DateDiff($order->ctime, $date, 'd')<=1){
				array_push($newOrder, $order);
			}
		}
		return $newOrder;
	}

	public function DateDiff($date1, $date2, $unit = "") { //时间比较函数，返回两个日期相差几秒、几分钟、几小时或几天
	    switch ($unit) {
	        case 's':
	            $dividend = 1;
	            break;
	        case 'i':
	            $dividend = 60; //oSPHP.COM.CN
	            break;
	        case 'h':
	            $dividend = 3600;
	            break;
	        case 'd':
	            $dividend = 86400;
	            break; //开源OSPhP.COM.CN
	        default:
	            $dividend = 86400;
	    }
	    $time1 = strtotime($date1);
	    $time2 = strtotime($date2);
	    if ($time1 && $time2)
	        return (float)($time1 - $time2) / $dividend;
	    return false;
	}
	/*
		过滤订单
	*/
	public function filterOrders($userId, $date, $place, $filter){
		$orders = null;
		if($filter=="#tab1"){
			$orders = OrdersAR::model()->filterNotSend($userId, $date, $place);
		}else if($filter=="#tab2"){
			$orders = OrdersAR::model()->filterSended($userId, $date, $place);
		}else if($filter=="#tab3"){
			$orders = OrdersAR::model()->filterCancel($userId, $date, $place);
		}
		return $orders;
	}
	
	/*
		取消订单
	*/

	public function cancelOrder($userId, $orderId){
		$order = OrdersAR::model()->find('seller_id=:userId and id=:orderId', 
			array(':userId'=>$userId, ':orderId'=>$orderId));
		$order->status=3;
		$order->save();
	}

	/*
		完成订单
	*/
	public function finishOrder($userId, $orderId){
		$order = OrdersAR::model()->find('seller_id=:userId and id=:orderId', 
			array(':userId'=>$userId, ':orderId'=>$orderId));
		$order->status=1;
		$order->save();
	}

	/*
		返回会员的订单
	*/
	public function getMemberOrders($memberId, $sellerId){
		$orders = OrdersAR::model()->findAll('member_id=:memberid and seller_id=:sellerid', 
			array(':memberid'=>$memberId, ':sellerid'=>$sellerId));
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}

	/*
		根据订单id得到订单
	*/
	public function getOrder($orderID) {
		$order = OrdersAR::model()->find('id=:orderID', array(':orderID'=>$orderID));
		OrdersAR::model()->changeOrderToView($order);
		return $order;
	}

	/**
	 * 根据sellerId获取订单
	 * @param unknown $sellerId
	 */
	public function getOrdersBySellerId($sellerId){
		$orders = OrdersAR::model()->findAll('seller_id=:sellerId', array(':sellerId'=>$sellerId));
		return $orders;
	}
	
	/**
	 * 根据sellerId获取一个商家每个会员的订单数量
	 * @param unknown $sellerId
	 */
	public function getOrdersCountBySellerId($sellerId){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "SELECT orders.member_id as member_id, COUNT(*) AS order_count FROM orders ".
				 "WHERE orders.seller_id=:sellerId GROUP BY orders.member_id";
		$orders = array();
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':sellerId',$sellerId);
			$result = $stmt->queryAll();
			return $result;
		}
		return $orders;
	}
	
	/**
	 * 根据会员的id获取所有订单
	 * @param $memberId
	 */
	public function getOrdersByMemeberId($memberId){
		$orders = OrdersAR::model()->findAll(
			array(
				'condition'=>'member_id=:memberId',
				'params'=>array(':memberId'=>$memberId),
				'order'=>'ctime DESC',
			)
		);
		return $orders;
	}
	
	/**
	 *	订订单
	 */
	public function makeOrder($sellerid, $memberid, $areaid, $areadesc, $phone, $tips) {
		$order = new OrdersAR;
		$order->seller_id = $sellerid;
		$order->member_id = $memberid;
		$order->area_id = $areaid;
		$order->address = $areadesc;
		$order->phone = $phone;
		$order->poster_id = 0;
		$order->status = 0;
		$order->total = 0;
		$order->description = $tips;
		$order->ctime = $date = date('Y-m-d H:i:s');
		$order->save();
		$order->order_no = OrdersAR::model()->getOrderNo($order->seller_id, $order->id, $order->ctime);
		$order->save();
		return $order;
	}

	public function setOrderTotal($orderId, $total){
		$order = OrdersAR::model()->find('id=:orderId', array(':orderId'=>$orderId));
		if(!empty($order)){
			$order->total = $total;
			$order->save();
		}
	}
	/*
		订单编号
	*/
	public function getOrderNo($sellerId, $orderId, $ctime){
		return $sellerId.$orderId.date('YmdHis');
	}

	/*
		删除订单
	*/
	public function deleteOrder($orderID) {
		$order = OrdersAR::model()->find('id=:orderID', array(':orderID'=>$orderID));
		$order->delete();
	}

	public function changeOrderToView($order) {
		if(empty($order)){
			return;
		}
		switch ($order->status){
				case 0: 
					$order->status = "待派送";
					break;
				case 1:
					$order->status = "已完成";
					break;
				case 2: 
					$order->status = "派送中";
					break;
				case 3: 
					$order->status = "已取消";
					break;
		}
		switch ($order->type) {
			case 0:
				$order->type = "通过微信下单";
				break;
			case 1:
				$order->type = "通过网页下单";
				break;
		}
		// $order->member_id = MembersAR::model()->getMemberName($order->member_id);
		
		$posterId = $order->poster_id;
		if($posterId==0){
			$order->poster_id = "无";
		}else{
			$order->poster_id = PostersAR::model()->getPoster($posterId)->name;
		};
		$order->seller_id = OrderItemsAR::model()->generateItems($order->id);
		$order->address = DistrictsAR::model()->getAreaName($order->area_id)."-".$order->address;
	}

	public function changeOrdersToView($orders) {
		if(empty($orders)){
			return;
		}
		foreach ($orders as $order) {
			OrdersAR::model()->changeOrderToView($order);
		}
	}

}