<?php

class SellerProfileController extends Controller{

	public $layout = "/layouts/main";
	public $defaultAction = "sellerProfile";
	
	public function actionSellerProfile(){
		
		if(Yii::app()->user->isGuest){
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect('index.php/accounts/login');
		}
		else{
			$userId = Yii::app()->user->sellerId;
			if (isset ( $_POST ['json'] )){
				$json = $_POST ['json'];
				$obj = json_decode ($this->unescape($json));
				
				$user = UsersAR::model()->getUserById($userId);
				$user->store_name = $obj->shopinfo->store_name;
				$user->phone = $obj->shopinfo->phone;
				$user->stime = $obj->shopinfo->stime;
				$user->etime = $obj->shopinfo->etime;
				$user->store_address = $obj->shopinfo->address;
				$user->start_price = (float)$obj->shopinfo->start_price;
				$user->takeaway_fee = (float)$obj->shopinfo->takeaway_fee;
				$user->threshold = (float)$obj->shopinfo->threshold;
				$user->estimated_time = (int)$obj->shopinfo->es_time;
				$user->update();
				
				foreach ($obj->posters as $poster){
					if(isset($poster->deleted) && isset($poster->id)){
						PostersAR::model()->deleteByPK($poster->id);
					}else{
						if(isset($poster->id)){
							$dbposter = PostersAR::model()->getPosterById($poster->id);
							$dbposter->phone = $poster->phone;
							$dbposter->description  = $poster->desc;
							$dbposter->update();
						}else{
							$dbposter = new PostersAR();
							$dbposter->name = $poster->name;
							$dbposter->seller_id = $userId;
							$dbposter->phone = $poster->phone;
							$dbposter->description  = $poster->desc;
							$dbposter->save();
						}
					}
				}
				
				foreach ($obj->districts as $district){
					if(isset($district->deleted) && isset($district->id)){
						DistrictsAR::model()->deleteByPK($district->id);
					}else{
						if(isset($district->id)){
							$dbdistrict = DistrictsAR::model()->getDistrictById($district->id);
							$dbdistrict->description = $district->desc;
							$dbdistrict->update();
						}else{
							$dbdistrict = new DistrictsAR();
							$dbdistrict->seller_id = $userId;
							$dbdistrict->name = $district->name;
							$dbdistrict->description = $district->desc;
							$dbdistrict->save();
						}
					}
				}
			}
			
			$model = array();
			$user = UsersAR::model()->getUserById($userId);
			// 获取用户的配送地址信息
			$districts = DistrictsAR::model()->getDistrictsByUserId($userId); 
			// 获取用户的店内环境信息
			$env = StoreEnvAR::model()->getStoreEnvByUserId($userId);
			// 获取邮递员信息
			$posters = PostersAR::model()->getPostersByUserId($userId);

			$shopinfo = array();
			$shopinfo[0]->store_name = $user->store_name;
			$shopinfo[0]->store_type = $user->type;
			$shopinfo[0]->phone       = $user->phone;
			$shopinfo[0]->stime      = $user->stime;
			$shopinfo[0]->etime      = $user->etime;
			$shopinfo[0]->address    = $user->store_address;
			$shopinfo[0]->start_price = $user->start_price;
			$shopinfo[0]->takeaway_fee = $user->takeaway_fee;
			$shopinfo[0]->threshold  = $user->threshold;
			$shopinfo[0]->es_time    = $user->estimated_time;
			
			// 获取邮递员信息
			$postarr = array ();
			$i = 0;
			foreach ( $posters as $poster ) {
				$postarr [$i]->id = $poster->id;
				$postarr [$i]->name = $poster->name;
				$postarr [$i]->phone = $poster->phone;
				$postarr [$i]->desc = $poster->description;
				$i ++;
			}
			
			// 获取片区信息
			$districtarr = array ();
			$i = 0;
			foreach ( $districts as $district ) {
				$districtarr [$i]->id = $district->id;
				$districtarr [$i]->name = $district->name;
				$districtarr [$i]->desc = $district->description;
				$i ++;
			}
			
			$json_data = json_encode(array(
				'shopinfo'=>$shopinfo[0],
				'districts'=>$districtarr,
				'posters'=>$postarr,
			));
			$this->render('sellerProfile', array('json_data'=>$json_data));
		}
	}
	
	function actionImgUpload(){
		$sellerId = Yii::app ()->user->sellerId;
		$pictureId = UpPicture::uploadPicture ( "upload/logo/", "logo" );
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