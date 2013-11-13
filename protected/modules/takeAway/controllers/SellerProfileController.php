<?php

class SellerProfileController extends Controller{

	public $layout = "/layouts/main";
	public $defaultAction = "sellerProfile";
	
	public function actionSellerProfile(){
		
		if(Yii::app()->user->isGuest){
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect('index.php?r=accounts/login');
		}
		else{
			$userId = Yii::app()->user->sellerId;
			$model = new SellerProfileForm();
			// 获取用户的配送地址信息
			//$districts = array();
			$districts = DistrictsAR::model()->getDistrictsByUserId($userId); 
			// 获取用户的店内环境信息
			//$env = array();
			$env = StoreEnvAR::model()->getStoreEnvByUserId($userId);

			$user  = null;
			// post提交表格
			if(isset($_POST['SellerProfileForm'])){
				$model->attributes = $_POST['SellerProfileForm'];
				// 根据rules对表格进行验证
				if($model->validate()){
					$user = $model->updateUser($userId);
				}	
			}
			else{
				$user = UsersAR::model()->getUserById($userId);
			}
			
			$model->setValues($user);
			// 根据用户信息来填充profile表格
			$this->render('sellerProfile', array('model'=>$model, 
												 'districts'=>$districts,
												 'env'=>$env));
		}
	}

}