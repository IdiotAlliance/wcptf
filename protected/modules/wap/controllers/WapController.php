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
			if(isset($_POST['sellerid'])){
				$sellerId = $_POST['sellerid'];
				$seller = UsersAR::model()->findByPK($sellerId);
				if($seller){
					$data = array();
					$data['error'] = 0;
					if(isset($_POST['needsort']) && $_POST['needsort'] == 'true'){
						$data['sortdata'] = $this->getSortData($sellerId);
					}
					if(isset($_POST['needproduct']) && $_POST['needproduct'] == 'true'){
						$data['productdata'] = $this->getProductData($sellerId);
					}
					if(isset($_POST['needdeliveryarea']) && $_POST['needdeliveryarea'] == 'true'){
						$data['deliveryareadata'] = $this->getDeliveryAreaData($sellerId);
					}
					if(isset($_POST['needrecommend']) && $_POST['needrecommend'] == 'true'){
						$data['recommenddata'] = $this->getRecommendData($sellerId);
					}
					if(isset($_POST['needshopinfo']) && $_POST['needshopinfo'] == 'true'){
						$data['shopinfodata'] = $this->getShopInfo($sellerId);
					}
					echo json_encode($data);
				}
			}else{
				echo json_encode(array('error'=>1, 'error_msg'=>'找不到该商家'));
			}
		}else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
		//old
		// if(Yii::app()->request->isPostRequest){
  //           if(isset($_POST['sellerid'])){
  //                   $sellerId = $_POST['sellerid'];
  //                   $seller = UsersAR::model()->findByPK($sellerId);
  //                   if($seller){
  //                           $data = array();
  //                           $data[0]->error = 0;
  //                           if(isset($_POST['needsort']) && $_POST['needsort'] == 'true'){
  //                                   $data[0]->sortdata = $this->getSortData($sellerId);
  //                           }
  //                           if(isset($_POST['needproduct']) && $_POST['needproduct'] == 'true'){
  //                                   $data[0]->productdata = $this->getProductData($sellerId);
  //                           }
  //                           if(isset($_POST['needdeliveryarea']) && $_POST['needdeliveryarea'] == 'true'){
  //                                   $data[0]->deliveryareadata = $this->getDeliveryAreaData($sellerId);
  //                           }
  //                           if(isset($_POST['needrecommend']) && $_POST['needrecommend'] == 'true'){
  //                                   $data[0]->recommenddata = $this->getRecommendData($sellerId);
  //                           }
  //                           if(isset($_POST['needshopinfo']) && $_POST['needshopinfo'] == 'true'){
  //                                   $data[0]->shopinfodata = $this->getShopInfo($sellerId);
  //                           }
  //                           echo json_encode($data[0]);
  //                   }
  //           }else{
  //                   echo json_encode(array('error'=>1, 'error_msg'=>'找不到该商家'));
  //           }
  //       }else{
  //               $this->redirect(Yii::app()->createUrl('errors/error/404'));
  //       }
	}
	
	
	private function getShopInfo($userId){
		$user = UsersAR::model()->getUserById($userId);
		$shopInfo = array();
		$shopInfo['announcement'] = $user->broadcast;
		$shopstatus = null;
		$user->status == 0?$shopstatus="innormal":($user->status == 1?$shopstatus="nodelivery":$shopstatus="enclosed");
		$shopInfo['shopstatus'] = $shopstatus;
		preg_match('/(\d+:\d+):\d+/i', $user->stime, $matches);
		$shopInfo['begintime'] = $matches[1];
		preg_match('/(\d+:\d+):\d+/i', $user->etime, $matches);
		$shopInfo['endtime'] = $matches[1];
		$shopInfo['servertime'] = date('H:i');
		$shopInfo['isdeliveryfree'] = $user->threshold==1;
		$shopInfo['sendingfee'] = $user->start_price;
		$shopInfo['deliveryfee'] = $user->takeaway_fee;
		$shopInfo['expecttime'] = $user->estimated_time;
		return $shopInfo;

		//old
		// $user = UsersAR::model()->getUserById($userId);
  //               $shopInfo = array();
  //               $shopInfo[0]->announcement = $user->broadcast;
  //               $shopInfo[0]->shopstatus = $user->status == 0? "normal" : "innormal";
  //               preg_match('/(\d+:\d+):\d+/i', $user->stime, $matches);
  //               $shopInfo[0]->begintime  = $matches[1];
  //               preg_match('/(\d+:\d+):\d+/i', $user->etime, $matches);
  //               $shopInfo[0]->endtime    = $matches[1];
  //               $shopInfo[0]->servertime = date('H:i');
  //               $shopInfo[0]->isdeliveryfree = $user->threshold==1;
  //               $shopInfo[0]->sendingfee = $user->start_price;
  //               $shopInfo[0]->deliveryfee = $user->takeaway_fee;
  //               $shopInfo[0]->expecttime = $user->estimated_time;
  //               return $shopInfo[0];
	}
	
	private function getSortData($userId){
		$types = ProductTypeAR::model()->getUndeletedProductTypeBySellerId($userId);
		$sortdata = array();
		foreach ($types as $type){
			array_push($sortdata, array("sortid"=>$type->id,
					"sortname" => $type->type_name,
					"sortdesc" => $type->type_description,
					"sortimg"  => $type->pic_url,
				));
		}
		return $sortdata;
		//old
		// $types = ProductTypeAR::model()->getUndeletedProductTypeBySellerId($userId);
  //       $sortdata = array();
  //       $i = 0;
  //       foreach ($types as $type){
  //               $sortdata[$i]->sortid = $type->id;
  //               $sortdata[$i]->sortname = $type->type_name;
  //               $sortdata[$i]->sortdesc = $type->type_description;
  //               $sortdata[$i]->sortimg  = $type->pic_url;
  //               $i++;
  //       }
  //       return $sortdata;
	}
	
	private function getProductData($sellerId){
		$products = ProductsAR::model()->getUndeletedProductsWithPicUrl($sellerId);
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
		//old
		// $products = ProductsAR::model()->getUndeletedProductsWithPicUrl($sellerId);
		// $productdata = array();
		// $i = 0;
		// foreach ($products as $product){
		// 	$stime = new DateTime($product['stime']);
		// 	$stime = $stime->format('Y-m-d');
		// 	$etime = new DateTime($product['etime']);
		// 	$etime = $etime->format('Y-m-d');
		// 	$now   = date('Y-m-d');
		// 	if($now < $stime || $now > $etime || $product['status']!= 1)
		// 		continue;
			
		// 	$productdata[$i]->productid = $product['id'];
		// 	$productdata[$i]->sortid    = $product['type_id'];
		// 	$productdata[$i]->price     = $product['price'];
		// 	$productdata[$i]->productname = $product['pname'];
		// 	$productdata[$i]->productleft = $product['daily_instore'];
		// 	$productdata[$i]->productdesc = $product['description'];
		// 	$productdata[$i]->productimg  = $product['picurl'];
		// 	$i++;
		// }
		// return $productdata;
	}
	
	private function getDeliveryAreaData($userId){
		$districts = DistrictsAR::model()->getUndeletedDistrictsByUserId($userId);
		$areas = array();
		foreach ($districts as $district){
			array_push($areas, array("areaid"=>$district->id,
					"areaname" => $district->name,
					"areadesc" => $district->description,
					"areastatus"  => $district->daily_status==0,
				));
		}
		return $areas;
		//old
	    // $districts = DistrictsAR::model()->getDistrictsByUserId($userId);
     //        $areas = array();
     //        $i = 0;
     //        foreach ($districts as $district){
     //                $areas[$i]->areaid   = $district->id;
     //                $areas[$i]->areaname = $district->name;
     //                $areas[$i]->areadesc = $district->description;
     //                $areas[$i]->areastatus = true;
     //                $i ++;
     //        }
     //        return $areas;
	}
	
	private function getRecommendData($userId){
		$recomends = array();
		$hots = HotProductsAR::model()->getHotProductsById($userId);
		$i = 0;
		foreach($hots as $hot){
			array_push($recomends, array("recommendid"=> $hot->product_id,
					"recommendtype" => "recsort",
					"recommendtag" => $hot->desc,
					"recommendimg"  => $hot->pic_url,
					"objectid"  => $hot->product_id,
				));
		}
		return $recomends;
		//old
		// $recomends = array();
		// $hots = HotProductsAR::model()->getHotProductsById($userId);
		// $i = 0;
		// foreach($hots as $hot){
		// 	$recomends[$i]->recommendid   = $hot->product_id;
		// 	$recomends[$i]->recommendtype = "recsort";
		// 	$recomends[$i]->recommendtag  = $hot->desc;
		// 	$recomends[$i]->recommendimg  = $hot->pic_url;
		// 	$recomends[$i]->objectid      = $hot->product_id;
		// 	$i ++;
		// }
		// return $recomends;
	}
}