<?php

class WechatBindController extends Controller{
	
	public $layout = 'column1';
	public $defaultAction = 'wechatBind';

	public function actionWechatBind(){
		
		if(Yii::app()->user->isGuest){
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect('index.php?r=accounts/login');
		}else{
			$userId = Yii::app()->user->sellerId;
			$user = UsersAR::model()->getUserById($userId);
			$model = new WechatBindForm();
			
			if(isset($_POST['wechat_bind_form'])){
				$model->attributes = $_POST['wechat_bind_form'];
				$model->updateUser($user);
			}else{
				if($user->wechat_id != null){
					
				}
			}
			
			$this->render('wechatBind', array('model'=>$model));
		}
	}
	
}