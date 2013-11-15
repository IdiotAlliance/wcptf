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
		//checkUser
		$member = MembersAR::model()->getMemberByOpenId($openid);
		if(empty($member)){
			$member = MembersAR::model()->createMember($sellerid, $openid, $name);
		}
		//订单
		$order = OrdersAR::model()->makeOrder($sellerid, $member->id, $areaid, $areadesc, $phone, $tips);
		//子项订单
		$len = count($products);
		$total = 0;
		for($tmp=0; $tmp<$len; $tmp++){
			$result = OrderItemsAR::model()->createItems($sellerid, $order->id, $products[$tmp], $nums[$tmp]);
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

	public function actionTest(){
		$order = OrdersAR::model()->makeOrder(2, 2, 1, "xx", "12333", "xxxx");
		echo $order->phone;
	}


}