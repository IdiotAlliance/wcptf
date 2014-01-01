<?php

class MessageController extends Controller{

	public $defaultAction = "load";

	function actionLoad(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "");
		}else{
			$sellerId = Yii::app()->user->sellerId;
			$mqs = MsgQueueAR::model()->getMsgsBySellerId($sellerId);
			foreach ($mqs as $mq) {
				switch ($mq->type) {
					case 0:
						# system messages
						
						break;
					case 1:
						# order messages
						
						break;
					case 2:
						# wechat messages
						
						break;
					default:
						# code...
						
						break;
				}
			}
		}
	}
}