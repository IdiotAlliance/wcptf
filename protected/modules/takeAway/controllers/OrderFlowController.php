<?php

class OrderFlowController extends Controller
{
	public $layout = '/layouts/main';
    public $defaultAction = 'orderFlow';
    public $notSendNum = 0;
    public $sendedNum = 0;
    public $cancelNum = 0;
    //显示的第一个订单的订单号
    public $firstOrderID = 0;
    public $userID = 0;

	public function actionOrderFlow()
	{
		$this->render('orderFlow');
	}
	/*
		初始化header订单数
	*/
	public function init(){
		$date = date("Y-m-d H:i:s");
		$areaId = 0;
		$this->userID = $this->getUserId();
		//TODO when $userID is null
		$orders = OrdersAR::model()->filterNotSend($this->userID, $date, $areaId);
		$orders1 = OrdersAR::model()->filterSended($this->userID, $date, $areaId);
		$orders2 = OrdersAR::model()->filterCancel($this->userID, $date, $areaId);
		if(!empty($orders)){
			$this->firstOrderID = $orders[0]->id;
		}
		$this->notSendNum = count($orders);
		$this->sendedNum = count($orders1);
		$this->cancelNum = count($orders2);
	}
	/*
		初始化加载订单
	*/
	public function actionInit(){
		$date = date("Y-m-d H:i:s");
		$areaId = 0;
		$orders = OrdersAR::model()->filterNotSend($this->userID, $date, $areaId);
		return $this->renderPartial('_orderList1', array('orders'=>$orders), true, false);
	}
	/*
		#new ajax获取订单列表
	*/
	public function actionFilterOrderList(){
		$day = 0;
		$filter = "";
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		if(isset($_POST['filter'])){
			$filter = $_POST['filter'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$orders = OrdersAR::model()->filterOrder($this->userID, $date, $filter);
		$orderViews = array();
		foreach ($orders as $order) {
			$newOrder = OrdersAR::model()->findByPk($order->id);
			$poster = PostersAR::model()->findByPk($newOrder->poster_id);
			$user = UsersAR::model()->findByPk($newOrder->seller_id);
			$posterPhone = "";
			if(!empty($poster)){
				$posterPhone = $poster->phone;
			}
			array_push($orderViews, 
				array("name"=>$order->order_name,
					 "phone"=>$order->phone,
					 "order_no"=>$order->order_no,
					 "orderType"=>$order->type,
					 "order_id"=>$order->id,
					 "total"=>$order->total,
					 "order_items"=>$order->seller_id,
					 "address"=>$order->address,
					 "areaId"=>$order->area_id,
					 "ctime"=>$order->ctime,
					 "status"=>$order->status,
					 "poster_name"=>$order->poster_id,
					 'desc'=>$order->description,
					));
		}
		$arr=array('success'=>'1', 'orderList'=>$orderViews);
		echo json_encode($arr);
	}
	/*
		#new ajax获取订单
	*/
	public function actionFilterOrder(){
		$orderId = 0;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
			$order = OrdersAR::model()->getOrder($orderId);
			$orderView = array("name"=>$order->order_name,
						 "phone"=>$order->phone,
						 "order_no"=>$order->order_no,
						 "orderType"=>$order->type,
						 "order_id"=>$order->id,
						 "total"=>$order->total,
						 "order_items"=>$order->seller_id,
						 "address"=>$order->address,
						 "areaId"=>$order->area_id,
						 "ctime"=>$order->ctime,
						 "status"=>$order->status,
						 "orderType"=>$order->type,
						 "poster_name"=>$order->poster_id,
						 'desc'=>$order->description,
						);
			$arr=array('success'=>'1', 'order'=>$orderView);
		}else{
			$arr=array('success'=>'0');
		}
		echo json_encode($arr);
	}
	/*
		#new ajax获取订单子项
	*/
	public function actionFilterOrderItems(){
		$orderId = 0;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
			$orderItems = OrderItemsAR::model()->getItems($orderId);
			$itemViews = array();
			foreach ($orderItems as $item) {
				$pos = strpos($item->product_id, ':');
				array_push($itemViews, array(
						"itemId" => $item->id,
						"product" => substr($item->product_id, 0, $pos),
						"productType" => substr($item->product_id, $pos+1),
						"number" => $item->number,
						"price" => $item->price,
					));
			}
			$arr=array('success'=>'1', 'itemList'=>$itemViews);
		}else{
			$arr=array('success'=>'0');
		}
		echo json_encode($arr);
	}

	/*
		ajax未派送订单
	*/
	public function actionNotSend(){
		$day = 0;
		$areaId = 0;
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		if(isset($_POST['areaId'])){
			$areaId = $_POST['areaId'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$orders = OrdersAR::model()->filterNotSend($this->userID, $date, $areaId);
		echo $this->renderPartial('_orderList1', array('orders'=>$orders), true, false);
	}
	/*
		ajax获取已派送订单
	*/
	public function actionSended(){
		$day = 0;
		$areaId = 0;
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		if(isset($_POST['areaId'])){
			$areaId = $_POST['areaId'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$orders = OrdersAR::model()->filterSended($this->userID, $date, $areaId);
		echo $this->renderPartial('_orderList2', array('orders'=>$orders), true, false);
	}

	/*
		ajax获取已取消订单
	*/
	public function actionCancel(){
		$day = 0;
		$areaId = 0;
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		if(isset($_POST['areaId'])){
			$areaId = $_POST['areaId'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$orders = OrdersAR::model()->filterCancel($this->userID, $date, $areaId);
		echo $this->renderPartial('_orderList3', array('orders'=>$orders), true, false);
	}
	
	/*
		ajax获取订单子项
	*/
	public function actionGetOrderItems(){
		$orderId = null;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
		}
		$orderItems = OrderItemsAR::model()->getItems($orderId);
		$order = OrdersAR::model()->getOrder($orderId);
		if(empty($order)){
			echo "没有订单数据";
		}else{
			if($order->status == "未读"){
				OrdersAR::model()->readOrder($orderId);
			}
			echo $this->renderPartial('_orderItems', array('order'=>$order, 'orderItems'=>$orderItems), true, false);
		}
		
	}
	
	/*
		第一次ajax获取订单子项
	*/
	public function actionfirstGetOrderItems(){
		$orderId = $this->firstOrderID;
		$orderItems = OrderItemsAR::model()->getItems($orderId);
		$order = ordersAR::model()->getOrder($orderId);
		if(empty($order)){
			echo "没有订单数据";
		}else{
			echo $this->renderPartial('_orderItems', array('order'=>$order, 'orderItems'=>$orderItems), true, false);
		}
		
	}
	/*
		取消订单
	*/
	public function actionCancelOrder(){
		$orderId = 1;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
			ordersAR::model()->cancelOrder($this->userID, $orderId);
			$arr=array('success'=>'1');
			echo json_encode($arr);
		}else{
			$arr=array('success'=>'0');
			echo json_encode($arr);
		}
		
	}
	/*
		批量取消订单
	*/
	public function actionBatCancelOrder(){
		if(isset($_POST['orderIds'])){
			$orderIds = $_POST['orderIds'];
			foreach ($orderIds as $orderId) {
				ordersAR::model()->cancelOrder($this->userID, $orderId);
			}
			$arr=array('success'=>'1');
			echo json_encode($arr);
		}else{
			$arr=array('success'=>'0');
			echo json_encode($arr);
		}
	}
	/*
		完成订单
	*/
	public function actionFinishOrder(){
		$orderId = 0;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
			ordersAR::model()->finishOrder($this->userID, $orderId);
			$arr=array('success'=>'1');
			echo json_encode($arr);
		}else{
			$arr=array('success'=>'0');
			echo json_encode($arr);
		}
	}
	/*
		批量完成订单
	*/
	public function actionBatFinishOrder(){
		if(isset($_POST['orderIds'])){
			$orderIds = $_POST['orderIds'];
			foreach ($orderIds as $orderId) {
				ordersAR::model()->finishOrder($this->userID, $orderId);
			}
			$arr=array('success'=>'1');
			echo json_encode($arr);
		}else{
			$arr=array('success'=>'0');
			echo json_encode($arr);
		}
	}

	/*
		定期更新数据
	*/
	public function actionUpdate(){
		$userID = $this->getUserId();
		$timeOut = 20;
		$tabOneOrderList = null;
		$tabTwoOrderList = null;
		$tabThreeOrderList = null;
		$nums = null;
		$day = 0;
		if(isset($_POST['time'])){
			$timeOut = $_POST['time'];
		}	
		if(isset($_POST['tabOneOrderList'])){
			$tabOneOrderList = $_POST['tabOneOrderList'];
		}
		if(isset($_POST['tabTwoOrderList'])){
			$tabTwoOrderList = $_POST['tabTwoOrderList'];
		}
		if(isset($_POST['tabThreeOrderList'])){
			$tabThreeOrderList = $_POST['tabThreeOrderList'];
		}
		if(isset($_POST['nums'])){
			$nums = $_POST['nums'];
		}
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		$this->updateListener($userID, $day);
	}
	/*
		主动更新操作
	*/
	public function actionUpdateOperate(){
		$userID = $this->getUserId();
		$day = 0;
		$areaId = 0;
		if(isset($_POST['areaId'])){
			$areaId = $_POST['areaId'];
		}
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$notSendNum = count(OrdersAr::model()->filterNotSend($userID, $date, $areaId));
        $sendedNum = count(OrdersAr::model()->filterSended($userID, $date, $areaId));
        $cancelNum = count(OrdersAr::model()->filterCancel($userID, $date, $areaId));
        $arr=array('operate'=>'1', 'header'=>array($notSendNum, $sendedNum, $cancelNum));
        echo json_encode($arr);
	}
	/*
		更新接口
		success：1需要当前页刷新；2不需要当前页刷新只刷新头；
	*/
	public function updateListener($userID, $day){
        $date = date("Y-m-d H:i:s",strtotime($day." day"));
        $tabOneOrders = OrdersAR::model()->filterOrder($this->userID, $date, "#tab1");
        $tabTwoOrders = OrdersAR::model()->filterOrder($this->userID, $date, "#tab2");
        $tabThreeOrders = OrdersAR::model()->filterOrder($this->userID, $date, "#tab3");
        $tempLen = count($tabOneOrders);
        $tabOneOrderIdList = array();
        $tabTwoOrderIdList = array();
        $tabThreeOrderIdList = array();
        for($i=0; $i<$tempLen; $i++){
        	array_push($tabOneOrderIdList, $tabOneOrders[$i]->id);
        }
        $tempLen = count($tabTwoOrders);
        for($i=0; $i<$tempLen; $i++){
        	array_push($tabTwoOrderIdList, $tabTwoOrders[$i]->id);
        }
        $tempLen = count($tabThreeOrders);
        for($i=0; $i<$tempLen; $i++){
        	array_push($tabThreeOrderIdList, $tabThreeOrders[$i]->id);
        }
        $arr=array('success'=>'1', "tabOneOrderIdList"=>$tabOneOrderIdList,
        							"tabTwoOrderIdList"=>$tabTwoOrderIdList,
        							"tabThreeOrderIdList"=>$tabThreeOrderIdList);
        echo json_encode($arr);
        exit;

   //      $currentList = OrdersAR::model()->filterBase($userID, $date, $areaId, $filter);
   //      $notSendNum = count(OrdersAr::model()->filterNotSend($userID, $date, $areaId));
   //      $sendedNum = count(OrdersAr::model()->filterSended($userID, $date, $areaId));
   //      $cancelNum = count(OrdersAr::model()->filterCancel($userID, $date, $areaId));
   //      $currentLen = count($currentList);
   //      $existLen = count($existList);
   //      $updateOrderList = array();
   //      //检测当前列表是否和数据库列表匹配
   //      if($existList!=null){
   //      	for($tmp=0;$tmp!=$currentLen;$tmp++){
   //      	    if(!in_array($currentList[$tmp]->id, $existList)){
   //      	    	array_push($updateOrderList, $currentList[$tmp]->id);
   //      	    }
   //      	}
   //      }else{
   //      	for($tmp=0;$tmp!=$currentLen;$tmp++){
   //  	    	array_push($updateOrderList, $currentList[$tmp]->id);
   //      	}
   //      }
   //      if(count($updateOrderList)>0){
	  //       $arr=array('success'=>'1', 
	  //       			'updateOrders'=>$updateOrderList,
	  //       			'nums'=>array($notSendNum, $sendedNum, $cancelNum));
	  //       echo json_encode($arr);
			// exit;
   //      }
   //      //检测页头相等
   //      if((intval($nums[0][0])!= $notSendNum )|| (intval($nums[1][0])!=$sendedNum )|| (intval($nums[2][0])!=$cancelNum)){
   //           $arr=array('success'=>'2', 'nums'=>array($notSendNum, $sendedNum, $cancelNum));
   //           echo json_encode($arr);
			//  exit;
   //      }
   //      //没有需要更新
   //      $arr=array('success'=>'0');
   //      echo json_encode($arr);
   //      exit;
    }

    public function actionGetPosters(){
    	$orderId = null;
    	$userId = null;
    	if(isset($_POST['orderId'])){
    		$orderId = $_POST['orderId'];
    		$userId = OrdersAR::model()->getUserId($orderId);
    		$model = new ChoosePosterForm;
    		$posters = PostersAR::model()->getWorkPosters($userId);
    		$posterViews = array();
    		foreach ($posters as $poster)
    		{
    			$posterViews[$poster->id] = $poster->name." 电话：".$poster->phone;
    		   //array_push($posterViews, $poster->id=>"name:".$poster->name." 电话：".$poster->phone.count($posters).$this->userID);
    		}
    		//$arr=array('success'=>'0', 'html'=>$this->renderPartial('_posters', array('model'=>$model, 'posterViews'=>$posterViews)));
    		// 
    		echo $this->renderPartial('_posters', array('model'=>$model, 'posterViews'=>$posterViews));
    		exit;
    	}else{
   //  		$arr=array('success'=>'1', 'html'=>'poster is not find',);
			// echo json_encode($arr);
			echo "poster is not find";
			exit;
    	}	
    }
    /*
    	设置派送人员
    */
    public function actionSetPosters(){
    	$orderId = null;
    	if(isset($_POST['orderId']) && isset($_POST['posterId'])){
    		$orderId = $_POST['orderId'];
    		$posterId = $_POST['posterId'];
    		OrdersAR::model()->setPoster($orderId, $posterId);
    		$arr=array('success'=>'1');
			echo json_encode($arr);
    	}else{
    		$arr=array('success'=>'0');
			echo json_encode($arr);
    	}
    }
    /*
    	批量设置派送人员
    */
    public function actionBatSetPosters(){
    	if(isset($_POST['orderIds']) && isset($_POST['posterId'])){
    		$orderIds = $_POST['orderIds'];
    		$posterId = $_POST['posterId'];
    		foreach ($orderIds as $orderId) {
    			OrdersAR::model()->setPoster($orderId, $posterId);
    		}
    		$arr=array('success'=>'1');
			echo json_encode($arr);
    	}else{
    		$arr=array('success'=>'0');
			echo json_encode($arr);
    	}
    }

    public function actionChoosePosterForm()
    {

        $model = new ChoosePosterForm;

        // uncomment the following code to enable ajax-based validation
        /*
        if(isset($_POST['ajax']) && $_POST['ajax']==='posters-ar-ChoosePosterForm-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
        */

        if(isset($_POST['ChoosePosterForm']))
        {
            $model->attributes=$_POST['ChoosePosterForm'];
            if($model->validate())
            {
            	$model->poster;
                // form inputs are valid, do something here
                return;
            }
        }
        $posters = PostersAR::model()->getWorkPosters($this->userID);
        $posterViews = array();
        foreach ($posters as $poster)
        {
           array_push($posterViews, "id:".$poster->id." "."name:".$poster->name." 电话：".$poster->phone.count($posters).$this->userID);
        }
        $this->renderPartial('_posters', array('model'=>$model, 'posterViews'=>$posterViews));
    }

    //修改订单头
    public function initModifyOrderHeaderForm(){
    	 $model = new ModifyOrderHeaderForm;
    	 $this->renderPartial('_orderHeaderForm', array('model'=>$model));
    }
    function inject_check($sql_str) { 
    	return preg_match('%select|insert|and|or|update|delete|\'|\/\*|\*|\.\.\/|\.\/|union|into|load_file|outfile%i', $sql_str);
	}
	public function actionModifyOrderHeaderForm()
    {
    	require "HtmLawed.php";
    	if(isset($_POST['orderId'])&&isset($_POST['orderName'])
    		&&isset($_POST['phone'])&&isset($_POST['desc'])&&isset($_POST['total'])){
    		$orderId = $_POST['orderId'];
    		$name = $_POST['orderName'];
    		$phone = $_POST['phone'];
    		$desc = $_POST['desc'];
    		$total = $_POST['total'];
    		if($this->inject_check($name)){
    			$arr=array('success'=>'2');
				echo json_encode($arr);
				exit;
    		}
    		if($this->inject_check($desc)){
    			$arr=array('success'=>'2');
				echo json_encode($arr);
				exit;
    		}
    		if($this->inject_check($phone)){
    			$arr=array('success'=>'2');
				echo json_encode($arr);
				exit;
    		}
    		$config = array('safe'=>1, "elements"=>"-*");
    		$desc = htmLawed($desc, $config);
    		$name = htmLawed($name, $config);
    		$phone = htmLawed($phone, $config);
    		
    		$result = OrdersAR::model()->headerModify($orderId, $name, $phone, $desc, $total);
    		if($result){
    			$arr=array('success'=>'1');
				echo json_encode($arr);
				exit;
    		}else{
    			$arr=array('success'=>'0');
				echo json_encode($arr);
				exit;
    		}
    		
    	}else{
    		$arr=array('success'=>'0');
			echo json_encode($arr);
    	}
    }
    //添加订单子项
    public function initOrderAddItemForm(){
    	 $model = new OrderAddItemForm;
    	 $this->renderPartial('_orderAddItemForm', array('model'=>$model));
    }
	public function actionOrderAddItemForm()
    {
    	if(isset($_POST['orderId'])&&isset($_POST['productId'])&&isset($_POST['num'])){
    		$orderId = $_POST['orderId'];
    		$productId = $_POST['productId'];
    		$num = $_POST['num'];
    		$sellerid = $this->getUserId();
    		$result = OrderItemsAR::model()->createItem($sellerid, $orderId, $productId, $num);
    		if($result =="ok"){
    			$price = ProductsAR::model()->findByPk($productId)->price;
    			$total = OrdersAR::model()->findByPk($orderId)->total;
    			$total = $total + (float)$price * (float)$num;
    			OrdersAR::model()->setOrderTotal($orderId, $total);
    			$arr=array('success'=>'1');
				echo json_encode($arr);
    		}else{
    			$arr=array('success'=>'0', 'error'=>$result);
				echo json_encode($arr);
    		}
    		
    	}else{
    		$arr=array('success'=>'0', 'error'=>'网络错误');
			echo json_encode($arr);
    	}
    }

    /*
    	获取区域
    */
    public function actionFetchAreas(){
    	$userId = $this->getUserId();
    	$areas = DistrictsAR::model()->getUndeletedDistrictsByUserId($userId);
    	$result = array();
    	foreach ($areas as $area) {
    		array_push($result, array('id'=>$area->id, 'name'=>$area->name));
    	}
    	$arr=array('success'=>'0', 'area'=>$result);
    	echo json_encode($arr);
    }

    /*
    	获取商家id
    */
    public function getUserId(){
    	 if(!empty(Yii::app()->user->sellerId)){
    	 	$userId = Yii::app()->user->sellerId;
    	 	return $userId;
    	 }else{
    	 	 $url = Yii::app()->createUrl('accounts/login/login');
	    	 $this->redirect($url);
	    	 exit;
    	 }
    	
    }

    /*
		测试接口
    */
	public function actionHongTest(){
		OrdersAR::model()->getOrderNo(0, 9032222, null);
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}