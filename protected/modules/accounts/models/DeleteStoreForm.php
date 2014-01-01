<?php

class DeleteStoreForm extends CFormModel{

	public $sid;
	public $pass;
	public $vericode;

	public function rules()
    {
        return array(
            array('sid', 'required', 'message'=>'请输入店铺的id'),
            array('pass', 'required', 'message'=>'请输入密码'),
            array('vericode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'message'=>'验证码错误'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'sid'=>'店铺id',
            'pass'=>'密码',
            'vericode'=>'验证码',
        );
    }

}