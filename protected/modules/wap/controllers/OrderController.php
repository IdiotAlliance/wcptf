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
		if(isset($_POST['sellerid'])){
			$sellerid = $_POST['sellerid'];
		}else{
			$result = "sellerid is null";
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

		//checkUser
		$member = MembersAR::model()->getMemberByOpenId($openid);
		// 用户不存在
		if(empty($member)){
			//$member = MembersAR::model()->createMember($sellerid, $openid, $name);
			$result = "user not exsit";
			$arr=array('success'=>'2', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		if(strcmp($member->wapKey, $wapKey) != 0){
			$result = "wapKey is out";
			$arr=array('success'=>'2', 'result'=>$result);
			echo json_encode($arr);
			exit;
		}
		//订单
		$order = OrdersAR::model()->makeOrder($sellerid, $member->id, $areaid, $areadesc, $phone, $tips);
		//子项订单
		$len = count($products);
		$total = 0;
		for($tmp=0; $tmp<$len; $tmp++){
			$result = OrderItemsAR::model()->createItem($sellerid, $order->id, $products[$tmp], $nums[$tmp]);
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
			$seller = UsersAR::model()->findByPk($sellerid);
			if(!empty($sellerid)){
				//是否免外送费
				$threshold = $seller->threshold;
				$takeawayFee = $seller->takeaway_fee;
				$startPrice = $seller->start_price;
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
						//订单失败
						$result = "订单费用没有超过起送费";
						OrderItemsAR::model()->deleteItems($order->id);
						OrdersAR::model()->deleteOrder($order->id);
						OrdersAR::model()->setOrderTotal($order->id, $total);
						$arr=array('success'=>'2', 'result'=>$result);
						echo json_encode($arr);
						exit;
					}
				}
				
			}
			OrdersAR::model()->setOrderTotal($order->id, $total);
			$arr=array('success'=>'1', 'result'=>$result);
		} else{
			$arr=array('success'=>'2', 'result'=>$result);
		}
		echo json_encode($arr);
	}

	/*
		获取会员订单
	*/
	public function actionGetOrders(){
		if(isset($_POST['openid']) && isset($_POST['sellerid'])){
			$openid = $_POST['openid'];
			$sellerid = $_POST['sellerid'];
			$member = MembersAR::model()->getMemberByOpenId($openid);
			if(!empty($member)){
				$orders = OrdersAR::model()->getMemberOrders($member->id, $sellerid);
				$orderViews = array();
				foreach ($orders as $order) {
					array_push($orderViews, 
						array("name"=>$order->member_id,
							 "phone"=>$order->phone,
							 "order_no"=>$order->order_no,
							 "order_id"=>$order->id,
							 "total"=>$order->total,
							 "order_items"=>$order->seller_id,
							 "address"=>$order->address,
							 "ctime"=>$order->ctime,
							 "status"=>$order->status,
							));
				}
				$arr=array('success'=>'1', 'result'=>$orderViews);
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

	/*
		获取会员时间和数量订单
	*/
	public function actionGetPartOrders(){
		if(isset($_POST['openid']) && isset($_POST['sellerid'])
		 && isset($_POST['wapKey']) && isset($_POST['num'])){
			$openid = $_POST['openid'];
			$sellerid = $_POST['sellerid'];
			$wapKey = $_POST['wapKey'];
			$endtime = $_POST['endtime'];
			$num = $_POST['num'];
			$member = MembersAR::model()->getMemberByOpenId($openid);
			$nextTime = null;
			if(!empty($member)){
				if(strcmp($member->wapKey, $wapKey) != 0){
					$result = "wapKey is out";
					$arr=array('success'=>'2', 'result'=>$result);
					echo json_encode($arr);
					exit;
				}
				$orders = null;
				if($endtime == null){
					$orders = OrdersAR::model()->getMemberOrders($member->id, $sellerid);
					if(count($orders)<=$num){

					}else{
						$nextTime = $orders[$num]->ctime;
						$orders = getNumOrders($orders, $num);
					}
				}else{
					$orders = OrdersAR::model()->getMemberPartOrders($member->id, $sellerid, $endtime);
					if(count($orders)<=$num){

					}else{
						$nextTime = $orders[$num]->ctime;
						$orders = getNumOrders($orders, $num);
					}
				}
				$orderViews = array();
				foreach ($orders as $order) {
					array_push($orderViews, 
						array("name"=>$order->member_id,
							 "phone"=>$order->phone,
							 "order_no"=>$order->order_no,
							 "order_id"=>$order->id,
							 "total"=>$order->total,
							 "order_items"=>$order->seller_id,
							 "address"=>$order->address,
							 "ctime"=>$order->ctime,
							 "status"=>$order->status,
							));
				}
				$arr=array('success'=>'1', 'result'=>$orderViews, 'nexttime'=>$nextTime);
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

	public function actionTest(){
		$order = OrdersAR::model()->makeOrder(2, 2, 1, "xx", "12333", "xxxx");
		echo $order->phone;
	}


}