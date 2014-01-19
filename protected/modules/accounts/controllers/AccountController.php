<?php
/**
 * @author lvxiang
 */
class AccountController extends Controller{

	public $currentPage = null;
	public $layout = 'account';
	public $defaultAction = "stores";
	public $typeAtrributes    = array('type_name', 'type_description', 'pic_url');

	// public $productAttributes = ['pname', 'price', 'credit', 'description', 
	// 							 'stime', 'etime', 'status', 'instore', 'richtext', 
	// 							 'cover'];
	// public $districtAttributes = ['name', 'description'];
	// public $posterAttributes   = ['name', 'phone', 'description'];

	public function actions()
    { 
            return array( 
                    // captcha action renders the CAPTCHA image displayed on the contact page
                    'captcha'=>array(
                            'class'=>'CCaptchaAction',
                            'backColor'=>0xFFFFFF, 
                            'maxLength'=>'4',       // 最多生成几个字符
                             'minLength'=>'4',       // 最少生成几个字符
                           'height'=>'40'
                    ), 
            ); 
    }


	public function actionStores(){
		$this->pageTitle = "店铺管理";
		if(Yii::app()->user->isGuest){
			$this->redirect('index.php/accounts/login');
		}else{
			$this->currentPage = 'stores';
			$errmsg = null;
			// edit store name
			if(isset($_POST['EditStoreForm'])){
				// var_dump(123);
				// exit();
				$uid = Yii::app()->user->sellerId;
				$model = new EditStoreForm();
				$model->attributes = $_POST['EditStoreForm'];
				$store = StoreAR::model()->findByPK($model->sid); 
				if($store && !StoreAR::model()->nameExsits($uid, $model->newname)){
					$store->name = $model->newname;
					$store->update();
				}else{
					$errmsg = "修改失败，店铺名称不能重复";
				}
			}
			if(isset($_POST['DeleteStoreForm'])){
				$uid = Yii::app()->user->sellerId;
				$user  = UsersAR::model()->findByPK($uid);
				$model = new DeleteStoreForm();
				$model->attributes = $_POST['DeleteStoreForm'];
				if(md5($model->pass) == $user->password){
					$store = StoreAR::model()->findByPK($model->sid);
					if($store){
						$store->deleted = 1;
						$store->update();
					}else{
						$errmsg = "指定的店铺不存在";
					}
				}else{
					$errmsg = "密码错误，无法删除店铺";
				}
			}
			$editForm = new EditStoreForm();
			$deleteForm = new DeleteStoreForm();
			$uid = Yii::app()->user->sellerId;
			$user   = UsersAR::model()->findByPK($uid);
			$stores = StoreAR::model()->getUndeletedStoreByUserId($uid);

			$this->render("stores", array('user'=>$user, 
										   'stores'=>$stores, 
										   'editForm'=>$editForm,
										   'deleteForm'=>$deleteForm,
										   'errmsg'=>$errmsg));

		}
	}

	public function actionCreateStore(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must log in to take this operation");
		}else{
			if(isset($_POST['name']) && isset($_POST['type'])){
				$uid    = Yii::app()->user->sellerId;
				$stores = StoreAR::model()->getStoreByUserId($uid);
				foreach ($stores as $store) {
					if($store->name == $_POST['name']){
						echo json_encode(array('result'=>1));
						exit;
					}
				}
				$store = new StoreAR();
				$store->name = $_POST['name'];
				$store->type = $_POST['type'];
				$store->seller_id = $uid;
				$store->save();
				echo json_encode(array('result'=>0, 'sid'=>$store->id));
			}else{
				throw new CHttpException(403, "Error Processing Request, Illegal Arguments");
			}
		}
	}

	public function actionCopy(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must log in to take this operation");
		}else{
			if(isset($_POST['src']) && isset($_POST['dst'])){
				$src = StoreAR::model()->findByPK($_POST['src']);
				$dst = StoreAR::model()->findByPK($_POST['dst']);
				if($src && $dst && ($src->type == $dst->type)){
					if(isset($_POST['info']) && $_POST['info'] == 1){
						$dst->broadcast = $src->broadcast;
						$dst->stime     = $src->stime;
						$dst->etime     = $src->etime;
						$dst->phone     = $src->phone;
						$dst->address   = $src->address;
						$dst->logo      = $src->logo;
						$dst->update();    
					}
					if(isset($_POST['prod']) && $_POST['prod'] == 1){
						$types = ProductTypeAR::model()->getUndeletedProductTypeByStoreId($src->id);
						foreach ($types as $type) {
							$oldid = $type->id;
							$type->isNewRecord = true;
							$type->store_id = $dst->id;
							unset($type->id);
							$type->save();
							
							$products = ProductsAR::model()->getUndeletedProductsByProductType($oldid);
							foreach ($products as $product) {
								$product->isNewRecord = true;
								$product->store_id = $dst->id;
								$product->type_id  = $type->id;
								unset($product->id);
								$product->save();
							}
						}
					}
					if(isset($_POST['tkaw']) && $_POST['tkaw'] == 1){
						$dst->start_price    = $src->start_price;
						$dst->takeaway_fee   = $src->takeaway_fee;
						$dst->threshold      = $src->threshold;
						$dst->estimated_time = $src->estimated_time;
						$dst->update();
					}
					if(isset($_POST['dist']) && $_POST['dist'] == 1){
						$districts = DistrictsAR::model()->getUndeletedDistrictsByStoreId($src->id);
						foreach ($districts as $district) {
							$district->isNewRecord = true;
							$district->store_id = $dst->id;
							unset($district->id);
							$district->save();
						}
					}
					if(isset($_POST['post']) && $_POST['post'] == 1){
						$posters = PostersAR::model()->getUndeletedPostersByStoreId($src->id);
						foreach ($posters as $poster) {
							$poster->isNewRecord = true;
							$poster->store_id = $dst->id;
							unset($poster->id);
							$poster->save();
						}
					}
					echo json_encode(array('result'=>0));
				}else{
					throw new CHttpException(403, "Error Processing Request, Illegal Arguments");
				}
			}else{
				throw new CHttpException(403, "Error Processing Request, Illegal Arguments");
			}
		}
	}

	public function actionProfile(){
		if(Yii::app()->user->isGuest){
			$this->redirect(Yii::app()->createUrl('accounts/login/login'));
		}
		else{
			$this->currentPage = 'profile';
			$uid = Yii::app()->user->sellerId;
			$user = UsersAR::model()->findByPK($uid);
			if($user){
				$stats  = OrdersAR::model()->getOrderStats($uid);
				$bills  = BillsAR::model()->getBills($uid, 1, 8);
				foreach ($bills as $bill) {
					switch ($bill->type) {
						case Constants::BILL_TYPE_NORMAL:
							$bill->type = "系统日常维护费用";
							break;
						case Constants::BILL_TYPE_SMS:
							$bill->type = "短信服务费用，共发送1条，每条0.1元";
							break;
						case Constants::BILL_TYPE_PLUGIN:
							$bill->type = "购买插件费用";
							break;
						case Constants::BILL_TYPE_PREPAID:
							$bill->type = "充值卡充值成功";
							break;
						default:
							# code...
							break;
					}
				}
				$bcount = BillsAR::model()->count('seller_id=:uid', array(':uid'=>$uid));
				$pcount = ($bcount % 8 == 0) ? ($bcount / 8) : (floor(($bcount / 8)) + 1);
				$sysmsgs   = $this->sysmsgsToArray(SystemmsgsAR::model()->getMsgsAfter($uid, 0, 10));
				$model  = array('account'=>$user->email, 'wechat_name'=>$user->wechat_name,
							   'balance'=>$user->balance, 'stats'=>$stats);
				$this->render('profile', array('model'=>$model, 'bills'=>$bills, 
							  'bcount'=>$bcount, 'pcount'=>$pcount, 'sysmsgs'=>$sysmsgs));
			}
		}
	}

	public function actionGetBills($page){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in to use this service");
		}else{
			$uid = Yii::app()->user->sellerId;
			if($page > 0){
				$bills = BillsAR::model()->getBills($uid, $page, 8);
				$result = array();
				for($index = ($page - 1) * 8; $index < count($bills); $index ++)
					array_push($result, array('id'=>$bills[$index]->id,
											  'flowid'=>$bills[$index]->flowid,
											  'type'=>$this->getBillType($bills[$index]->type),
											  'income'=>$bills[$index]->income,
											  'payment'=>$bills[$index]->payment,
											  'balance'=>$bills[$index]->balance,
											  'ctime'=>$bills[$index]->ctime));
				echo json_encode($result);
			}
		}
	}

	public function actionBillDetail($bid){
		$bill = BillsAR::model()->findByPK($bid);
		if($bill){
			$result = array('id' => $bill->id, 'flowid'=>$bill->flowid, 
							'type'=>$this->getBillType($bill->type), 'income'=>$bill->income, 
							'payment'=>$bill->payment, 'ctime'=>$bill->ctime,
							'balance'=>$bill->balance);
			switch ($bill->type) {
				case Constants::BILL_TYPE_NORMAL:
					$result['info'] = "系统日常维护费用";
					break;
				case Constants::BILL_TYPE_SMS:
					$result['info'] = "短信服务费用，共发送1条，每条0.1元";
					break;
				case Constants::BILL_TYPE_PLUGIN:
					$result['info'] = "购买插件费用";
					break;
				case Constants::BILL_TYPE_PREPAID:
					$result['info'] = "充值卡充值成功";
					break;
				default:
					# code...
					break;
			}
			echo json_encode($result);
		}
	}

	public function actionLoadSysmsgs($before){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in to use this service");
		}else{
			$uid = Yii::app()->user->sellerId;
			$sysmsgs = $this->sysmsgsToArray(SystemmsgsAR::model()->getMsgsBefore($uid, $before, 10));
			echo json_encode($sysmsgs);
		}
	}

	public function actionCheckCard(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in to use this service");
		}else if(Yii::app()->request->isPostRequest){
			if(isset($_POST['card_no']) && isset($_POST['card_pass']) && isset($_POST['timestamp'])){
				$no    = $_POST['card_no'];
				$pass  = $_POST['card_pass'];
				$time  = $_POST['timestamp'];
				$card  = PrepaidCardAR::model()->find('card_no=:cno AND password=:pword AND is_use<>1',
													  array(':cno'=>$no, ':pword'=>$pass));
				if($card){
					$ctime = time();
					$signature = md5($no.$pass.$time.$ctime);
					$result = array('success'=>'1', 'time'=>$ctime, 'signature'=>$signature,
									'value'=>$card->value, 'duetime'=>$card->duetime);
					$card->signature = $signature;
					$card->update();
					echo json_encode($result);
				}else{
					$result = array('success'=>'0', 'error'=>'PR_0001', 'info'=>'您输入的卡号或密码无效，请检查您的输入是否正确');
					echo json_encode($result);
				}
			}
		}
	}

	public function actionDeposite(){
		if(Yii::app()->user->isGuest){
			throw new CHttpException(403, "You must sign in to use this service");
		}else if(Yii::app()->request->isPostRequest){
			$uid = Yii::app()->user->sellerId;
			if(isset($_POST['card_no']) && isset($_POST['card_pass']) 
				&& isset($_POST['ctime']) && isset($_POST['stime'])){
				$cardno    = $_POST['card_no'];
				$cardpass  = $_POST['card_pass'];
				$stime     = $_POST['stime'];
				$ctime     = $_POST['ctime'];
				$signature = md5($cardno.$cardpass.$ctime.$stime);
				$card = PrepaidCardAR::model()->find('card_no=:cno AND password=:pword AND is_use<>1 AND signature=:sig',
													  array(':cno'=>$cardno, ':pword'=>$cardpass, ':sig'=>$signature));
				if($card){
					$user = UsersAR::model()->findByPK($uid);
					$user->balance = $user->balance + $card->value;
					$user->update();
					$card->is_use = 1;
					$card->update();

					$bill = new BillsAR();
					$bill->income    = $card->value;
					$bill->type      = Constants::BILL_TYPE_PREPAID;
					$bill->reference = $card->id;
					$bill->seller_id = $uid;
					$bill->payment   = 0;
					$bill->balance   = $user->balance;
					$bill->flowid    = date('Ymd', time()).(time() % 86400000);
					$bill->save();
					echo json_encode(array('success'=>'1'));
				}else{
					echo json_encode(array('success'=>'0', 'info'=>'充值失败，无法确认您的充值卡的有效性，请重试'));
				}
			}
		}
	}

	public function getBillType($type){
		switch ($type) {
			case Constants::BILL_TYPE_NORMAL:
				return '日常维护费用';
			case Constants::BILL_TYPE_SMS:
				return '短信服务支出';
			case Constants::BILL_TYPE_PLUGIN:
				return '插件购买费用';
			case Constants::BILL_TYPE_PREPAID:
				return '账户充值';
			default:
				# code...
				break;
		}
		return null;
	}

	public function sysmsgsToArray($msgs){
		if($msgs){
			$msgarr = array();
			foreach ($msgs as $msg) {
				if(!$msg->read){
					$msg->read = 1;
					$msg->update();
					$mq = MsgQueueAR::model()->delete('type=:type AND msg_id=:mid',
													array(':type'=>Constants::MSG_SYSTEM, 
														  ':mid'=>$msg->id));
				}
				$info = null;
				switch ($msg->type) {
					case Constants::MSG_SYSTEM_100:
						$info = "您的账户余额已不足100元，为了保障店铺的正常运营，请尽快充值";
						break;
					case Constants::MSG_SYSTEM_50:
						$info = "您的账户余额已不足50元，为了保障店铺的正常运营，请尽快充值";
						break;
					case Constants::MSG_SYSTEM_10:
						$info = "您的账户余额已不足10元，店铺很快将会过期，请尽快充值，以免遭受不必要的损失";
						break;
					default:
						$info = "";
						break;
				}
				array_push($msgarr, array('id'=>$msg->id, 'ctime'=>$msg->ctime, 'info'=>$info));
			}
			return $msgarr;
		}
	}
}
