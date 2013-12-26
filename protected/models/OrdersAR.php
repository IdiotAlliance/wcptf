<?php

/**
 * This is the model class for table "orders".
 *
 * The followings are the available columns in table 'orders':
 * @property string $id
 * @property string $order_no
 * @property integer $status
 * @property integer $type
 * @property double $total
 * @property double $discount
 * @property string $ctime
 * @property string $duetime
 * @property string $description
 * @property string $store_id
 * @property string $member_id
 * @property string $member_no
 * @property string $member_phone
 * @property string $order_name
 * @property string $phone
 * @property string $address
 * @property integer $poster_id
 * @property string $poster_name
 * @property string $poster_phone
 * @property string $area_id
 * @property string $area_name
 * @property string $area_description
 * @property string $update_time
 *
 * The followings are the available model relations:
 * @property OrderItems[] $orderItems
 * @property Store $store
 * @property Members $member
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
			array('order_no, status, total, ctime, store_id, member_id, member_no, member_phone, order_name, phone, poster_id, poster_name, poster_phone, area_id, area_name, area_description, update_time', 'required'),
			array('status, type, poster_id', 'numerical', 'integerOnly'=>true),
			array('total, discount', 'numerical'),
			array('order_no, member_phone, phone, poster_name, poster_phone, area_name', 'length', 'max'=>32),
			array('store_id, member_id, area_id', 'length', 'max'=>11),
			array('member_no', 'length', 'max'=>256),
			array('order_name', 'length', 'max'=>64),
			array('duetime, description, address', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, order_no, status, type, total, discount, ctime, duetime, description, store_id, member_id, member_no, member_phone, order_name, phone, address, poster_id, poster_name, poster_phone, area_id, area_name, area_description, update_time', 'safe', 'on'=>'search'),
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
			'orderItems' => array(self::HAS_MANY, 'OrderItems', 'order_id'),
			'store' => array(self::BELONGS_TO, 'Store', 'store_id'),
			'member' => array(self::BELONGS_TO, 'Members', 'member_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'order_no' => 'Order No',
			'status' => 'Status',
			'type' => 'Type',
			'total' => 'Total',
			'discount' => 'Discount',
			'ctime' => 'Ctime',
			'duetime' => 'Duetime',
			'description' => 'Description',
			'store_id' => 'Store',
			'member_id' => 'Member',
			'member_no' => 'Member No',
			'member_phone' => 'Member Phone',
			'order_name' => 'Order Name',
			'phone' => 'Phone',
			'address' => 'Address',
			'poster_id' => 'Poster',
			'poster_name' => 'Poster Name',
			'poster_phone' => 'Poster Phone',
			'area_id' => 'Area',
			'area_name' => 'Area Name',
			'area_description' => 'Area Description',
			'update_time' => 'Update Time',
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
		$criteria->compare('order_no',$this->order_no,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
		$criteria->compare('total',$this->total);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('duetime',$this->duetime,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('member_no',$this->member_no,true);
		$criteria->compare('member_phone',$this->member_phone,true);
		$criteria->compare('order_name',$this->order_name,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('poster_id',$this->poster_id);
		$criteria->compare('poster_name',$this->poster_name,true);
		$criteria->compare('poster_phone',$this->poster_phone,true);
		$criteria->compare('area_id',$this->area_id,true);
		$criteria->compare('area_name',$this->area_name,true);
		$criteria->compare('area_description',$this->area_description,true);
		$criteria->compare('update_time',$this->update_time,true);

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
		$order->status = 2;
		$order->save();
	}
	/*
		获取店铺ID
	*/
	public function getstoreId($orderId){
		$order = OrdersAR::model()->find('id=:orderId', array(':orderId'=>$orderId));
		return $order->store_id;
	}

	/*
		获取未派送的订单地点过滤
	*/
	public function filterNotSend($storeId, $date, $areaId){
		$orders = OrdersAR::model()->filterBase($storeId, $date, $areaId, "#tab1");
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}
	/*
		获取已派送的订单
	*/
	public function filterSended($storeId, $date, $areaId){
		$orders = OrdersAR::model()->filterBase($storeId, $date, $areaId, "#tab2");
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}
	/*
		获取已取消的订单
	*/
	public function filterCancel($storeId, $date, $areaId){
		$orders = OrdersAR::model()->filterBase($storeId, $date, $areaId, "#tab3");
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
	/*
		#new	过滤函数
	*/
	public function filterOrder($storeId, $date, $filter){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "select * from orders where store_id=:storeId and TO_DAYS(ctime)=TO_DAYS(:date)".
			" and (status=:status1 or status=:status2) order by ctime DESC";
		if ($stmt = $connection->createCommand($query)) {
		    $stmt->bindParam(':storeId', $storeId);
		    $stmt->bindParam(':date', $date);
		    if($filter == "#tab3"){
		    	$stmt->bindValue(':status1', 3);
		    	$stmt->bindValue(':status2', 3);
		    }else if($filter == "#tab2"){
		    	$stmt->bindValue(':status1', 1);
		    	$stmt->bindValue(':status2', 2);
		    }else{
		    	$stmt->bindValue(':status1', 0);
		    	$stmt->bindValue(':status2', 4);
		    }
		    $result = $stmt->queryAll();
		    $orders = OrdersAR::model()->changeArrayToAR($result);
		    OrdersAR::model()->changeOrdersToView($orders);
		    return $orders;
		}
	}
	/*
		过滤函数
	*/
	public function filterBase($storeId, $date, $areaId, $filter){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "";
		if($areaId == 0){
		//不过滤
			$query = "select * from orders where store_id=:storeId and TO_DAYS(ctime)=TO_DAYS(:date)".
			" and (status=:status1 or status=:status2) order by ctime DESC";
		}else{
			$query = "select * from orders where store_id=:storeId and TO_DAYS(ctime)=TO_DAYS(:date)".
			" and area_id=:areaId and (status=:status1 or status=:status2) order by ctime DESC";
		}
		if ($stmt = $connection->createCommand($query)) {
		    $stmt->bindParam(':storeId', $storeId);
		    $stmt->bindParam(':date', $date);
		    if($areaId != 0){
		    	 $stmt->bindParam(':areaId', $areaId);
		    }
		    if($filter == "#tab3"){
		    	$stmt->bindValue(':status1', 3);
		    	$stmt->bindValue(':status2', 3);
		    }else if($filter == "#tab2"){
		    	$stmt->bindValue(':status1', 1);
		    	$stmt->bindValue(':status2', 2);
		    }else{
		    	$stmt->bindValue(':status1', 0);
		    	$stmt->bindValue(':status2', 4);
		    }
		    $result = $stmt->queryAll();
		    $orders = OrdersAR::model()->changeArrayToAR($result);
		    return $orders;
		}
	}

	public function changeArrayToAR($array){
		$orders = array();
		foreach ($array as $arr) {
			$order = new OrdersAR;
			$order->id = $arr['id'];
			$order->store_id = $arr['store_id'];
			$order->member_id = $arr['member_id'];
			$order->ctime = $arr['ctime'];
			$order->status = $arr['status'];
			$order->address = $arr['address'];
			$order->description = $arr['description'];
			$order->duetime = $arr['duetime'];
			$order->total = $arr['total'];
			$order->type = $arr['type'];
			$order->phone = $arr['phone'];
			$order->order_no = $arr['order_no'];
			$order->poster_id = $arr['poster_id'];
			$order->area_id = $arr['area_id'];
			$order->order_name = $arr['order_name'];
			array_push($orders, $order);
		}
		return $orders;
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
		取消订单
	*/

	public function cancelOrder($storeId, $orderId){
		$order = OrdersAR::model()->find('store_id=:storeId and id=:orderId', 
			array(':storeId'=>$storeId, ':orderId'=>$orderId));
		OrdersAR::model()->backInstore($order);
		$order->status=3;
		$order->save();
	}

	public function backInstore($order){
		if(!empty($order)){
			$items = OrderItemsAR::model()->getTrueItems($order->id);
			foreach ($items as $item) {
				ProductsAR::model()->buyProduct($item->product_id, $order->store_id, -$item->number);
			}
		}
	}

	/*
		完成订单
	*/
	public function finishOrder($storeId, $orderId){
		$order = OrdersAR::model()->find('store_id=:storeId and id=:orderId', 
			array(':storeId'=>$storeId, ':orderId'=>$orderId));
		$order->status=1;
		$order->save();
	}

	/*
		返回会员的订单
	*/
	public function getMemberOrders($memberId, $sellerId){
		$orders = OrdersAR::model()->findAll(array('condition'=>'member_id=:memberid and store_id=:sellerid', 
			'params'=>array(':memberid'=>$memberId, ':sellerid'=>$sellerId), 'order'=>'ctime DESC',));
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}

	/*
		返回部分会员的订单
	*/
	public function getMemberPartOrders($memberId, $sellerId, $ctime){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "select * from orders where store_id=:sellerId and member_id=:memberId and ".
		" (ctime=:ctime or ctime<:ctime) order by ctime DESC";
		if ($stmt = $connection->createCommand($query)) {
		    $stmt->bindParam(':sellerId', $sellerId);
		    $stmt->bindParam(':memberId', $memberId);
		    $stmt->bindParam(':ctime', $ctime);
		    $result = $stmt->queryAll();
		    $orders = OrdersAR::model()->changeArrayToAR($result);
		    OrdersAR::model()->changeOrdersToView($orders);
		    return $orders;
		}
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
		$orders = OrdersAR::model()->findAll('store_id=:sellerId', array(':sellerId'=>$sellerId));
		return $orders;
	}
	
	/**
	 * 根据sellerId获取一个商家每个会员的订单数量
	 * @param unknown $sellerId
	 */
	public function getOrdersCountBySellerId($sellerId){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "SELECT orders.member_id as member_id, COUNT(*) AS order_count FROM orders ".
				 "WHERE orders.store_id=:sellerId GROUP BY orders.member_id";
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
	public function makeOrder($sellerid, $memberid, $areaid, $areadesc, $phone, $tips, $name) {
		$order = new OrdersAR;
		$order->store_id = $sellerid;
		$order->member_id = $memberid;
		$order->area_id = $areaid;
		$order->address = $areadesc;
		$order->phone = $phone;
		$order->poster_id = 0;
		$order->status = 0;
		$order->total = 0;
		$order->description = $tips;
		$order->order_name = $name;
		$order->ctime = $date = date('Y-m-d H:i:s');
		$order->save();
		$order->order_no = OrdersAR::model()->getOrderNo($order->store_id, $order->id, $order->ctime);
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
		//每天的订单对1000000取余减伤0位
		$orderId = $orderId % 1000000;
		$orderId = str_pad($orderId, 6, "0", STR_PAD_LEFT);
		return date('Ymd').$orderId;
	}
	/*
		订单已读
	*/
	public function readOrder($orderId){
		$order = OrdersAR::model()->findByPk($orderId);
		$order->status = 0;
		$order->save();
	}

	/*
		删除订单
	*/
	public function deleteOrder($orderID) {
		$order = OrdersAR::model()->find('id=:orderID', array(':orderID'=>$orderID));
		if(!empty($order)){
			$order->delete();
		}
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
				case 4:
					$order->status = "未读";
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
			$poster = PostersAR::model()->getPoster($posterId);
			if(!empty($poster)){
				$order->poster_id = $poster->name;
			}else{
				$order->poster_id = "无";
			}
		};
		$order->store_id = OrderItemsAR::model()->generateItems($order->id);
		$address = DistrictsAR::model()->getAreaName($order->area_id);
		if(!empty($address) && strlen($address)>0){
			$address = $address."-".$order->address;
		}else{
			$address = $order->address;
		}
		$order->address = $address;
	}

	public function changeOrdersToView($orders) {
		if(empty($orders)){
			return;
		}
		foreach ($orders as $order) {
			OrdersAR::model()->changeOrderToView($order);
		}
	}
	/*
		修改订单头
	*/
	public function headerModify($orderId ,$name, $phone, $desc, $total){
		$order = OrdersAR::model()->findByPk($orderId);
		if(!empty($order)){
			$order->order_name = $name;
			$order->phone = $phone;
			$order->description = $desc;
			$order->total = $total;
			$order->update();
			return true;
		}else{
			return false;
		}
	}
}