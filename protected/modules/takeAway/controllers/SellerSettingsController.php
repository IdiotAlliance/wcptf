<?php
class SellerSettingsController extends Controller{
	
	public $layout = '/layouts/main';
	public $defaultAction = 'sellerSettings';
	
	public function actionSellerSettings(){
		if(Yii::app()->user->isGuest){
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect('index.php?r=accounts/login');
		}else{
			$userId = Yii::app()->user->sellerId;
			$user = UsersAR::model()->getUserById($userId);
			$posters = PostersAR::model()->getPostersByUserId($userId);
			$districts = DistrictsAR::model()->getDistrictsByUserId($userId);
			$types = ProductTypeAR::model()->getSellerProductType($userId);
			$products = ProductsAR::model()->getProductsBySellerId($userId);
			$hots = HotProductsAR::model()->getHotProductsById($userId);
			
			$shopinfo = array();
			$shopinfo[0]->status = $user->status;
			$shopinfo[0]->broadcast = $user->broadcast;
			
			// 获取品类和货物信息
			$typearr = array();
			$i = 0;
			foreach ($types as $type){
				$typearr[$i]->id           = $type->id;
				$typearr[$i]->type_name    = $type->type_name;
				$typearr[$i]->daily_status = $type->daily_status;
				$typearr[$i]->hot          = false;
				$typearr[$i]->insufficient = $type->insufficient;
				$typearr[$i]->products     = array();
				
				$j = 0;
				foreach ($products as $product){
					if($product->type_id == $type->id){
						$typearr[$i]->products[$j]->id = $product->id;
						$typearr[$i]->products[$j]->typeid = $product->type_id;
						$typearr[$i]->products[$j]->pname  = $product->pname;
						$typearr[$i]->products[$j]->insufficient = $product->insufficient;
						$j ++;
					}
				}
				
				foreach ($hots  as $hot){
					if($hot->product_id == $type->id){
						$typearr[$i]->hot = true;
						$typearr[$i]->tag = $hot->desc;
						$typearr[$i]->picurl = $hot->pic_url;
					}
				}
				$i ++;
			}
			
			// 获取邮递员信息
			$postarr = array();
			$i = 0;
			foreach ($posters as $poster){
				$postarr[$i]->id    = $poster->id;
				$postarr[$i]->name  = $poster->name;
				$postarr[$i]->phone = $poster->phone;
				$postarr[$i]->desc = $poster->description;
				$postarr[$i]->daily_status = $poster->daily_status;
				$i ++;
			}
			
			// 获取片区信息
			$districtarr = array();
			$i = 0;
			foreach ($districts as $district){
				$districtarr[$i]->id = $district->id;
				$districtarr[$i]->name = $district->name;
				$districtarr[$i]->daily_status = $district->daily_status;
				$i ++;
			}
			
			$json = json_encode(array(
				'shopinfo'=>$shopinfo[0],
				'types'=>$typearr,
				'posters'=>$postarr,
				'districts'=>$districtarr
			));
			
			if(isset($_POST['seller_settings_form'])){
				$model->attributes = $_POST['seller_settings_form'];
			}
			$this->render('sellerSettings', array('json'=>$json));
		}
	}
	
}