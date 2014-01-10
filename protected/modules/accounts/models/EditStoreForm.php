<?php

class EditStoreForm extends CFormModel{

    public $sid;
	public $newname;
	public $vericode;

	public function rules()
    {
        return array(
            array('sid', 'required', 'message'=>'请输入店铺的id'),
            array('newname', 'required', 'message'=>'请输入新的店铺名称'),
            array('vericode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(), 'message'=>'验证码错误'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'sid'=>'店铺id',
            'newname'=>'店铺名称',
            'vericode'=>'验证码',
        );
    }


}