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
    public $test = 0;

	public function actionOrderFlow()
	{
		$this->render('orderFlow');
	}
	/*
		初始化header订单数
	*/
	public function init(){
		$date = date("Y-m-d H:i:s");
		$place = null;
		$this->userID = Yii::app()->user->sellerId;
		//TODO when $userID is null
		$orders = OrdersAR::model()->filterNotSend($this->userID, $date, $place);
		$orders1 = OrdersAR::model()->filterSended($this->userID, $date, $place);
		$orders2 = OrdersAR::model()->filterCancel($this->userID, $date, $place);
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
		$place = null;
		$orders = OrdersAR::model()->filterNotSend($this->userID, $date, $place);
		return $this->renderPartial('_orderList', array('orders'=>$orders), true, false);
	}

	/*
		ajax未派送订单
	*/
	public function actionNotSend(){
		$day = 0;
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$place = null;
		$orders = OrdersAR::model()->filterNotSend($this->userID, $date, $place);
		echo $this->renderPartial('_orderList', array('orders'=>$orders), true, false);
	}
	/*
		ajax获取已派送订单
	*/
	public function actionSended(){
		$day = 0;
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$place = null;
		$orders = OrdersAR::model()->filterSended($this->userID, $date, $place);
		echo $this->renderPartial('_orderList', array('orders'=>$orders), true, false);
	}

	/*
		ajax获取已取消订单
	*/
	public function actionCancel(){
		$day = 0;
		if(isset($_POST['day'])){
			$day = $_POST['day'];
		}
		$date = date("Y-m-d H:i:s",strtotime($day." day"));
		$place = null;
		$orders = OrdersAR::model()->filterCancel($this->userID, $date, $place);
		echo $this->renderPartial('_orderList', array('orders'=>$orders), true, false);
	}
	
	/*
		ajax获取订单子项
	*/
	public function actionGetOrderItems(){
		$orderId = null;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
		}
		$orderItems = orderItemsAR::model()->getItems($orderId);
		$order = ordersAR::model()->getOrder($orderId);
		if(empty($order)){
			echo "没有订单数据";
		}else{
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
		}
		$orderItems = ordersAR::model()->cancelOrder($this->userID, $orderId);
	}
	/*
		完成订单
	*/
	public function actionfinishOrder(){
		$orderId = 0;
		if(isset($_POST['orderId'])){
			$orderId = $_POST['orderId'];
		}
		$orderItems = ordersAR::model()->finishOrder($this->userID, $orderId);	
	}

	/*
		定期更新数据
	*/
	public function actionUpdate(){
		$userID = $this->userID;
		$timeOut = 20;
		$existList = null;
		$nums = null;
		$date = date('Y-m-d H:i:s');
		$place = null;
		$filter = "";
		if(isset($_POST['time'])){
			$timeOut = $_POST['time'];
		}	
		if(isset($_POST['existList'])){
			$existList = $_POST['existList'];
		}
		if(isset($_POST['filter'])){
			$filter = $_POST['filter'];
		}
		if(isset($_POST['nums'])){
			$nums = $_POST['nums'];
		}
		$this->test = $nums[0];
		$this->updateListener($userID, $timeOut, $existList, $nums, $date, $place, $filter);
	}

	/*
		更新接口
	*/
	public function updateListener($userID, $timeOut, $existList, $nums, $date, $place, $filter){
        set_time_limit(0);
        $index=0;
        while(true){
            usleep(600000);
            $index++;
            $currentList = OrdersAR::model()->filterOrders($userID, $date, $place, $filter);
            $notSendNum = count(OrdersAr::model()->filterNotSend($userID, $date, $place));
            $sendedNum = count(OrdersAr::model()->filterSended($userID, $date, $place));
            $cancelNum = count(OrdersAr::model()->filterCancel($userID, $date, $place));
            if(empty($existList)&&(!empty($currentList))){
                 $arr=array('success'=>'1', 'nums'=>array($notSendNum, $sendedNum, $cancelNum));
                 echo json_encode($arr);
				 exit;
            }
            if((!empty($currentList))&& (!empty($existList))){
                $count=count($currentList);
                for($tmp=0;$tmp!=$count;$tmp++){
                    if(!in_array($currentList[$tmp]->id, $existList)){
                         $arr=array('success'=>'1', 'nums'=>array($notSendNum, $sendedNum, $cancelNum));
                         echo json_encode($arr);
						 exit;
                    }
                }
                // || ($nums[1]!=strval($sendedNum)) || ($nums[2]!=strval($cancelNum))
                if(strcmp(0, $sendedNum)!=0){
                     $arr=array('success'=>'2', 'nums'=>array($notSendNum, $sendedNum, $cancelNum));
                     echo json_encode($arr);
					 exit;
                }
            }
            if($index==$timeOut){
                $arr=array('success'=>'0', 'data'=>array());
                echo json_encode($arr);
                exit;
            }
        }
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
    			$posterViews[$poster->id] = $poster->name." 电话：".$poster->phone.count($posters).$this->userID;
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
    	}else{

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