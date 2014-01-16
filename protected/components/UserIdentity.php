<?php

class UserIdentity extends CUserIdentity
{
	const SESSION_SELLERTYPE = 'sellerType';
	const SESSION_SELLERID = 'sellerId';
	const SESSION_HOMEURL = 'homeUrl';

	/**
	 * @author  luwenbin
	 * 验证用户登录名密码，并且向Session中记录 sellerType , sellerId , specificName , homeUrl;
	 * sellerType 是用户类型，值是user表的seller_type
	 * sellerId 是特定用户的id, 如 company用户就是com_id
	 * homeUrl 是不同角色对应的URL
	 */
	public function authenticate()
	{
		$user = UsersAR::model()->getUserByEmail($this->username);
		if($user === null){
			$this->errorCode=self::ERROR_USERNAME_INVALID;			
		}
		else if($user->password !== md5($this->password)){
			$this->errorCode=self::ERROR_PASSWORD_INVALID;			
		}
		else{
			Yii::app()->user->setState(UserIdentity::SESSION_SELLERID, $user->id);
			$this->errorCode=self::ERROR_NONE;
		}	
		return !$this->errorCode;
	}


}