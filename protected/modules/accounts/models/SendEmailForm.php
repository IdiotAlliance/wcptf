<?php

/**
 * @author  zhoushuai
 */
class SendEmailForm extends CFormModel
{
    public $email;
    public $verifyCode;

    public function rules()
    {
        return array(
            array('email','email', 'allowEmpty'=>true, 'message'=>'请输入正确的邮箱地址'),
            array('email', 'required', 'message'=>'请输入邮箱地址'),
            array('email', 'length', 'max'=>320, 'tooLong'=>'邮箱地址长度不超过320位'),
            array('email', 'emailExist'),
            array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'message'=>'验证码错误'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'email'=>'登录邮箱',
            'verifyCode'=>'验证码',
        );
    }

    public function emailExist($attribute, $params){
         if (!$this->hasErrors()) {
             if (!UsersAR::model()->isEmailExisted($this->email)) {
                 $this->addError('email', '邮箱不存在');
             }
         }
    }

    public function sendEmail(){
            $transaction = Yii::app()->db->beginTransaction();

            try {     
            
                $userAr = UsersAR::model()->getUserByEmail($this->email);

                FindPwdTokenAR::model()->setOldTokenInvalid($userAr->id);

                $findPwdTokenAr = new FindPwdTokenAR();
                $findPwdTokenAr->user_id = $userAr->id;
                $findPwdTokenAr->token = $findPwdTokenAr->generateToken();
                $findPwdTokenAr->gen_time = new CDbExpression('NOW()');
                $findPwdTokenAr->succeed = FindPwdTokenAR::STATUS_NOT_SUCCEED;
                $findPwdTokenAr->save();
                
                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                return false;
            }

            return EmailHelper::sendFindPwdEmail($userAr->email, $findPwdTokenAr->token);      
    }
     
}
