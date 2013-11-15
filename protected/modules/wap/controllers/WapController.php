<?php
class WapController extends Controller{
	
	public $layout = '/layouts/main';
	public $defaultAction = "index";
	
	public function actionIndex(){
		// 获取商家id
		$url = Yii::app()->request->getUrl();
		// 用正则表达式从url获取seller id
		preg_match('/.*wap\/index\/(\d+)/i', $url, $matches);
		$sellerId = $matches[1];
		
		$json_data = "hello world!";
		// 构建json数据
		$shopinfodata = $this->getShopInfo($sellerId);
		$recommenddata = $this->getRecommendData($sellerId);
		$sortdata = $this->getSortData($sellerId);
		$productdata = $this->getProductData($sellerId);
		$deliveryareadata = $this->getDeliveryAreaData($sellerId);
		
		$json_data = array(
			'shopinfodata'=>$shopinfodata,
			'recommenddata'=>$recommenddata,
			'sortdata'=>$sortdata,
			'deliveryareadata'=>$deliveryareadata,
			'productdata'=>$productdata
		);
		
		$this->render('index', array('json_data'=>json_encode($json_data)));
	}
	
	
	private function getShopInfo($userId){
		$user = UsersAR::model()->getUserById($userId);
		$shopInfo = array();
		$shopInfo[0]->announcement = $user->broadcast;
		$shopInfo[0]->shopstatus = $user->status == 0? "normal" : "innormal";
		preg_match('/(\d+:\d+):\d+/i', $user->stime, $matches);
		$shopInfo[0]->begintime  = $matches[1];
		preg_match('/(\d+:\d+):\d+/i', $user->etime, $matches);
		$shopInfo[0]->endtime    = $matches[1];
		$shopInfo[0]->servertime = date('H:i');
		$shopInfo[0]->isdeliveryfree = $user->threshold==1;
		$shopInfo[0]->sendingfee = $user->start_price;
		$shopInfo[0]->deliveryfee = $user->takeaway_fee;
		$shopInfo[0]->expecttime = $user->estimated_time;
		return $shopInfo[0];
	}
	
	private function getSortData($userId){
		$types = ProductTypeAR::model()->getSellerProductType($userId);
		$sortdata = array();
		$i = 0;
		foreach ($types as $type){
			$sortdata[$i]->sortid = $type->id;
			$sortdata[$i]->sortname = $type->type_name;
			$sortdata[$i]->sortdesc = $type->type_description;
			$sortdata[$i]->sortimg  = $type->pic_url;
			$i++;
		}
		return $sortdata;
	}
	
	private function getProductData($sellerId){
		$products = ProductsAR::model()->getProductsBySellerId($sellerId);
		$productdata = array();
		$i = 0;
		foreach ($products as $product){
			$productdata[$i]->productid = $product->id;
			$productdata[$i]->sortid    = $product->type_id;
			$productdata[$i]->price     = $product->price;
			$productdata[$i]->productname = $product->pname;
			$productdata[$i]->productleft = $product->daily_instore;
			$i++;
		}
		return $productdata;
	}
	
	private function getDeliveryAreaData($userId){
		$districts = DistrictsAR::model()->getDistrictsByUserId($userId);
		$areas = array();
		$i = 0;
		foreach ($districts as $district){
			$areas[$i]->areaid   = $district->id;
			$areas[$i]->areaname = $district->name;
			$areas[$i]->areadesc = $district->description;
			$areas[$i]->areastatus = true;
			$i ++;
		}
		return $areas;
	}
	
	private function getRecommendData($userId){
		$recomends = array();
		$hots = HotProductsAR::model()->getHotProductsById($userId);
		$i = 0;
		foreach($hots as $hot){
			$recomends[$i]->recommendid   = $hot->product_id;
			$recomends[$i]->recommendtype = "recsort";
			$recomends[$i]->recommendtag  = $hot->desc;
			$recomends[$i]->recommendimg  = $hot->pic_url;
			$recomends[$i]->objectid      = $hot->product_id;
			$i ++;
		}
		return $recomends;
	}
}