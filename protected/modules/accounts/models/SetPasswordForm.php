<?php

/**
 * @author  zhoushuai
 */
class SetPasswordForm extends CFormModel
{
    public $oldPassword;
    public $newPassword;
    public $reNewPassword;

    public function rules()
    {
        return array(
            array('oldPassword', 'required', 'message'=>'请输入当前密码'),
            array('newPassword', 'required', 'message'=>'请输入新密码'),
            array('newPassword', 'length', 'min'=>6, 'max'=>30, 'tooShort'=>'密码长度不少能于6位', 'tooLong'=>'密码长度不能多于30位'),
            array('reNewPassword', 'required', 'message'=>'请再次输入新密码'),
            array('reNewPassword', 'length', 'min'=>6, 'max'=>30, 'tooShort'=>'密码长度不少能于6位', 'tooLong'=>'密码长度不能多于30位'),
            array('reNewPassword', 'checkSame'),
         );
    }

    public function attributeLabels()
    {
        return array(
            'oldPassword'=>'当前密码',
            'newPassword'=>'新密码',
            'reNewPassword'=>'确认密码',
        );
    }

    public function checkSame($attribute,$params)
    {
        if (!$this->hasErrors()){
            if ($this->newPassword != $this->reNewPassword){
                $this->addError('reNewPassword','两次输入的密码不一致，请重新输入');
            }           
        }
    }

    public function resetSucceed(){
        $userAr = UsersAR::model()->getUserByEmail(Yii::app()->user->name);
        if ($userAr != null){
            if ($userAr->password != md5($this->oldPassword)){
                $this->addError('oldPassword', '密码错误');
                return false;
            }
            else {
                return UsersAR::model()->updatePasswordByID(Yii::app()->user->id, $this->newPassword);             
            }
        }
        return false;
    }
}
