<?php

class TakeAwayModule extends CWebModule
{
	public $defaultController = 'productManager';
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		
		$this->setImport(array(
			'takeAway.models.*',
			'takeAway.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// if not signed in
			if(Yii::app()->user->isGuest){
				$controller->redirect('index.php?r=accounts/login');
			}
			// if no wechat account has been bound go to the bind action
			$userId = Yii::app()->user->sellerId;
			$user = UsersAR::model()->getUserById($userId);
			if($user->wechat_id == null){
				$controller->redirect('index.php?r=wechat/wechatBind');
			}
			return true;
		}
		else
			return false;
	}
}
