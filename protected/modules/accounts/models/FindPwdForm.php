<?php
/**
 * @author  zhoushuai
 */
class FindPwdForm extends CFormModel{
    public $password;
    public $repassword;
    public $token;

    public function rules(){
      return array(
           array('password', 'required', 'message'=>'请输入新密码'),
           array('password', 'length', 'min'=>6, 'max'=>30, 'tooShort'=>'密码长度不少于6位', 'tooLong'=>'密码长度不能大于30位'),
           array('repassword', 'required', 'message'=>'请再次输入密码'),
           array('repassword', 'length', 'min'=>6, 'max'=>30, 'tooShort'=>'密码长度不少于6位', 'tooLong'=>'密码长度不能大于30位'),
           array('repassword', 'checkSame'),
           array('token', 'required', 'message'=>''),
           array('token', 'length', 'max'=>64, 'tooLong'=>''),
       );   
    }

    public function attributeLabels(){
        return array(
            'password'=>'重置密码',
            'repassword'=>'确认密码'
            ); 
    }

   public function checkSame($attribute,$params)
    {
        if (!$this->hasErrors()){
            if ($this->password != $this->repassword){
                $this->addError('repassword','两次输入的密码不一致，请重新输入');
            }           
        }
    }

    public function setPassword(){
        if (!FindPwdTokenAR::model()->isTokenValid($this->token)){
            return false;
        }  

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $findPwdTokenAr = FindPwdTokenAR::model()->getFindPwdTokenByToken($this->token);
            $findPwdTokenAr->succeed = FindPwdTokenAR::STATUS_HAS_SUCCEED;
            $findPwdTokenAr->save();

            $userAr = UsersAR::model()->findByPk($findPwdTokenAr->user_id);
            $userAr->password = md5($this->password);
            $userAr->save();

            $transaction->commit();
            } catch (Exception $e) {
               $transaction->rollback();
               return false;
            }    
        return true;
    }

}
