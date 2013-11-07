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
			$model = new SellerProfileForm();
			$user  = null;
			// post提交表格
			if(isset($_POST['ProfileForm'])){
				$model->attributes = $_POST['ProfileForm'];
				// 根据rules对表格进行验证
				if($model->validate()){
					$user = $model->updateUser(Yii::app()->user->sellerId);
				}	
			}
			else
				$user = UsersAR::model()->getUserById(Yii::app()->user->sellerId);
			
			$model->setValues($user);
			// 根据用户信息来填充profile表格
			$this->render('sellerProfile', array('model'=>$model));
		}
	}

}