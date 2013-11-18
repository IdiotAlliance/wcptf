<?php

/**
 * ModifyOrderItemForm class.
 * ModifyOrderItemForm is the data structure for keeping
 * user orderHeader form data. It is used by the 'modify' action of 'orderdetail'.
 */
class ModifyOrderItemForm extends CFormModel
{
	public $orderId;
	public $phone;
	public $total;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('phone', 'required'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'poster'=>'',
		);
	}
}
