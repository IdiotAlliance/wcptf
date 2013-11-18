<?php

/**
 * ModifyOrderHeaderForm class.
 * ModifyOrderHeaderForm is the data structure for keeping
 * user order item form data. It is used by the 'modify' action of 'OrderDetail'.
 */
class ModifyOrderHeaderForm extends CFormModel
{
	public $orderId;
	public $username;
	public $phone;
	public $desc;
	public $total;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			
			//array('poster', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>'姓名：',
			'phone'=>'电话：',
			'desc'=>'备注：',
			'total'=>'总价：',
		);
	}
	
	public function modify($orderId){
		$order = OrdersAR::model()->findByPk($orderId);
		if(empty($order)){
			$order->order_name = $this->name;
			$order->phone = $this->phone;
			$order->description = $this->desc;
			$order->total = $this->total;
			$order->update();
			return true;
		}else{
			return false;
		}
	}
}
