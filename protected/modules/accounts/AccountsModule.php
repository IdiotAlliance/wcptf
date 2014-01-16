<?php

class AccountsModule extends CWebModule
{


	public $defaultController = 'login';

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'accounts.models.*',
			'accounts.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			switch ($controller->id) {
				case 'account':
				case 'help':
				case 'replyRules':
					if(Yii::app()->user->isGuest){
						$controller->redirect(Yii::app()->createUrl('accounts/login'));
					}else{
						$uid  = Yii::app()->user->sellerId;
						$user = UsersAR::model()->findByPK($uid);
						if(!$user->wechat_bound)
							$controller->redirect(array('/wechat/wechatBind'));
					}		
					break;
				default:			
					break;
			}
			return true;
			
		}
		else
			return false;
	}
}
