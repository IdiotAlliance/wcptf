<?php
date_default_timezone_set("Asia/Shanghai");

class ServiceController extends Controller{
	public function actionLogin(){
		if(Yii::app()->request->isPostRequest && isset($_POST['username']) && isset($_POST['password'])){
			$uname = base64_decode($_POST['username']);
			$pword = base64_decode($_POST['password']);
			if($uname && $pword){
				$user = UsersAR::model()->find('email=:uname', array(':uname'=>$uname));
				if($user && $user->password == md5($pword)){
					$star = ServiceTokenAR::model()->find("username=:uname AND expire>:time",
												  	 array(":uname"=>$uname, ":time"=>date('Y-m-d H:i:s')));
					$result = "";
					// get service access token
					if($star){
						$result .= (Constants::REQ_OK.';'.$star->token);
					}else{
						$star = new ServiceTokenAR();
						$star->username = $uname;
						$star->token    = SeriesGenerator::generateMemberKey();
						// the token expires in 2 days
						$tomorrow = mktime(date('H'), date('i'), date('s'), date('m'), date('d') + 2, date('Y'));
						$star->expire = date('Y-m-d H:i:s', $tomorrow);
						$star->save();
						$result .= Constants::REQ_OK.';'.$star->token;
					}
					// get store list
					$stores = StoreAR::model()->findAll("seller_id=:sid AND deleted<>1",
														array(":sid"=>$user->id));
					if($stores && count($stores) > 0){
					$storearr = array();
						foreach ($stores as $store) {
							array_push( $storearr,  
										array('sid' => $store->id, 
										  'uid' => $store->seller_id,
										  'name' => $store->name,
										  'type' => $store->type,
										  'deleted' => $store->deleted
										)
							);
						}
						$result .= (';'.json_encode($storearr));
					}
					echo $result;
					return;
				}
			}
			echo Constants::ERR_UNAME_PWORD;
		}else{
			throw new CHttpException(403, "Request Forbidden");
		}
	}

	public function actinoLoad(){
		if(isset($_GET['username']) && isset($_GET['token'])){
			$uname = $_GET['username'];
			$token = $_GET['token'];
			$time  = $_GET['time'];
			$star  = ServiceTokenAR::model()->find("username=:uname AND token=:token",
												   array(":uname"=>$uname, ":token"=>$token));
			if($star){
				if($star->expire > date('Y-m-d H:i:s')){
					$user = UsersAR::model()->find('email=:uname', array(":uname"=>$uname));
					$orders = OrdersAR::model()->getOrdersAfter($user->id, date('Y-m-d H:i:s', $time));
					echo (Constants::REQ_OK.';'.json_encode($orders));
				}else{
					echo Constants::ERR_TOKEN_EXPIRE;
				}
			}else{
				echo Constants::ERR_INVALID_TOK;
			}
		}else{
			echo Constants::REQ_INVALID_ARG;
		}
	}

	public function actionSend(){

	}

	public function actionCancel(){

	}

	public function actionDone(){

	}

	public function actionUpdateToken(){

	}
}