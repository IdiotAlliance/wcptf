<?php
include 'TakeAwayController.php';

class MembersController extends TakeAwayController{
	
	public $layout = "/layouts/main";
	public $defaultAction = "members";
	
	function actionMembers(){
		
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else if(isset($_GET['sid']) && $_GET['sid'] >= 0 && $this->setCurrentStore($_GET['sid'])){

			$sid      = $_GET['sid'];
			$sellerId = Yii::app()->user->sellerId;

			// clear comment msg_queue items
			$mqs = MsgQueueAR::model()->getCommentItemsByUserAndStoreId($sellerId, $sid);
			if($mqs){
				foreach ($mqs as $mq) {
					$mqitem = MsgQueueAR::model()->findByPK($mq['mqid']);
					$mqitem->delete();
				}
			}

			$members  = MembersAR::model()->getMembersBySellerIdOrderByComment($sellerId);
			$orders   = OrdersAR::model()->getOrdersCountBySellerId($sellerId);
			$comments = CommentsAR::model()->getCommentsCountBySellerId($sellerId);
			$bounds   = MemberBoundAR::model()->getBoundByStoreId($sid);
			$requests = MemberNumbersAR::model()->getVerifiedNumbersByStoreId($sid);
			$model    = array();
			$i = 0;
			$total = 0;
			$sub   = 0;
			$unsub = 0;
			foreach ($members as $member){
				$model[$i]['id'] = $member->id;
				$model[$i]['openid'] = $member->openid;
				$model[$i]['credits'] = $member->credits;
				$model[$i]['unsubscribed'] = $member->unsubscribed;
				$model[$i]['ctime'] = $member->ctime;
				$model[$i]['latest_comment'] = $member->latest_comment;
				$model[$i]['order_count'] = 0;
				$model[$i]['comment_count'] = 0;
				$total ++;
				if($member->unsubscribed)
					$unsub ++;
				else
					$sub ++;
				
				foreach ($orders as $order){
					if($order['member_id'] == $member->id){
						$model[$i]['order_count'] = $order['order_count'];
						break;
					}
				}
				
				foreach ($comments as $comment){
					if($comment['member_id'] == $member->id){
						$model[$i]['comment_count'] = $comment['comment_count'];
						break;
					}
				}

				foreach ($bounds as $bound) {
					if($bound->member_id == $member->id){
						$model[$i]['bound']  = 1; // this member is bound to the current store
						$model[$i]['cardno'] = $bound->cardno;
						$model[$i]['credit'] = $bound->credit;
						$model[$i]['phone']  = $bound->phone;
					}
				}

				foreach ($requests as $request) {
					if($request->member_id == $member->id && !isset($model[$i]['bound'])){
						$model[$i]['request'] = 1;
						$model[$i]['cardno']  = $request->cardno;
						$model[$i]['phone']   = $request->number;
					}
				}
				$i ++;
			}
			$stats = array(
				'total'=>$total, 'sub'=>$sub, 'unsub'=>$unsub,
				'bound'=>count($bounds), 'request'=>count($requests),
			);
			$this->render('members', array('model'=>$model, 'stats'=>$stats));
		}
	}
	
	function actionGetHistory($memberId){
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else if(isset($_GET['sid']) && $_GET['sid'] >= 0){
			$sid = $_GET['sid'];
			$userId = Yii::app()->user->sellerId;
			$dbmember = MembersAR::model()->findByPK($memberId);
			if($dbmember){
				$dborders = OrdersAR::model()->getOrdersByMemeberId($memberId);
				$dbcomments = CommentsAR::model()->getCommentsByMemberId($memberId);
				//$dbmessages = WechatmsgsAR::model()->getMessages($userId, $dbmember->openid);
				$bound    = MemberBoundAR::model()->getBoundByStoreAndMember($sid, $memberId);
				$request  = MemberNumbersAR::model()->getRequest($sid, $memberId);

				$member = array(
					'id'=>$dbmember->id,
					'wxnickname'=>$dbmember->wxnickname,
					'openid'=>$dbmember->openid,
					'ctime'=>$dbmember->ctime,
					'credits'=>$dbmember->credits,
					'unsubscribed'=>$dbmember->unsubscribed,
					);
				if($bound){
					$member['bound'] = 1;
					$member['cardno'] = $bound->cardno;
					$member['phone'] = $bound->phone;
				} else if($request){ 
					$member['request'] = 1;
					$member['cardno'] = $request->cardno;
					$member['phone'] = $request->number;
				}

				$orders = array();
				$comments = array();
				
				$i = 0;
				foreach ($dborders as $order){
					$orders[$i]['id'] = $order->id;
					$orders[$i]['order_no'] = $order->order_no;
					$orders[$i]['status'] = $order->status;
					$orders[$i]['ctime'] = $order->ctime;
					$orders[$i]['price'] = $order->total;
					$orders[$i]['items'] = OrderItemsAR::model()->generateItems($order->id);
					$i ++;
				}
				$i = 0;
				foreach ($dbcomments as $comment){
					$comments[$i]['id'] = $comment->id;
					$comments[$i]['ctime'] = $comment->ctime;
					$comments[$i]['comment'] = $comment->comment;
					$comments[$i]['status'] = $comment->status;
					$i ++;
				}

				$data = array(
					'member'=>$member,
					'orders'=>$orders,
					'comments'=>$comments,
				);
				echo json_encode($data);
			}else{
				throw new CHttpException(404, "Requested member is not found");
			}
		} else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
	}
	
	function actionConfirmMember($memberId){
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else if(isset($_GET['sid']) && $_GET['sid'] >= 0){
			$sid = $_GET['sid'];
			$request = MemberNumbersAR::model()->getRequest($sid, $memberId);
			if($request){
				$bound = new MemberBoundAR();
				$bound->member_id = $request->member_id;
				$bound->store_id  = $sid;
				$bound->cardno = $request->cardno;
				$bound->phone  = $request->number;
				$bound->save();
				if($bound->attributes['id'] >= 0){
					$request->delete();
					echo 'ok';
					exit();
				}
			}
			echo "fail";
		}
	}

	function actionDownloadExcel($memberId){
		if($memberId){
			// 从数据库中获取数据
			$data = array();
			$orders = OrdersAR::model()->getOrdersByMemeberId($memberId);
			$data['orders'] = $orders;
			$data['memberid'] = $memberId;
			
			// 首先创建文件
			ExcelGenerator::generateOrderExcelForMember($data);
			
			// 将请求跳转到对应的文件链接
			
		}
	}
}