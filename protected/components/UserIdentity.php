<?php

class UserIdentity extends CUserIdentity
{
	private $_id;
	const SESSION_USERTYPE = 'sellorType';
	const SESSION_SPECIFICID = 'specificId';
	const SESSION_HOMEURL = 'homeUrl';
	const SESSION_SPECIFICNAME = 'specificName';
	/**
	 * @author  luwenbin
	 * 验证用户登录名密码，并且向Session中记录 userType , specificId , specificName , homeUrl;
	 * userType 是用户类型，值是user表的type
	 * specificId 是特定用户的id, 如 company用户就是com_id
	 * specificName 是特定用户的名称,如 company就是公司名,association就是社团名
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
			$this->_id = $user->id;
			Yii::app()->user->setState(UserIdentity::SESSION_USERTYPE, $user->seller_type);

			$this->errorCode=self::ERROR_NONE;
		}	
		return !$this->errorCode;
	}

	/**
	 * @author  luwenbin
	 * 返回users表的id
	 */ 
	public function getID(){
		return $this->_id;
	}

}