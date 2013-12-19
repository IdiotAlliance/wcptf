<?php
class SellerSettingsController extends Controller {
	public $layout = '/layouts/main';
	public $defaultAction = 'sellerSettings';
	public function actionSellerSettings() {
		if (Yii::app ()->user->isGuest) {
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect ( 'index.php?r=accounts/login' );
		} else {
			$json = null;
			$userId = Yii::app ()->user->sellerId;
			if (isset ( $_POST ['json'] )) {
				$json = $_POST ['json'];
				$obj = json_decode ($this->unescape($json));
				$json = json_encode($obj);
				
				// 更新店铺信息
				$dbuser = UsersAR::model()->getUserById($userId);
				$dbuser->status    = (int)$obj->shopinfo->status;
				$dbuser->broadcast = $obj->shopinfo->broadcast;
				$dbuser->update();
				
				// 更新商品信息
				HotProductsAR::model()->deleteHotProductsByUserId($userId);
				foreach ($obj->types as $type){
					$dbtype = ProductTypeAR::model()->getProductTypeById($type->id);
					$dbtype->update();
					if(isset($type->tag) && $type->tag){
						$dbhot = new HotProductsAR();
						$dbhot->seller_id = $userId;
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
				$user = UsersAR::model ()->getUserById ( $userId );
				$posters = PostersAR::model ()->getUndeletedPostersByUserId($userId);
				$districts = DistrictsAR::model ()->getUndeletedDistrictsByUserId($userId);
				$types = ProductTypeAR::model ()->getUndeletedProductTypeBySellerId($userId);
				$products = ProductsAR::model ()->getUndeletedProductsBySellerId($userId);
				$hots = HotProductsAR::model ()->getHotProductsById ( $userId );
				
				$shopinfo = array ();
				$shopinfo [0]->status = $user->status;
				$shopinfo [0]->broadcast = $user->broadcast;
				
				// 获取品类和货物信息
				$typearr = array ();
				$i = 0;
				foreach ( $types as $type ) {
					$typearr [$i]->id = $type->id;
					$typearr [$i]->type_name = $type->type_name;
					$typearr [$i]->daily_status = $type->daily_status;
					$typearr [$i]->hot = false;
					$typearr [$i]->products = array ();
					
					$j = 0;
					foreach ( $products as $product ) {
						if ($product->type_id == $type->id) {
							$typearr [$i]->products [$j]->id = $product->id;
							$typearr [$i]->products [$j]->typeid = $product->type_id;
							$typearr [$i]->products [$j]->pname = $product->pname;
							$typearr [$i]->products [$j]->daily_instore = $product->daily_instore;
							$j ++;
						}
					}
					
					foreach ( $hots as $hot ) {
						if ($hot->product_id == $type->id) {
							$typearr [$i]->hot = true;
							$typearr [$i]->tag = $hot->desc;
							$typearr [$i]->picurl = $hot->pic_url;
							$typearr [$i]->onindex = $hot->onindex;
						}
					}
					$i ++;
				}
				
				// 获取邮递员信息
				$postarr = array ();
				$i = 0;
				foreach ( $posters as $poster ) {
					$postarr [$i]->id = $poster->id;
					$postarr [$i]->name = $poster->name;
					$postarr [$i]->phone = $poster->phone;
					$postarr [$i]->desc = $poster->description;
					$postarr [$i]->daily_status = $poster->daily_status;
					$i ++;
				}
				
				// 获取片区信息
				$districtarr = array ();
				$i = 0;
				foreach ( $districts as $district ) {
					$districtarr [$i]->id = $district->id;
					$districtarr [$i]->name = $district->name;
					$districtarr [$i]->daily_status = $district->daily_status;
					$i ++;
				}
				
				$json = json_encode ( array (
						'shopinfo' => $shopinfo [0],
						'types' => $typearr,
						'posters' => $postarr,
						'districts' => $districtarr 
				) );
				
				
			}
			
			$this->render ( 'sellerSettings', array (
					'json' => $json
			));
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