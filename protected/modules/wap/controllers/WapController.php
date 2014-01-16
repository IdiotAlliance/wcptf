<?php
class WapController extends Controller{
	
	public $layout = '/layouts/main';
	public $defaultAction = "index";
	
	public function actionIndex(){
		
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/index\/(\d+)[?](.*)/i', $url, $matches);
		$sellerId = null;
		$openid = null;
		$sortId = null;
		$token  = null;
		if(isset($matches[1]) &&  isset($_GET['openid']) && isset($_GET['token'])){
			$sellerId = $matches[1];
			$openid = $_GET['openid'];
			$token = $_GET['token'];
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
		if($sellerId && $openid && 
		   UsersAR::model()->getUserById($sellerId) &&
		   ($member = MembersAR::model()->getMemberBySellerIdAndOpenId($sellerId, $openid))){
			
			$key = null;
			// 验证token
			if(MemberTokenAR::model()->validateToken($sellerId, $openid, $token)){
				$key = $member->wapkey;
			}
			
			$this->render('index', array('key'=>$key, 'sellerId'=>$sellerId, 'openId'=>$openid));
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
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