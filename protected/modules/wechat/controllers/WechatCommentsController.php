<?php
class WechatCommentsController extends Controller{

	public $defaultAction = "comment";

	public function actionComment(){
		if(isset($_POST['store_id']) && isset($_POST['open_id']) && isset($_POST['comment'])){
			$store = StoreAR::model()->findByPK($_POST['store_id']);
			if($store){
				$member = MembersAR::model()->find('seller_id=:sellerId and openid=:openid',
													  array(':sellerId'=>$store->seller_id,
													  		':openid'=>$_POST['open_id']));
				if($member){
					$comment = new CommentsAR();
					$comment->member_id = $member->id;
					$comment->store_id  = $store->id;
					$comment->comment   = $_POST['comment'];
					$comment->anonymous = 0;
					if($comment->save()){
						$mq = new MsgQueueAR();
						$mq->seller_id = $store->seller_id;
						$mq->msg_id    = $comment->attributes['id'];
						$mq->type      = Constants::MSG_COMMENT;
						$mq->save();
					}
				}
			}
		}else{
			throw new CHttpException(403, "Error Processing Request");
		}
	}

}