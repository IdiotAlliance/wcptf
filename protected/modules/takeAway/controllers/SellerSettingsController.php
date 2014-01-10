<?php
include 'TakeAwayController.php';

class SellerSettingsController extends TakeAwayController {
	public $layout = '/layouts/main';
	public $defaultAction = 'sellerSettings';

	public function actionSellerSettings() {

		// $this->setCurrentStore($sid);

		if (Yii::app ()->user->isGuest) {
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect ( 'index.php?r=accounts/login' );
		} else if(isset($_GET['sid']) && $_GET['sid'] >= 0 && $this->setCurrentStore($_GET['sid'])){
			$sid  = $_GET['sid'];
			$json = null;
			$userId = Yii::app ()->user->sellerId;
			if (isset ( $_POST ['json'] )) {
				$json = $_POST ['json'];
				$obj = json_decode ($this->unescape($json));
				$json = json_encode($obj);
				
				// 更新店铺信息
				$store = StoreAR::model()->findByPK($sid);
				$store->status    = (int)$obj->shopinfo->status;
				$store->broadcast = $obj->shopinfo->broadcast;
				$store->update();
				
				// 更新商品信息
				HotProductsAR::model()->deleteHotProductsByUserId($sid);
				foreach ($obj->types as $type){
					if(isset($type->tag) && $type->tag){
						$dbhot = new HotProductsAR();
						$dbhot->store_id = $sid;
						$dbhot->product_id = $type->id;
						if(isset($type->picurl) && $type->picurl)
							$dbhot->pic_url = $type->picurl;
						$dbhot->onindex = (int)$type->onindex;
						$dbhot->desc = $type->tag;
						$dbhot->save();
					}
					
					foreach($type->products as $product){
						$dbproduct = ProductsAR::model()->getProductById($product->id);
						$dbproduct->daily_instore = $product->daily_instore;
						$dbproduct->update();
					}
				}
				
				// 更新片区信息
				foreach ($obj->districts as $district){
					$dbdistrict = DistrictsAR::model()->getDistrictById($district->id);
					$dbdistrict->daily_status = (int)$district->daily_status;
					$dbdistrict->update();
				}
				
				// 更新派送信息
				foreach ($obj->posters as $poster){
					$dbposter = PostersAR::model()->getPosterById($poster->id);
					$dbposter->daily_status = (int)$poster->daily_status;
					$dbposter->update();
				}
				
			} else {
				$store = StoreAR::model()->findByPK($sid);
				$posters = PostersAR::model ()->getUndeletedPostersByUserId($sid);
				$districts = DistrictsAR::model ()->getUndeletedDistrictsByUserId($sid);
				$types = ProductTypeAR::model ()->getUndeletedProductTypeBySellerId($sid);
				$products = ProductsAR::model ()->getUndeletedProductsBySellerId($sid);
				$hots = HotProductsAR::model ()->getHotProductsById ($sid);
				
				$shopinfo = array (
					'status'=>$store->status,
					'broadcast'=>$store->broadcast,
					);

				
				// 获取品类和货物信息
				$typearr = array ();
				$i = 0;
				foreach ( $types as $type ) {
					$typearr[$i] = array(
						'id'=>$type->id,
						'type_name'=>$type->type_name,
						'daily_status'=>$type->daily_status,
						'hot'=>false,
						'products'=>array(),
						);

					foreach ( $products as $product ) {
						if ($product->type_id == $type->id) {
							array_push($typearr[$i]['products'], 
								array(
								'id'=>$product->id,
								'typeid'=>$product->type_id,
								'pname'=>$product->pname,
								'daily_instore'=>$product->daily_instore,
								));
						}
					}
					
					foreach ( $hots as $hot ) {
						if ($hot->product_id == $type->id) {
							$typearr [$i]['hot']     = true;
							$typearr [$i]['tag']     = $hot->desc;
							$typearr [$i]['picurl']  = $hot->pic_url;
							$typearr [$i]['onindex'] = $hot->onindex;
						}
					}
					$i ++;
				}
				
				// 获取邮递员信息
				$postarr = array ();
				$i = 0;
				foreach ( $posters as $poster ) {
					$postarr[$i] = array(
						'id'=>$poster->id,
						'name'=>$poster->name,
						'phone'=>$poster->phone,
						'desc'=>$poster->description,
						'daily_status'=>$poster->daily_status,
						);
					$i ++;
				}
				
				// 获取片区信息
				$districtarr = array ();
				$i = 0;
				foreach ( $districts as $district ) {
					$districtarr [$i] = array(
						'id'=>$district->id,
						'name'=>$district->name,
						'daily_status'=>$district->daily_status,
						);
					$i ++;
				}
				
				$json = json_encode ( array (
						'shopinfo' => $shopinfo,
						'types' => $typearr,
						'posters' => $postarr,
						'districts' => $districtarr 
				) );
				
				
			}
			
			$this->render ( 'sellerSettings', array (
					'json' => $json, 'sid' => $sid,
			));
		}
		// go to 404 page
		else{
			$this->redirect(Yii::app()->createUrl('errors/error/404'));
		}
	}
	
	
	function actionImgUpload($typeId) {
		$sellerId = Yii::app ()->user->sellerId;
		$pictureId = UpPicture::uploadPicture ( "upload/hots/", "hots" );
		
	}
	
	
	function unescape($str) {
		$ret = '';
		$len = strlen ( $str );
		
		for($i = 0; $i < $len; $i ++) {
			if ($str [$i] == '%' && $str [$i + 1] == 'u') {
				$val = hexdec ( substr ( $str, $i + 2, 4 ) );
				
				if ($val < 0x7f)
					$ret .= chr ( $val );
				else if ($val < 0x800)
					$ret .= chr ( 0xc0 | ($val >> 6) ) . chr ( 0x80 | ($val & 0x3f) );
				else
					$ret .= chr ( 0xe0 | ($val >> 12) ) . chr ( 0x80 | (($val >> 6) & 0x3f) ) . chr ( 0x80 | ($val & 0x3f) );
				$i += 5;
			} else if ($str [$i] == '%') {
				$ret .= urldecode ( substr ( $str, $i, 3 ) );
				$i += 2;
			} else
				$ret .= $str [$i];
		}
		return $ret;
	}
}