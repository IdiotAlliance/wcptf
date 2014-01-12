<?php

class MessageController extends Controller{

	public $defaultAction = "load";

	function actionLoad(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in first");
		}else{
			$sellerId = Yii::app()->user->sellerId;
<<<<<<< HEAD
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
=======
			$system  = MsgQueueAR::model()->getCountByType($sellerId, Constants::MSG_SYSTEM);
			$orders  = MsgQueueAR::model()->getCountByType($sellerId, Constants::MSG_ORDERS);
			$wechat  = MsgQueueAR::model()->getCountByType($sellerId, Constants::MSG_WECHAT);
			$comment = MsgQueueAR::model()->getCountByType($sellerId, Constants::MSG_COMMENT);
			$msgs = array();
			if($system) $msgs['system'] = $system[0]['count'];
			if($orders) {
				$msgs['orders'] = array();
				foreach ($orders as $o) {
					$msgs['orders'][$o['sid']] = $o['count'];
				}
			}
			if($wechat) $msgs['wcmsgs'] = $wechat[0]['count'];
			if($comment) {
				$msgs['comments'] = array();
				foreach ($comment as $c) {
					$msgs['comments'][$c['sid']] = $c['count'];
>>>>>>> origin/master
				}
			}
			echo json_encode($msgs);
		}
	}

	function actionRedirect($type=-1, $sid=-1){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in first");
		}else{
<<<<<<< HEAD
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
=======
			$uid = Yii::app()->user->sellerId;
			switch ($type) {
				case Constants::MSG_SYSTEM:
					// system messages
					
					break;
				case Constants::MSG_ORDERS:
					// order messages
					$mqids = MsgQueueAR::model()->getOrderItemsByUserAndStoreId($uid, $sid);
					foreach ($mqids as $mqid) {
						$mq = MsgQueueAR::model()->findByPK($mqid['mqid']);
						if($mq) $mq->delete();
					}
					// delete corresponding ordermsgs
					OrdermsgsAR::model()->deleteAll('store_id=:sid', array(':sid'=>$sid));
					$this->redirect(Yii::app()->createUrl('takeAway/orderFlow/orderFlow?sid=').$sid);
					break;
				case Constants::MSG_WECHAT:
					// wechat messages
					
					break;
				case Constants::MSG_COMMENT:
					// comments
					// clear comment msg_queue items
					$mqs = MsgQueueAR::model()->getCommentItemsByUserAndStoreId($uid, $sid);
					if($mqs){
						foreach ($mqs as $mq) {
							$mqitem = MsgQueueAR::model()->findByPK($mq['mqid']);
							$mqitem->delete();
						}
					}
					$this->redirect(Yii::app()->createUrl('takeAway/members/members?sid=').$sid);
					break;
				default:
					$this->redirect(Yii::app()->createUrl(''));
>>>>>>> origin/master
					break;
			}
		}
	}
}