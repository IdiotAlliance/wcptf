<?php
include 'TakeAwayController.php';

class MembersController extends TakeAwayController{
	
	public $layout = "/layouts/main";
	public $defaultAction = "members";
	
	function actionMembers(){
		
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else{
			$sellerId = Yii::app()->user->sellerId;
			$members = MembersAR::model()->getMembersBySellerIdOrderByComment($sellerId);
			$orders  = OrdersAR::model()->getOrdersCountBySellerId($sellerId);
			$comments = CommentsAR::model()->getCommentsCountBySellerId($sellerId);
			$model   = array();
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
				$i ++;
			}
			$stats = array();
			$stats['total'] = $total;
			$stats['sub']   = $sub;
			$stats['unsub'] = $unsub;
			
			$this->render('members', array('model'=>$model, 'stats'=>$stats));
		}
	}
	
	function actionGetHistory($memberId){
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else{
			$dborders = OrdersAR::model()->getOrdersByMemeberId($memberId);
			$dbcomments = CommentsAR::model()->getCommentsByMemberId($memberId);
			$dbmember = MembersAR::model()->findByPK($memberId);
			$member = array();
			$orders = array();
			$comments = array();
			
			$member[0]['id'] = $dbmember->id;
			$member[0]['wxnickname'] = $dbmember->wxnickname;
			$member[0]['openid'] = $dbmember->openid;
			$member[0]['ctime'] = $dbmember->ctime;
			$member[0]['credits'] = $dbmember->credits;
			$member[0]['unsubscribed'] = $dbmember->unsubscribed;
			$member[0]['memberid'] = $dbmember->memberid;
			
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
				'member'=>$member[0],
				'orders'=>$orders,
				'comments'=>$comments
			);
			echo json_encode($data);
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