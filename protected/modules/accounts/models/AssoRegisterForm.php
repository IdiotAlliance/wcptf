<?php
    /**
     * @author  zhoushuai
     */
    
class AssoRegisterForm extends CFormModel
{
    public $sellerType;
    public $email;
    public $password;
    public $verifyCode;


    public function rules()
    {
        return array(
            array('sellerType', 'required', 'message'=>'请选择商家类型'),
            array('email', 'required', 'message'=>'请输入常用邮箱'),
            array('email', 'email', 'allowEmpty'=>false, 'message'=>'请输入正确的邮箱地址'),
            array('email', 'length', 'max'=>320, 'tooLong'=>'邮箱地址长度不能超过320位'),
            array('email', 'emailNotExist'),
            array('password', 'required', 'message'=>'请输入密码'),
            array('password', 'length', 'min'=>6, 'max'=>30, 'tooShort'=>'密码长度能不少于6位', 'tooLong'=>'密码长度不能大于30位'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'message'=>'验证码错误'),

        );
    }

    public function attributeLabels()
    {
        return array(
            'sellerType'=>'商家类型',
            'email'=>'登录邮箱',
            'password'=>'密码',
            'verifyCode'=>'验证码',
        );
    }

    /**
     * this is the 'emailNotExist' validator declared in function rules();
     */
    public function emailNotExist($attribute, $params){
        if (!$this->hasErrors()) {
            if (UsersAR::model()->isEmailExisted($this->email)) {
                $this->addError('email', '邮箱已经存在');
            }
        }
    }

    public function registerSucceed(){

        $userAr = new UsersAR();
        $userAr->email = $this->email;
        $userAr->password = md5($this->password);
        $userAr->type = UsersAR::TYPE_SELLER;

        switch ($this->sellerType) {
            case '0':
                $userAr->seller_type = UsersAR::SELLERTYPE_TAKEAWAY;
                break;     
            default:
                $userAr->seller_type = UsersAR::SELLERTYPE_TAKEAWAY;
                break;
        }
        $userAr->register_time = new CDbExpression('NOW()');
        $userAr->email_verified = UsersAR::STATUS_NOT_VERIFIED;
        $userAr->verify_code = $userAr->generateVerifyCode();
        EmailHelper::sendVerifyEmail($userAr, $this->email);
        return $userAr->save();
    }

    public function login()
    {
        $identity = new UserIdentity($this->email,$this->password);
        $identity->authenticate();
        if($identity->errorCode===UserIdentity::ERROR_NONE)
        {
            $duration = 3600*24*30; // 30 days
            Yii::app()->user->login($identity, $duration);
            return true;
        }
        else
            return false;
    }
}
