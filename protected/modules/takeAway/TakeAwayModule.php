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
				$controller->redirect(Yii::app()->createUrl('accounts/login'));
			}else{
				// if no wechat account has been bound go to the bind action
				$userId = Yii::app()->user->sellerId;
				$user = UsersAR::model()->getUserById($userId);
				if($user->wechat_id == null || $user->wechat_bound == 0){
					$controller->redirect(Yii::app()->createUrl('wechat/wechatBind'));
				}else{
					$controller->setCurrentAction($action->id);
				}
			}
			return true;
		}
		else
			return false;
	}
}
