<?php

/**
 * @author lvxiang
 */
class SellerProfileForm extends CFormModel{

	public $store_name; // 店铺名称
	public $store_type; // 店铺类型
	public $phone; // 订餐电话
	public $stime; // 营业的开始时间
	public $etime; // 营业的结束时间
	public $store_address; // 店铺地址
	public $logo; // logo的图片id
	public $store_env; // 店铺环境图片
	public $start_price; // 起送价格
	public $takeaway_fee; // 外送费用
	public $threshold; // 免外送费用阈值
	public $estimated_time; // 预计送达所花费的时间
	
	public function rules()
	{
		return array(
				array('store_name', 'required', 'message'=>'请输入店铺名称'),
				array('store_name', 'length', 'max'=>128, 'tooLong'=>'店铺名称过长'),
				array('phone', 'required', 'message'=>'请输入您的订餐电话'),
				array('store_address', 'length', 'max'=>256, 'tooLong'=>'店铺的地址过长'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'store_name'=>'店铺名称',
			'store_type'=>'店铺类型',
			'phone'=>'点单电话',
			'store_address'=>'店铺地址',
			'logo'=>'logo',
			'store_env'=>'店内环境',
			'start_price'=>'起送价格',
			'takeaway_fee'=>'外卖费',
			'threshold'=>'超过该价格免收外卖费',
			'estimated_time'=>'预计时间',
			'stime'=>'开始营业时间',
			'etime'=>'结束营业时间',
		);
	}
	
	public function updateUser($userId){
		$user = UsersAR::model()->getUserById($userId);
		$user->store_name = $this->store_name;
		$user->phone = $this->phone;
		$user->stime = $this->stime;
		$user->etime = $this->etime;
		$user->store_address = $this->store_address;
		$user->logo = $this->logo;
		$user->start_price = $this->start_price;
		$user->takeaway_fee = $this->takeaway_fee;
		$user->threshold = $this->threshold;
		$user->estimated_time = $this->estimated_time;
		$user->save();
		return $user;
	}
	
	public function setValues($user){
		if($user != null){
			$this->store_name = $user->store_name;
			$this->phone = $user->phone;
			$this->stime = $user->stime;
			$this->etime = $user->etime;
			$this->store_address = $user->store_address;
			$this->logo = $user->logo;
			$this->start_price = $user->start_price;
			$this->takeaway_fee = $user->takeaway_fee;
			$this->threshold = $user->threshold;
			$this->estimated_time = $user->estimated_time;
		}
	}
}