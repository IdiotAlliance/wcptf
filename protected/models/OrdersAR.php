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
			array('status, total, ctime, store_id, member_id, order_name, phone, area_id, update_time', 'required'),
			array('status, , use_card, type, poster_id', 'numerical', 'integerOnly'=>true),
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
			'total' => 'Taotal',
			'discount' => 'Discount',
			'ctime' => 'Ctime',
			'duetime' => 'Duetime',
			'description' => 'Description',
			'use_card' => 'Is memberId use card',
			'store_id' => 'Store',
			'member_id' => 'Member',
			'member_no' => 'Member No',
			'member_phone' => 'Member Phone',
			'member_status' => 'Member Status',
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
		$criteria->compare('use_card',$this->use_card,true);
		$criteria->compare('store_id',$this->store_id,true);
		$criteria->compare('member_id',$this->member_id,true);
		$criteria->compare('member_no',$this->member_no,true);
		$criteria->compare('member_phone',$this->member_phone,true);
		$criteria->compare('member_status',$this->member_status,true);
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
		$poster = PostersAR::model()->find('id=:posterId', array(':posterId'=>$posterId));
		$order = OrdersAR::model()->find('id=:orderId', array(':orderId'=>$orderId));
		if($order->status ==3){
			return false;
		}else{
			$order->poster_id = $posterId;
			if($poster!=null){
				$name = $poster->name;
				$phone = $poster->phone;
				$order->poster_name = $name;
				$order->poster_phone = $phone;
			}
			$order->status = 2;
			$order->save();
			return true;
		}
	}
	/*
		获取店铺ID
	*/
	public function getStoreIdByOrder($orderId){
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
	/*
		订单下载过滤函数
	*/
	public function filterOrderDownLoad($storeId, $startDate, $endDate, $areaId, $filter){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "";
		if($areaId == 0){
		//不过滤
			$query = "select * from orders where store_id=:storeId and ctime>=:startDate and ctime<=:endDate".
			" and (status=:status1 or status=:status2) order by ctime DESC";
		}else{
			$query = "select * from orders where store_id=:storeId and ctime>=:startDate and ctime<=:endDate".
			" and area_id in:areaId and (status=:status1 or status=:status2) order by ctime DESC";
		}
		if ($stmt = $connection->createCommand($query)) {
		    $stmt->bindParam(':storeId', $storeId);
		    $stmt->bindParam(':startDate', $startDate);
		    $stmt->bindParam(':endDate', $endDate);
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
		    OrdersAR::model()->changeOrdersToView($orders);
		    return $orders;
		}
	}
	public function changeArrayToAR($array){
		$orders = array();
		foreach ($array as $arr) {
			$order = new OrdersAR;
			$order->id = $arr['id'];
			$order->order_no = $arr['order_no'];
			$order->status = $arr['status'];
			$order->type = $arr['type'];
			$order->total = $arr['total'];
			$order->discount = $arr['discount'];
			$order->ctime = $arr['ctime'];
			$order->duetime = $arr['duetime'];
			$order->description = $arr['description'];
			$order->use_card = $arr['use_card'];
			$order->store_id = $arr['store_id'];
			$order->member_id = $arr['member_id'];
			$order->member_no = $arr['member_no'];
			$order->member_phone = $arr['member_phone'];
			$order->member_status = $arr['member_status'];
			$order->order_name = $arr['order_name'];
			$order->phone = $arr['phone'];
			$order->address = $arr['address'];
			$order->poster_id = $arr['poster_id'];
			$order->poster_name = $arr['poster_name'];
			$order->poster_phone = $arr['poster_phone'];
			$order->area_id = $arr['area_id'];
			$order->area_name = $arr['area_name'];
			$order->area_description = $arr['area_description'];
			$order->update_time = $arr['update_time'];
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
		if($order->status ==3){
			return false;
		}else{
			$order->status=1;
			$order->save();
			return true;
		}	
	}
	/*
		检查订单状态
	*/
	public function checkOrderStatus($storeId, $orderId){
		$order = OrdersAR::model()->find('store_id=:storeId and id=:orderId', 
			array(':storeId'=>$storeId, ':orderId'=>$orderId));
		if($order->status ==3){
			return false;
		}else{
			return true;
		}	
	}

	/*
		返回会员的订单
	*/
	public function getMemberOrders($memberId, $storeid){
		$orders = OrdersAR::model()->findAll(array('condition'=>'member_id=:memberid and store_id=:storeid', 
			'params'=>array(':memberid'=>$memberId, ':storeid'=>$storeid), 'order'=>'ctime DESC',));
		OrdersAR::model()->changeOrdersToView($orders);
		return $orders;
	}

	/*
		返回部分会员的订单
	*/
	public function getMemberPartOrders($memberId, $storeid, $ctime){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "select * from orders where store_id=:storeid and member_id=:memberId and ".
		" (ctime=:ctime or ctime<:ctime) order by ctime DESC";
		if ($stmt = $connection->createCommand($query)) {
		    $stmt->bindParam(':storeid', $storeid);
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
	 * 根据storeid获取订单
	 * @param unknown $storeid
	 */
	public function getOrdersBystoreid($storeid){
		$orders = OrdersAR::model()->findAll('store_id=:storeid', array(':storeid'=>$storeid));
		return $orders;
	}
	
	/**
	 * 根据storeid获取一个商家每个会员的订单数量
	 * @param unknown $storeid
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
	 * 修改会员的状态   by storeId&memberId
	 * @param $memberId $storeId
	 */
	public function modifyMemberStatus($memberId, $storeId, $status){
		$orders = OrdersAR::model()->findAll(
			array(
				'condition'=>'member_id=:memberId and store_id=:storeId',
				'params'=>array(':memberId'=>$memberId, ":storeId"=>$storeId),
				'order'=>'ctime DESC',
			)
		);
		//改变订单状态
		foreach ($orders as $order) {
			$order->member_status = $status;
			$order->update_time = round(microtime(true) * 1000);
			$order->save();
		}
	}
	
	/**
	 *	订订单
	 */
	public function makeOrder($storeid, $memberid, $areaid, $areadesc, $phone, $tips, $name, $useCard) {
		// $member = getBoundByStoreAndMember($sid, $memberId);
		// $memberPhone = $member->phone;
		// $memberCar = $member->cardno;
		// $timestamp = strtotime(date('Y-m-d H:i:s'));
		// $
		$area = DistrictsAR::model()->getDistrictById($areaid);
		$member = MemberBoundAR::model()->getBoundByStoreAndMember($storeid, $memberid);
		$memberNum = MemberNumbersAR::model()->getRequest($storeid, $memberid);
		$order = new OrdersAR;
		$order->store_id = $storeid;
		$order->member_id = $memberid;
		// 固化会员卡信息
		if($member!=null){
			$order->member_no = $member->cardno;
			$order->member_phone = $member->phone;
			$order->member_status = 2;
		}
		if($memberNum!=null){
			$order->member_status = 1;
		}
		// 固化区域信息
		$order->area_id = $areaid;
		if($area != null){
			$order->area_name = $area->name;
			$order->area_description = $area->description;
		}
		$order->address = $areadesc;
		$order->phone = $phone;
		$order->poster_id = 0;
		$order->status = 0;
		$order->total = 0;
		$order->description = $tips;
		$order->order_name = $name;
		$order->use_card = $useCard;
		$order->ctime = $date = date('Y-m-d H:i:s');
		$order->update_time = round(microtime(true) * 1000);
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
	public function getOrderNo($storeid, $orderId, $ctime){
		//每天的订单对1000000取余减伤0位
		$orderId = $orderId % 1000000;
		$orderId = str_pad($orderId, 6, "0", STR_PAD_LEFT);
		return date('Ymd').$orderId;
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
			$order->poster_name = "无";
		}
		$order->store_id = OrderItemsAR::model()->generateItems($order->id);
		$address = $order->area_name;
		if(!empty($address) && strlen($address)>0){
			$address = $address."-".$order->address;
		}else{
			$address = $order->address;
		}
		if($order->member_status == 1){
			$order->member_status = "会员待确认";
		}else if($order->member_status == 2){
			$order->member_status = "0";
		}else if($order->member_status == 0){
			$order->member_status = "0";
		}
		$order->address = $address;
		if($order->use_card ==0){
			$order->use_card =  "(非会员卡下单)";
		}else{
			$order->use_card = "(会员卡下单)";
		}
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
	public function headerModify($orderId ,$name, $phone, $desc, $total, $updateTime){
		$order = OrdersAR::model()->findByPk($orderId);
		if(!empty($order)){
			$order->order_name = $name;
			$order->phone = $phone;
			$order->description = $desc;
			$order->total = $total;
			$order->update_time = $updateTime;
			$order->update();
			return true;
		}else{
			return false;
		}
	}

	/**
	 * get order stats of current month and all in history
	 */
	public static function getOrderStats($userId){
		$connection = OrdersAR::model()->getDbConnection();
		$query = "SELECT SUM(total) AS sum FROM orders WHERE store_id IN 
		         (SELECT id FROM store WHERE seller_id=:userId) AND 
		          status = 1";
		if($stmt = $connection->createCommand($query)){
			$stmt->bindParam(':userId', $userId);
			$stats = $stmt->queryAll();
			return $stats[0]['sum'];
		}
		return 0;
	}
}