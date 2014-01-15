 <?php

class WechatBindController extends Controller{
	
	public $layout = 'column1';
	public $defaultAction = 'wechatBind';

	public function actionWechatBind(){
		
		if(Yii::app()->user->isGuest){
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect(Yii::app()->createUrl('accounts/login'));
		}else{
			$userId = Yii::app()->user->sellerId;
			$user = UsersAR::model()->findByPK($userId);
			$model = new WechatBindForm();
			$step = 1;
			
			if(isset($_POST['WechatBindForm'])){
				$model->attributes = $_POST['WechatBindForm'];
				$model->wechat_url = Constants::BASE_URL.$userId.'/'.$model->token;
				$model->updateUser($user);
				if($model->bindComplete($user)) $step = 2;
			}else{
				if($user->wechat_bound == 1){
					$this->redirect(Yii::app()->createUrl('accounts/account/stores'));
				}
				else if($model->bindComplete($user)){
					$step = 2;
				}
			}
			if($step == 1){
				$this->render('wechatBind', array('model'=>$model,
												  'user'=>$user));
			}else{
				$this->render('bindProcess', array('user'=>$user));
			}
		}
	}
	
	public function actionBindComplete(){
		if(Yii::app()->user->isGuest){
			// 当前用户是游客，需要先登陆,跳转到登陆界面
			$this->redirect(Yii::app()->createUrl('accounts/login'));
		}else{
			$userId = Yii::app()->user->sellerId;
			$user = UsersAR::model()->getUserById($userId);
			if($user->wechat_bound){
				$this->redirect(Yii::app()->createUrl('accounts/account/stores'));
			}
			else{
				$errmsg = "您还没有绑定微信帐号";
				$this->render('bindProcess', array('user'=>$user,
												   'errmsg'=>$errmsg));
			}
		}
	}
	
}