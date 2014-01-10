<?php

class OrderController extends Controller
{
	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionOrder(){
		$openid=0;
		$name="";
		$areaid = 0;
		$sellerid = 0;
		$storeid = 0;
		$usecard = false;
		$areadesc = "";
		$phone = 0;
		$tips = "";
		$products=null;
		$nums=null;
		$result = "";
		$wapKey = "";
		if(isset($_POST['openid'])){
			$openid = $_POST['openid'];
		}else{
			$result = "openid is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['name'])){
			$name = $_POST['name'];
		}else{
			$result = "name is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['areaid'])){
			$areaid = $_POST['areaid'];
		}else{
			$result = "areaid is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['storeid'])){
			$storeid = $_POST['storeid'];
		}else{
			$result = "storeid is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['sellerid'])){
			$sellerid = $_POST['sellerid'];
		}else{
			$result = "sellerid is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['usecard'])){
			$usecard = $_POST['usecard'];
		}else{
			$result = "use_card is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['areadesc'])){
			$areadesc = $_POST['areadesc'];
		}else{
			$result = "areadesc is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['phone'])){
			$phone = $_POST['phone'];
		}else{
			$result = "phone is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['tips'])){
			$tips = $_POST['tips'];
		}else{
			$result = "tips is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['products'])){
			$products = $_POST['products'];
		}else{
			$result = "products is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['nums'])){
			$nums = $_POST['nums'];
		}else{
			$result = "nums is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(isset($_POST['wapKey'])){
			$wapKey = $_POST['wapKey'];
		}else{
			$result = "wapKey is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		//sql && xss check
		require "HtmLawed.php";
		if($this->inject_check($name)){
			$arr=array('success'=>'3');
			echo json_encode($arr);
			exit;
		}
		if($this->inject_check($tips)){
			$arr=array('success'=>'3');
			echo json_encode($arr);
			exit;
		}
		if($this->inject_check($areadesc)){
			$arr=array('success'=>'3');
			echo json_encode($arr);
			exit;
		}
		if($this->inject_check($phone)){
			$arr=array('success'=>'3');
			echo json_encode($arr);
			exit;
		}
		if($this->inject_check($wapKey)){
			$arr=array('success'=>'3');
			echo json_encode($arr);
			exit;
		}
		$config = $config = array('safe'=>1, "elements"=>"-*");
		$areadesc = htmLawed($areadesc, $config);
		$name = htmLawed($name, $config);
		$phone = htmLawed($phone, $config);
		$wapKey = htmLawed($wapKey, $config);
		$tips = htmLawed($tips, $config);
		//checkUser
		$member = MembersAR::model()->getMemberByOpenId($openid);
		// 用户不存在
		if(empty($member)){
			//$member = MembersAR::model()->createMember($storeid, $openid, $name);
			$result = "user not exsit";
			$arr=array('success'=>'2', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(strcmp($member->wapkey, $wapKey) != 0){
			$result = "wapKey is out";
			$arr=array('success'=>'2', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		$area = DistrictsAR::model()->findByPk($areaid);
		// 校验地址
		if(empty($area)){
			$result = "areaid is out";
			$arr=array('success'=>'2', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		$store = StoreAR::model()->findByPk($storeid);
		if(!empty($store)){
			if($store->status!=0){
				$result = "service is out";
				$arr=array('success'=>'2', 'result'=>$result);
				echo json_encode($arr);
				exit;
			}
			$nowTime = date('H:i:s');
			if($store->stime<$nowTime && $store->etime>$nowTime){

			}else{
				$result = "service is out";
				$arr=array('success'=>'2', 'result'=>$result);
				echo json_encode($arr);
				exit;
			}

		}else{

		}
		//订单
		$order = OrdersAR::model()->makeOrder($storeid, $member->id, $areaid, $areadesc, $phone, $tips, $name, $usecard);
		//子项订单
		$len = count($products);
		$total = 0;
		for($tmp=0; $tmp<$len; $tmp++){
			$result = OrderItemsAR::model()->createItem($storeid, $order->id, $products[$tmp], $nums[$tmp]);
			if(strcmp("ok", $result)!=0){
					OrderItemsAR::model()->deleteItems($order->id);
					OrdersAR::model()->deleteOrder($order->id);
				break;
			}
		}
		
		if(strcmp("ok", $result)==0){
			//成功
			$items = OrderItemsAR::model()->getItems($order->id);
			foreach ($items as $item) {
				$total = $total + $item->price;
			}
			if(!empty($storeid)){                         
				//是否免外送费
				$threshold = $store->threshold;
				$takeawayFee = $store->takeaway_fee;
				$startPrice = $store->start_price;
				if($threshold){
					//超过免外卖费，不超过送+外卖费
					if($total>=$startPrice){

					}else{
						$total=$total+$takeawayFee;
					}
				}else{
					//不超过不能送，超过也有外卖费
					if($total>=$startPrice){
						$total = $total+ $takeawayFee;
					}else{
						// 订单失败
						$result = "order total is low".$total;
						OrderItemsAR::model()->deleteItems($order->id);
						OrdersAR::model()->deleteOrder($order->id);
						$arr=array('success'=>'2', 'result'=>$result);
						echo json_encode($arr);
						exit;
					}
				}
				
			}
			OrdersAR::model()->setOrderTotal($order->id, $total);
			//订单消息
			OrdermsgsAR::model()->insertMsg($sellerid, $order->id, $storeid, $order->ctime, 0);

			$arr=array('success'=>'1', 'result'=>$result);
		} else{
			$arr=array('success'=>'2', 'result'=>$result);
		}
		// $arr=array('success'=>'1', 'result'=>'ok');
		echo json_encode($arr);
	}

	/*
		获取会员订单
	*/
	// public function actionGetOrders(){
	// 	if(isset($_POST['openid']) && isset($_POST['storeid'])){
	// 		$openid = $_POST['openid'];
	// 		$storeid = $_POST['storeid'];
	// 		$member = MembersAR::model()->getMemberByOpenId($openid);
	// 		if(!empty($member)){
	// 			$orders = OrdersAR::model()->getMemberOrders($member->id, $storeid);
	// 			$orderViews = array();
	// 			foreach ($orders as $order) {
	// 				array_push($orderViews, 
	// 					array("name"=>$order->order_name,
	// 						 "phone"=>$order->phone,
	// 						 "order_no"=>$order->order_no,
	// 						 "order_id"=>$order->id,
	// 						 "total"=>$order->total,
	// 						 "order_items"=>$order->store_id,
	// 						 "address"=>$order->address,
	// 						 "ctime"=>$order->ctime,
	// 						 "status"=>$order->status,
	// 						));
	// 			}
	// 			$arr=array('success'=>'1', 'result'=>$orderViews);
	// 			echo json_encode($arr);
	// 		}else{
	// 			$result = "openid is no exist";
	// 			$arr=array('success'=>'2', 'result'=>$result);
	// 			echo json_encode($arr);
	// 		}
	// 	}else{
	// 		$result = "openid is null";
	// 		$arr=array('success'=>'0', 'result'=>$result);
	// 		echo json_encode($arr);
	// 	}

	// }

	/*
		获取会员时间和数量订单
	*/
	public function actionGetPartOrders(){
		if(isset($_POST['openid']) && isset($_POST['storeid'])
		 && isset($_POST['wapKey']) && isset($_POST['num'])){
			$openid = $_POST['openid'];
			$storeid = $_POST['storeid'];
			$wapKey = $_POST['wapKey'];
			$endtime = $_POST['endtime'];
			$num = $_POST['num'];
			$member = MembersAR::model()->getMemberByOpenId($openid);
			$nextTime = null;
			if(!empty($member)){
				if(strcmp($member->wapkey, $wapKey) != 0){
					$result = "wapKey is out";
					$arr=array('success'=>'2', 'result'=>$result);
					echo json_encode($arr);
					exit;
				}
				$orders = null;
				if($endtime == null){
					$orders = OrdersAR::model()->getMemberOrders($member->id, $storeid);
					if(count($orders)<=$num){

					}else{
						$nextTime = $orders[$num]->ctime;
						$orders = $this->getNumOrders($orders, $num);
					}
				}else{
					$orders = OrdersAR::model()->getMemberPartOrders($member->id, $storeid, $endtime);
					if(count($orders)<=$num){

					}else{
						$nextTime = $orders[$num]->ctime;
						$orders = $this->getNumOrders($orders, $num);
					}
				}
				$orderViews = array();
				foreach ($orders as $order) {
					$newOrder = OrdersAR::model()->findByPk($order->id);
					$poster = PostersAR::model()->findByPk($newOrder->poster_id);
					$user = StoreAR::model()->findByPk($newOrder->store_id);
					$posterPhone = "";
					if(!empty($poster)){
						$posterPhone = $poster->phone;
					}
					array_push($orderViews, 
						array("name"=>$order->order_name,
							 "phone"=>$order->phone,
							 "order_no"=>$order->order_no,
							 "order_id"=>$order->id,
							 "total"=>$order->total,
							 "order_items"=>$order->store_id,
							 "address"=>$order->address,
							 "ctime"=>$order->ctime,
							 "status"=>$order->status,
							 "poster_name"=>$order->poster_id,
							 'poster_phone'=>$posterPhone,
							 'tips'=>$order->description,
							));
				}
				$arr=array('success'=>'1', 'result'=>$orderViews, 'nexttime'=>$nextTime, 'storephone'=>$user->phone,);
				echo json_encode($arr);
			}else{
				$result = "openid is no exist";
				$arr=array('success'=>'2', 'result'=>$result);
				echo json_encode($arr);
			}
		}else{
			$result = "openid is null";
			$arr=array('success'=>'0', 'result'=>$result);
			echo json_encode($arr);
		}

	}
	// 获取指定数量的订单
	public function getNumOrders($orders, $num){
		$newOrders = array();
		for($i=0;$i<$num;$i++){
			array_push($newOrders, $orders[$i]);
		}
		return $newOrders;
	}

	function inject_check($sql_str) { 
    	return preg_match('%select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile%i', $sql_str);
	}

	public function actionTest(){
		$order = OrdersAR::model()->makeOrder(2, 2, 1, "xx", "12333", "xxxx");
		echo $order->phone;
	}


}