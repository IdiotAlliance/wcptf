<?php

/**
 * OrderAddItemForm class.
 * OrderAddItemForm is the data structure for keeping
 * user orderItem form data. It is used by the 'create' action of 'order items'.
 */
class OrderAddItemForm extends CFormModel
{
	public $productId;
	public $num;

	public function rules()
	{
		return array(
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			
		);
	}
}
