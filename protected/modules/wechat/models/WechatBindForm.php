<?php
/**
 * 
 * @author lvxiang
 *
 */
class WechatBindForm extends CFormModel{
	public $wechat_id; // 微信号
	public $token; // token
	public $wechat_url; // 回调地址
	public $store_name; // 店铺名称
	
	public function rules()
	{
		return array(
				array('wechat_id', 'required', 'message'=>'请输入您的微信号'),
				array('store_name', 'required', 'message'=>'请输入店铺名称'),
				array('store_name', 'length', 'max'=>128, 'tooLong'=>'店铺名称过长'),
				array('token', 'required', 'message'=>'请输入3-32位的字符或数字作为token'),
				array('token', 'match', 'pattern'=>'/^[0-9a-zA-Z]{3,32}$/', 'message'=>'请输入3-32位的字符或数字作为token'),
		);
	}
	
	public function attributeLabels()
	{
		return array(
				'store_name'=>'店铺名称',
				'wechat_id'=>'微信号',
				'token'=>'token',
				'wechat_url'=>'回调地址',
		);
	}
	
	public function updateUser($user){
		if($user != null){
			$user->wechat_id  = $this->wechat_id;
			$user->wechat_url = $this->wechat_url;
			$user->token      = $this->token;
			$user->store_name = $this->store_name;
			$user->save();
		}
	}
	
	public function bindComplete($user){
		if($user != null){
			return $user->wechat_id && $user->wechat_url && $user->token && $user->store_name;
		}
		return false;
	}
}