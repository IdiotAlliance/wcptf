<?php
class WapController extends Controller{
	
	public $layout = '/layouts/main';
	public $defaultAction = "index";

	// template function
	public function actionTemp(){
		$this->render('aqitemplate');
	}
	
	public function actionIndex(){
		
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/index\/(\d+)[?](.*)/i', $url, $matches);
		$storeid = null;
		$sellerId = null;
		$openid = null;
		$sortId = null;
		$token  = null;
		$user   = null;
		if(isset($matches[1]) &&  isset($_GET['openid']) && isset($_GET['token']) && isset($_GET['storeid'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$token = $_GET['token'];
			$storeid = $_GET['storeid'];
			if(isset($_GET['sortid']))
				$sortId = $_GET['sortid'];
		}else{
			// throw new CHttpException(404, "Error Processing Request");
		}
		if($sellerId && $openid && 
		   ($user = UsersAR::model()->getUserById($sellerId)) &&
		   ($member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openid))){
			if($user->balance <= 0){
				$this->actionNobalance();
				return;
			}
			$key = null;
			// 验证token
			if(MemberTokenAR::model()->validateToken($sellerId, $openid, $token)){
				$key = $member->wapkey;
			}
			$referer = (isset($_SERVER['HTTP_REFERER'])?1:0);
			$bound = MemberBoundAR::model()->find("store_id={$storeid} AND member_id={$member->id}");
			$this->render('index', array('key'=>$key, 'sellerId'=>$sellerId, 
										 'openId'=>$openid, 'storeid'=>$storeid, 
										 'referer'=>$referer, 'sortid'=>$sortId,
										 'wxname'=>$user->wechat_name, 
										 'vip'=>($bound?1:0)));
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
	}

	public function actionContact(){
		$user = null;
		$url  = Yii::app()->request->getUrl();
		preg_match('/.*wap\/contact\/(\d+)(.*)/i', $url, $matches);
		if(isset($matches[1]) &&
		   ($user = UsersAR::model()->find("id=:id", array(":id"=>$matches[1]))))
		{
			if(Yii::app()->request->isPostRequest){
				$sid     = $_POST['store'];
				$content = $_POST['content'];
				$mid     = $_POST['memberid'];
				if(strlen(trim($content)) > 0 && strlen(trim($content)) < 128){
					$comment = new CommentsAR();
					$comment->member_id = $mid;
					$comment->store_id  = $sid;
					$comment->comment   = $content;
					$comment->save();
					$comment = CommentsAR::model()->find("id=:cid", array(":cid"=>$comment->id));

					$mq = new MsgQueueAR();
					$mq->type = 3;
					$mq->seller_id = $matches[1];
					$mq->msg_id    = $comment->id;
					$mq->save();

					$member = MembersAR::model()->find("id=:mid", array(':mid' => $mid));
					$member->latest_comment = $comment->ctime;
					$member->save();
					$this->render('contact', array("result"=>"感谢您的热心反馈，我们会继续努力改进为您提供更好的服务！"));
				}
				else{
					$this->render('contact', array("result"=>"抱歉, 您输入的内容无效"));
				}
			}
			else if(isset($_GET['openid'])){
				$member = MembersAR::model()->find("seller_id=:sid AND openid=:oid AND unsubscribed<>1 AND deleted<>1",
												   array(":sid"=>$matches[1], ":oid"=>$_GET['openid']));
				if($member){
					$stores = StoreAR::model()->findAll("seller_id=:sid", 
														array(":sid"=>$user->id));
					$storearr = array();
					foreach ($stores as $store) {
						array_push($storearr, array("id"=>$store->id, "sname"=>$store->name));
					}
					$this->render('contact', array('sellerid' => $user->id,
												   'stores' => $storearr,
												   'memberid' => $member->id));
				}else{
					$this->render('contact', array("result"=>"抱歉，您还不能发表意见"));
				}
			} else{
				$this->render('contact', array("result"=>"抱歉，您还不能发表意见"));
			}
		}
	}

	public function actionNobalance(){
		$this->render('nobalance');
	}

	public function actionPersonal(){
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/personal\/(\d+)[?](.*)/i', $url, $matches);
		$storeid = null;
		$sellerId = null;
		$openid = null;
		$sortId = null;
		$token  = null;
		$user   = null;
		if(isset($matches[1]) &&  isset($_GET['openid']) && isset($_GET['token']) && isset($_GET['storeid'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$token = $_GET['token'];
			$storeid = $_GET['storeid'];
		}else{
			throw new CHttpException(403, "Error Processing Request");
		}
		if($sellerId && $openid && 
		   ($user = UsersAR::model()->getUserById($sellerId)) &&
		   ($member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openid))){
		   	if($user->balance <= 0){
				$this->actionNobalance();
				return;
			}
			$bindon = PluginsStoreAR::model()->find('store_id=:sid AND plugin_id=:pid',
													array(':sid'=>$storeid, ':pid'=>0))? 1 : 0;
			$key = null;
			// 验证token
			if(MemberTokenAR::model()->validateToken($sellerId, $openid, $token)){
				$key = $member->wapkey;
			}
			$referer = (isset($_SERVER['HTTP_REFERER'])?1:0);
			$this->render('personalcenter', array('key'=>$key, 'sellerId'=>$sellerId, 
										 'openId'=>$openid, 'storeid'=>$storeid, 
										 'referer'=>$referer, 'wxname'=>$user->wechat_name,
										 'memberid'=>$member->id, 'phone'=>$member->phone,
										 'bindon'=>$bindon));
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
	}

	public function actionStores(){
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/stores\/(\d+)[?](.*)/i', $url, $matches);
		$sellerId = null;
		$openid = null;
		$sortId = null;
		$token  = null;
		$user   = null;
		if(isset($matches[1]) &&  isset($_GET['openid']) && isset($_GET['token'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$token = $_GET['token'];
		}else{
			throw new CHttpException(404, "Error Processing Request");
		}
		if($sellerId && $openid && 
		   ($user = UsersAR::model()->getUserById($sellerId)) &&
		   ($member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openid))){
		   	if($user->balance <= 0){
				$this->actionNobalance();
				return;
			}
			$key = null;
			// 验证token
			if(MemberTokenAR::model()->validateToken($sellerId, $openid, $token)){
				$key = $member->wapkey;
			}
			$stores = StoreAR::model()->findAll('seller_id=:sid AND deleted<>1', array(':sid'=>$sellerId));
			$starr  = array('storelist'=>array());
			foreach ($stores as $store) {
				array_push($starr['storelist'], 
						   array('storeid'=>$store->id,
						   		 'storename'=>$store->name,
						   		 'announcement'=>$store->broadcast,
						   		 'storestatus'=>($store->status==0),
						   		 'deliveryfee'=>$store->takeaway_fee,
						   		 'sendingfee'=>$store->start_price,
						   		 'isdeliveryfree'=>($store->threshold==1),
						   		 'logo'=>(Yii::app()->request->hostInfo.Yii::app()->request->baseUrl.($store->logo?$store->logo:'/img/default-logo.jpg')),
						   		 'url'=>Yii::app()->createUrl('wap/index/')."/".$sellerId."?openid={$openid}&token={$token}&storeid={$store->id}"));
			}
			$this->render('storelist', array('key'=>$key, 'sellerId'=>$sellerId, 
										 'openId'=>$openid, 'wxid'=>$user->wechat_name, 
										 'stores'=>json_encode($starr)));
		}
	}

	public function actionReclist(){
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/reclist\/(\d+)[?](.*)/i', $url, $matches);
		$sellerId = null;
		$openid = null;
		$sortId = null;
		$token  = null;
		$user   = null;
		if(isset($matches[1]) &&  isset($_GET['openid']) && isset($_GET['token'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$token = $_GET['token'];
		}else{
			throw new CHttpException(404, "Error Processing Request");
		}
		if($sellerId && $openid && 
		   ($user = UsersAR::model()->getUserById($sellerId)) &&
		   ($member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openid))){
		   	if($user->balance <= 0){
				$this->actionNobalance();
				return;
			}
			$key = null;
			// 验证token
			if(MemberTokenAR::model()->validateToken($sellerId, $openid, $token)){
				$key = $member->wapkey;
			}
			$hots = HotProductsAR::model()->getHotIndexProductsBySellerId($sellerId);
			$hotarr = array('reclist'=>array());
			if($hots){
				foreach ($hots as $hot) {
					array_push($hotarr['reclist'], array(
						'storeid'=>$hot['sid'],
						'storename'=>$hot['sname'],
						'recname'=>$hot['pname'],
						'recdesc'=>$hot['drp'],
						'rectag'=>$hot['tag'],
						'recimg'=>(Yii::app()->request->hostInfo.Yii::app()->request->baseUrl.'/'.($hot['pic']?$hot['pic']:'img/default-type.jpg')),
						'recurl'=>Yii::app()->createAbsoluteUrl('wap/wap/index').'/'.$sellerId."?storeid={$hot['sid']}&openid={$openid}&token={$token}&sortid=".$hot['pid'],
						'url'=>Yii::app()->createAbsoluteUrl('wap/wap/index').'/'.$sellerId."?openid={$openid}&token={$token}&storeid={$hot['sid']}",
						));
				}
			}
			$this->render('reclist', array('key'=>$key, 'sellerId'=>$sellerId, 
										 'openId'=>$openid, 'wxid'=>$user->wechat_name, 
										 'hots'=>json_encode($hotarr)));
		}
	}

	public function actionPstores(){
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/pstores\/(\d+)[?](.*)/i', $url, $matches);
		$sellerId = null;
		$openid = null;
		$sortId = null;
		$token  = null;
		$user   = null;
		if(isset($matches[1]) &&  isset($_GET['openid']) && isset($_GET['token'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$token = $_GET['token'];
		}else{
			throw new CHttpException(404, "Error Processing Request");
		}
		if($sellerId && $openid && 
		   ($user = UsersAR::model()->getUserById($sellerId)) &&
		   ($member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openid))){
		   	if($user->balance <= 0){
				$this->actionNobalance();
				return;
			}
			$key = null;
			// 验证token
			if(MemberTokenAR::model()->validateToken($sellerId, $openid, $token)){
				$key = $member->wapkey;
			}
			$member  = MembersAR::model()->find("openid='{$openid}' AND seller_id={$sellerId}");
			$stores = StoreAR::model()->findAll("seller_id={$sellerId} AND deleted<>1");

			$pstorearr = array('storelist'=>array());
			foreach ($stores as $store) {
				$mtime = OrdersAR::model()->getMaxOrderTime($store->id, $member->id);
				$bound = (MemberBoundAR::model()->find("member_id={$member->id} AND store_id={$store->id}") != null);
				$phone = (MemberNumbersAR::model()->find("member_id={$member->id} AND store_id={$store->id}") != null);
				array_push($pstorearr['storelist'], 
								array(
									'storeid'=>$store->id,
									'storename'=>$store->name,
									'lastorder'=>$mtime[0]['mtime']?$mtime[0]['mtime']:'尚未下过单',
									'phonebind'=>$phone,
									'vipbind'=>$bound,
									'logo'=>(Yii::app()->request->hostInfo.Yii::app()->request->baseUrl.($store->logo?$store->logo:'/img/default-logo.jpg')),
									'url'=>Yii::app()->createAbsoluteUrl('wap/wap/personal').'/'.$sellerId."?openid={$openid}&token={$token}&storeid={$store->id}",
									));
				
			}
			$this->render('storelistpersonal', array('key'=>$key, 'sellerId'=>$sellerId, 
										 'openId'=>$openid, 'wxid'=>$user->wechat_name, 
										 'pstores'=>json_encode($pstorearr)));
		}
	}
	
	public function actionHistory(){
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/history\/(\d+)[?](.*)/i', $url, $matches);
		$sellerId = null;
		$openid = null;
		$token  = null;
		if(isset($matches[1]) &&  isset($_GET['openid'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$this->render('history', array('sellerid'=>$sellerId, 'openid'=>$openid));
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
	}
	
	public function actionGetData(){

		if(Yii::app()->request->isPostRequest){
			if(isset($_POST['sid']) && $_POST['sid'] >= 0){
				$sid = $_POST['sid'];
				$store   = StoreAR::model()->findByPK($sid);
				if($store){
					$data = array();
					$data['error'] = 0;
					if(isset($_POST['needsort']) && $_POST['needsort'] == 'true'){
						$data['sortdata'] = $this->getSortData($sid);
					}
					if(isset($_POST['needproduct']) && $_POST['needproduct'] == 'true'){
						$data['productdata'] = $this->getProductData($sid);
					}
					if(isset($_POST['needdeliveryarea']) && $_POST['needdeliveryarea'] == 'true'){
						$data['deliveryareadata'] = $this->getDeliveryAreaData($sid);
					}
					if(isset($_POST['needrecommend']) && $_POST['needrecommend'] == 'true'){
						$data['recommenddata'] = $this->getRecommendData($sid);
					}
					if(isset($_POST['needshopinfo']) && $_POST['needshopinfo'] == 'true'){
						$data['shopinfodata'] = $this->getShopInfo($store);
					}
					echo json_encode($data);
				}
			}else{
				echo json_encode(array('error'=>1, 'error_msg'=>'找不到该商家'));
			}
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
	}

	public function actionGetPersonalInfo(){
		if(isset($_POST['openid']) && isset($_POST['storeid']) && isset($_POST['sellerid'])){

			$member  = MembersAR::model()->find("openid='{$_POST['openid']}' AND seller_id={$_POST['sellerid']}");
			$maxtime = OrdersAR::model()->getMaxOrderTime($_POST['storeid'], $member->id);
			if($member){
				$result = array('success'=>'1', 
								'result'=>array('lastorder'=>$maxtime[0]['mtime']));
				echo json_encode($result);
			}
			echo null;
		}
		else 
			throw new CHttpException(403, "Error Processing Request");
	}
	
	
	private function getShopInfo($store){		
		$shopInfo = array();
		$shopInfo['announcement'] = $store->broadcast;
		$shopstatus = null;
		$store->status == 0?$shopstatus="innormal":($store->status == 1?$shopstatus="nodelivery":$shopstatus="enclosed");
		$shopInfo['shopstatus'] = $shopstatus;
		preg_match('/(\d+:\d+):\d+/i', $store->stime, $matches);
		$shopInfo['begintime'] = $matches[1];
		preg_match('/(\d+:\d+):\d+/i', $store->etime, $matches);
		$shopInfo['endtime'] = $matches[1];
		$shopInfo['servertime'] = date('H:i');
		$shopInfo['isdeliveryfree'] = $store->threshold==1;
		$shopInfo['sendingfee'] = $store->start_price;
		$shopInfo['deliveryfee'] = $store->takeaway_fee;
		$shopInfo['expecttime'] = $store->estimated_time;
		return $shopInfo;
	}
	
	private function getSortData($sid){
		$types = ProductTypeAR::model()->getUndeletedProductTypeByStoreId($sid);
		$sortdata = array();
		foreach ($types as $type){
			array_push($sortdata, array("sortid"=>$type->id,
					"sortname" => $type->type_name,
					"sortdesc" => $type->type_description,
					"sortimg"  => $type->pic_url,
				));
		}
		return $sortdata;
	}
	
	private function getProductData($sid){
		$products = ProductsAR::model()->getUndeletedProductsWithPicUrlByStoreId($sid);
		$productdata = array();
		foreach ($products as $product){
			$stime = new DateTime($product['stime']);
			$stime = $stime->format('Y-m-d');
			$etime = new DateTime($product['etime']);
			$etime = $etime->format('Y-m-d');
			$now   = date('Y-m-d');
			if($now < $stime || $now > $etime || $product['status']!= 1)
				continue;
			array_push($productdata, array("productid"=>$product['id'],
					"sortid" => $product['type_id'],
					"price" => $product['price'],
					"productname"  => $product['pname'],
					"productleft"  => $product['daily_instore'],
					"productdesc"  => $product['description'],
					"productimg"  => $product['picurl'],
				));
		}
		return $productdata;
	}
	
	private function getDeliveryAreaData($sid){
		$districts = DistrictsAR::model()->getUndeletedDistrictsByStoreId($sid);
		$areas = array();
		foreach ($districts as $district){
			array_push($areas, array("areaid"=>$district->id,
					"areaname" => $district->name,
					"areadesc" => $district->description,
					"areastatus"  => $district->daily_status==0,
				));
		}
		return $areas;
	}
	
	private function getRecommendData($sid){
		$recomends = array();
		$hots = HotProductsAR::model()->getHotProductsByStoreId($sid);
		$i = 0;
		foreach($hots as $hot){
			array_push($recomends, array("recommendid"=> $hot->product_id,
					"recommendtype" => "recsort",
					"recommendtag" => $hot->description,
					"recommendimg"  => $hot->pic_url,
					"objectid"  => $hot->product_id,
				));
		}
		return $recomends;
	}
}