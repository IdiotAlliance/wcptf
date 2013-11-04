<?php

/**
 * @author  zhoushuai
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	public $rememberMe;

	private $_identity;

	public function rules()
	{
		return array(
			array('username','email', 'allowEmpty'=>true, 'message'=>'请输入正确的邮箱地址'),
			array('username', 'required', 'message'=>'请输入邮箱地址'),
			array('username', 'length', 'max'=>320, 'tooLong'=>'邮箱地址长度不超过320位'),
			array('password', 'required', 'message'=>'请输入密码'),
			array('rememberMe', 'boolean'),
			array('password', 'authenticate'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'username'=>'邮箱',
			'password'=>'密码',
			'rememberMe'=>'下次自动登录',
			'body'=>'富文本框',
		);
	}

	public function authenticate($attribute,$params)
	{
		$this->_identity=new UserIdentity($this->username,$this->password);
		if(!$this->_identity->authenticate()){
            if ($this->_identity->errorCode == UserIdentity::ERROR_USERNAME_INVALID){
                $this->addError('username','用户不存在');                  
            }  
            else {
                $this->addError('password','用户名或密码错误');                            
            }       
        }
	}

	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
 			return true;
		}
		else
			return false;
	}

	//用户是否通过邮箱验证
	public function isVerified(){
		return UsersAR::model()->isVerified($this->username);
	}
}
