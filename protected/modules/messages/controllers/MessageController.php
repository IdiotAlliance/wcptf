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
					case 3:
						# comments
						
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
			$uid = Yii::app()->user->sellerId;
			switch ($type) {
				case 0:
					// system messages
					
					break;
				case 1:
					// order messages
					$mqids = MsgQueueAR::model()->getOrderItemsByUserAndStoreId($uid, $sid);
					foreach ($mqids as $mqid) {
						$mq = MsgQueueAR::model()->findByPK($mqid['mqid']);
						if($mq) $mq->delete();
					}
					OrdermsgsAR::model()->deleteAll('store_id=:sid', array(':sid'=>$sid));
					$this->redirect(Yii::app()->createUrl('takeAway/orderFlow/orderFlow?sid=').$sid);
					break;
				case 2:
					// wechat messages

					break;
				default:
					$this->redirect(Yii::app()->createUrl(''));
					break;
			}
		}
	}
}