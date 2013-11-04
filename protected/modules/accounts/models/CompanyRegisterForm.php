<?php
/**
* @author  zhoushuai
*/   
class CompanyRegisterForm extends CFormModel
{
    public $province;
    public $city;
    public $companyName;
    public $contactEmail;
    public $contactPhone;
    public $loginEmail;
    public $password;
    public $invitationCode;
    public $verifyCode;

    public function rules()
    {
        return array(
            array('province', 'required', 'message'=>'请选择省份'),
            array('city', 'required', 'message'=>'请选择城市'),
            array('companyName', 'required', 'message'=>'请输入公司名'),
            array('companyName', 'length', 'max'=>50, 'tooLong'=>'公司名不得超过50字'),
            array('contactEmail', 'required', 'message'=>'请输入公司邮箱'),
            array('loginEmail', 'required', 'message'=>'请输入常用邮箱'),
            array('contactEmail, loginEmail', 'email', 'allowEmpty'=>true, 'message'=>'请输入正确的邮箱地址'),
            array('contactEmail, loginEmail', 'length', 'max'=>320, 'tooLong'=>'邮箱地址长度不超过320位'),
            array('loginEmail', 'emailNotExist'),
            array('password', 'required', 'message'=>'请输入密码'),
            array('password', 'length', 'min'=>6, 'max'=>30, 'tooShort'=>'密码长度不少于6位', 'tooLong'=>'密码长度不大于30位'),
            array('contactPhone', 'required', 'message'=>'请输入公司电话'),
            array('contactPhone', 'match', 'allowEmpty'=>true,
                'pattern'=>'/^((1[3|4|5|8]\d{9}$)|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$)/', 
                'message'=>'请输入正确的固话号码，完整格式为 区号-固话号-分机号 或者 正确的11位手机号码，以13/14/15/18开头'),
            array('invitationCode', 'required', 'message'=>'请输入邀请码'),
            array('invitationCode', 'invitationCodeCorrect'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'message'=>'验证码错误'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'companyName'=>'公司名',
            'contactEmail'=>'公司邮箱',
            'contactPhone'=>'公司电话',
            'loginEmail'=>'登录邮箱',
            'password'=>'密码',
            'invitationCode'=>'邀请码',
            'verifyCode'=>'验证码',
            'province'=>'省份',
            'city'=>'城市',
        );
    }

    public function emailNotExist($attribute, $params){
         if (!$this->hasErrors()) {
             if (UserAR::model()->isEmailExisted($this->loginEmail)) {
                 $this->addError('loginEmail', '邮箱已经存在');
             }
         }
    }

    public function invitationCodeCorrect($attribute, $params){
        if (!$this->hasErrors()){
            $inviCode = InvitationCodeAR::model()->find('code=:code and type=:type', 
                                                        array(':code'=>$this->invitationCode,
                                                              ':type'=>InvitationCodeAR::CODE_FOR_COM,
                                                              ));
            if ($inviCode == null){
                $this->addError('invitationCode', '请输入正确的邀请码');
            }
            else if ($inviCode['user_id'] != null){
                $this->addError('invitationCode', '该邀请码已经被使用过了');
            }
        }
    }

    public function registerSucceed(){
        $transaction = Yii::app()->db->beginTransaction();
        try {
            $userAr = new UserAR(); 
            $userAr->email = $this->loginEmail;
            $userAr->password = md5($this->password);
            $userAr->type = UserAR::TYPE_COMPANY;
            $userAr->register_time = new CDbExpression('NOW()');
            $userAr->email_verified = UserAR::STATUS_NOT_VERIFIED;
            $userAr->verify_code = $userAr->generateVerifyCode();
            $userAr->save();

            $companyAr = new CompanyAR();
            $companyAr->user_id = $userAr->id;
            $companyAr->city_id = $this->city;
            $companyAr->name = $this->companyName;
            $companyAr->email = $this->contactEmail;
            $companyAr->contact_phone = $this->contactPhone;
            $companyAr->verified = CompanyAR::STATUS_NOT_VERIFIED;
            $companyAr->save();

            $invitationCodeAr = InvitationCodeAR::model()->getInvitationCodeByCode($this->invitationCode);
            $invitationCodeAr->user_id = $userAr->id;
            $invitationCodeAr->save();

            $transaction->commit();

            //添加rbac角色
            Yii::app()->authManager->assign(RbacHelper::UNVALIDATER_ROLE, $userAr->id);

        } catch (Exception $e) {
            $transaction->rollback();
             return false;
        }

        EmailHelper::sendVerifyEmail($userAr, $companyAr->name);
        return true;
    }

    public function login()
    {
        $identity = new UserIdentity($this->loginEmail,$this->password);
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
