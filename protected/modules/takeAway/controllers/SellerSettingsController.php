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
			$model  = new SellerSettingsForm();
			
			if(isset($_POST['seller_settings_form'])){
				$model->attributes = $_POST['seller_settings_form'];
				
			}else{
			}
			
			$this->render('sellerSettings', array('model'=>$model));
		}
	}
	
}