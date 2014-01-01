<?php

class MessageController extends Controller{

	public $defaultAction = "load";

	function actionLoad(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in first");
		}else{
			$sellerId = Yii::app()->user->sellerId;
			$mqs = MsgQueueAR::model()->getMsgsBySellerId($sellerId);
			$msgs = array('system'=>array(), 'orders'=>array(), 'wcmsgs'=>array());
			foreach ($mqs as $mq) {
				switch ($mq->type) {
					case 0:
						# system messages
						
						break;
					case 1:
						# order messages
						$ordermsg = OrdermsgsAR::model()->findByPK($mq->msg_id);
						if($ordermsg){
							if(isset($msgs['orders']['' + $ordermsg->store_id])){
								$msgs['orders']['' + $ordermsg->store_id] ++;
							} else{
								$msgs['orders']['' + $ordermsg->store_id] = 1;
							}
						}
						break;
					case 2:
						# wechat messages
						
						break;
					default:
						# code...
						
						break;
				}
			}
			echo json_encode($msgs);
		}
	}

	function actionRedirect($type=-1, $sid=-1){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in first");
		}else{
			switch ($type) {
				case 0:
					// system messages
					
					break;
				case 1:
					// order messages
					
					break;
				case 2:
					// wechat messages

					break;
				default:
					# code...
					break;
			}
		}
	}
}